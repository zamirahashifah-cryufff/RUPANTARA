/* Scanner AI refactor for camera and upload modes */

document.addEventListener('DOMContentLoaded', () => {
  const imageUploadInput = document.getElementById('imageUploadInput');
  const captureBtn = document.getElementById('captureBtn');
  const scannerPreviewImg = document.getElementById('scannerPreviewImg');
  const statusText = document.getElementById('statusText');
  const videoPreview = document.getElementById('cameraStream');
  const rescanBtn = document.getElementById('rescanBtn');
  const scannerOverlay = document.getElementById('scannerStatusOverlay');

  const SCANNER_MODE = {
    IDLE: 'idle',
    CAMERA: 'camera',
    UPLOAD: 'upload',
    PROCESSING: 'processing',
    RESULT: 'result',
    ERROR: 'error'
  };

  const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
  const MAX_IMAGE_SIZE = 5 * 1024 * 1024;
  const MIN_CONFIDENCE = 0.7;
  const MIN_MARGIN = 0.15;

  const MODEL_BASE_PATH = 'model/tm-my-image-model (1)/';
  const MODEL_URL = encodeURI(`${MODEL_BASE_PATH}model.json`);
  const METADATA_URL = encodeURI(`${MODEL_BASE_PATH}metadata.json`);

  let scannerMode = SCANNER_MODE.IDLE;
  let tmModel = null;
  let modelLabels = [];
  let cameraStream = null;
  let uploadedImageElement = null;
  let capturedCanvas = null;

  function setStatus(text, variant = 'info') {
    if (!statusText) return;
    statusText.textContent = text;
    if (!scannerOverlay) return;
    scannerOverlay.classList.remove('ai-error', 'ai-processing', 'ai-success', 'ai-camera-active');
    if (variant === 'error') scannerOverlay.classList.add('ai-error');
    if (variant === 'processing') scannerOverlay.classList.add('ai-processing');
    if (variant === 'success') scannerOverlay.classList.add('ai-success');
    if (variant === 'camera') scannerOverlay.classList.add('ai-camera-active');
  }

  function setCaptureButton(text, disabled = false) {
    if (!captureBtn) return;
    captureBtn.innerHTML = text;
    captureBtn.disabled = disabled;
    captureBtn.style.minHeight = '44px';
  }

  function setRescanButton(visible) {
    if (!rescanBtn) return;
    rescanBtn.style.display = visible ? 'inline-flex' : 'none';
  }

  function hideAllMedia() {
    if (videoPreview) {
      videoPreview.style.display = 'none';
      videoPreview.classList.add('camera-stream-hidden');
      videoPreview.srcObject = null;
    }
    if (scannerPreviewImg) {
      scannerPreviewImg.style.display = 'none';
      scannerPreviewImg.src = '';
    }
  }

  function resetResultCard() {
    const elements = [
      'resNominalGiant',
      'resJenisTag',
      'resHeroNameTitle',
      'resHeroBioText',
      'resFaktaList',
      'resCiriKeaslianList',
      'resMaknaVisualList'
    ];

    elements.forEach((id) => {
      const el = document.getElementById(id);
      if (el) {
        if (el.tagName === 'UL') {
          el.innerHTML = '';
        } else {
          el.textContent = '';
        }
      }
    });
  }

  function buildRupiahDataMap() {
    const map = {};
    const banknotes = (window.rupantaraData && window.rupantaraData.banknotes) || [];
    banknotes.forEach((note) => {
      if (!note) return;
      if (note.nominalFormatted) {
        map[note.nominalFormatted] = note;
      }
      if (note.id) {
        const numericLabel = `Rp${Number(note.id).toLocaleString('id-ID')}`;
        if (!map[numericLabel]) map[numericLabel] = note;
      }
    });
    return map;
  }

  function normalizeLabelToRp(rawLabel) {
    if (!rawLabel) return rawLabel;
    const trimmed = String(rawLabel).trim();

    // If metadata labels are available, prefer deterministic mapping
    if (Array.isArray(modelLabels) && modelLabels.length > 0) {
      // Try exact match first
      const exact = modelLabels.find(l => String(l).trim() === trimmed);
      if (exact) return `Rp${String(exact).trim()}`;

      // Try matching after removing non-digits (allows labels like "Rp100.000" vs "100.000")
      const digitsOnly = trimmed.replace(/[^0-9.]/g, '');
      const metaMatch = modelLabels.find(l => String(l).replace(/[^0-9.]/g, '') === digitsOnly);
      if (metaMatch) return `Rp${String(metaMatch).trim()}`;
    }

    // Fallback: best-effort normalization (kept for backward compatibility)
    const cleaned = trimmed.replace(/[^0-9.,]/g, '').replace(/,/g, '.');
    if (!cleaned) return rawLabel;
    if (/^\d+\.\d+$/.test(cleaned)) return `Rp${cleaned}`;
    const value = Number(cleaned);
    if (Number.isFinite(value)) return `Rp${value.toLocaleString('id-ID')}`;
    return `Rp${cleaned}`;
  }

  function getNoteInfo(labelRp) {
    const rupiahData = buildRupiahDataMap();
    return rupiahData[labelRp] || null;
  }

  function applyVideoVisibleStyles(videoEl) {
    videoEl.style.display = 'block';
    videoEl.style.visibility = 'visible';
    videoEl.style.opacity = '1';
    videoEl.style.position = 'absolute';
    videoEl.style.inset = '0';
    videoEl.style.width = '100%';
    videoEl.style.height = '100%';
    videoEl.style.objectFit = 'cover';
    videoEl.style.zIndex = '10';
    try {
      videoEl.classList.remove('camera-stream-hidden');
    } catch (e) {}
  }

  function stopCamera() {
    if (cameraStream) {
      cameraStream.getTracks().forEach((track) => track.stop());
      cameraStream = null;
    }
    if (videoPreview) {
      videoPreview.srcObject = null;
      videoPreview.style.display = 'none';
      videoPreview.classList.add('camera-stream-hidden');
    }
  }

  function showUploadPreview(dataUrl) {
    if (!scannerPreviewImg) return;
    stopCamera();
    scannerPreviewImg.src = dataUrl;
    scannerPreviewImg.style.display = 'block';
    scannerPreviewImg.style.opacity = '1';
    scannerPreviewImg.style.visibility = 'visible';
    scannerMode = SCANNER_MODE.UPLOAD;
    setCaptureButton('Scan Foto', false);
    setRescanButton(false);
    setStatus('Foto siap. Tekan Scan Foto untuk mengenali.', 'info');
  }

  function showResultImage(dataUrl) {
    if (!scannerPreviewImg) return;
    scannerPreviewImg.src = dataUrl;
    scannerPreviewImg.style.display = 'block';
    scannerPreviewImg.style.opacity = '1';
    scannerPreviewImg.style.visibility = 'visible';
  }

  function resizeSourceToCanvas(source, maxSize = 1280) {
    const width = source.videoWidth || source.naturalWidth || 640;
    const height = source.videoHeight || source.naturalHeight || 480;
    if (!width || !height) return null;
    const ratio = Math.min(maxSize / width, maxSize / height, 1);
    const canvas = document.createElement('canvas');
    canvas.width = Math.round(width * ratio);
    canvas.height = Math.round(height * ratio);
    const ctx = canvas.getContext('2d');
    ctx.drawImage(source, 0, 0, canvas.width, canvas.height);
    return canvas;
  }

  async function loadTMModel() {
    if (tmModel) return tmModel;
    setStatus('Memuat model AI...', 'processing');
    try {
      tmModel = await tmImage.load(MODEL_URL, METADATA_URL);
      // Read metadata.json to obtain canonical class labels (do not guess)
      try {
        const res = await fetch(METADATA_URL);
        if (res.ok) {
          const meta = await res.json();
          if (Array.isArray(meta.labels)) {
            modelLabels = meta.labels.map(l => String(l).trim());
          }
        }
      } catch (metaErr) {
        console.warn('Gagal membaca metadata model:', metaErr);
      }
      setStatus('Model AI siap.', 'success');
      return tmModel;
    } catch (error) {
      console.error('Gagal memuat model:', error);
      setStatus('Gagal memuat model AI. Pastikan menjalankan lewat Live Server.', 'error');
      throw error;
    }
  }

  async function startCamera() {
    setStatus('Membuka kamera...', 'processing');
    setCaptureButton('Sedang membuka kamera...', true);
    scannerMode = SCANNER_MODE.PROCESSING;
    try {
      const stream = await navigator.mediaDevices.getUserMedia({
        video: {
          facingMode: { ideal: 'environment' },
          width: { ideal: 1280 },
          height: { ideal: 720 }
        },
        audio: false
      });
      cameraStream = stream;
      if (videoPreview) {
        videoPreview.srcObject = stream;
        videoPreview.autoplay = true;
        videoPreview.muted = true;
        videoPreview.playsInline = true;
        applyVideoVisibleStyles(videoPreview);
        await videoPreview.play();
      }
      if (scannerPreviewImg) scannerPreviewImg.style.display = 'none';
      scannerMode = SCANNER_MODE.CAMERA;
      setCaptureButton('ðŸ“¸ Jepret & Scan', false);
      setStatus('â— Kamera aktif Â· Arahkan uang ke dalam bingkai.', 'camera');
    } catch (error) {
      console.error('getUserMedia error:', error);
      stopCamera();
      scannerMode = SCANNER_MODE.ERROR;
      setCaptureButton('<i class="fa-solid fa-camera"></i> Jepret', false);
      if (error.name === 'NotAllowedError' || error.name === 'SecurityError') {
        setStatus('Kamera tidak dapat diakses. Pastikan izin kamera telah diberikan.', 'error');
      } else if (error.name === 'NotFoundError' || error.name === 'OverconstrainedError') {
        setStatus('Kamera belakang tidak tersedia di perangkat ini.', 'error');
      } else {
        setStatus('Kamera tidak dapat dijalankan. Coba refresh halaman.', 'error');
      }
    }
  }

  function renderResult(note, labelRp, confidence, isCertain, imageSrc) {
    const resNominalGiant = document.getElementById('resNominalGiant');
    const resJenisTag = document.getElementById('resJenisTag');
    const resBanknoteImg = document.getElementById('resBanknoteImg');
    const resMaknaVisualList = document.getElementById('resMaknaVisualList');
    const resHeroNameTitle = document.getElementById('resHeroNameTitle');
    const resHeroBioText = document.getElementById('resHeroBioText');
    const resFaktaList = document.getElementById('resFaktaList');
    const resCiriKeaslianList = document.getElementById('resCiriKeaslianList');

    const confidencePercent = Math.round(confidence * 100);
    if (resNominalGiant) resNominalGiant.textContent = isCertain ? labelRp : 'Belum yakin';
    if (resJenisTag) resJenisTag.textContent = isCertain ? (note?.jenis || 'Rupiah Kertas') : 'Coba ulangi scan';
    if (resBanknoteImg && imageSrc) resBanknoteImg.src = imageSrc;

    if (isCertain && note) {
      const tokoh = note.tokoh || note.pahlawan || '';
      const sejarah = note.sejarah || note.sejarahTokoh || '';
      const maknaVisual = note.maknaVisual || [];
      const ciriKeaslian = note.ciriKeaslian || [];
      const fakta = note.faktaMenarik || [];

      if (resHeroNameTitle) resHeroNameTitle.textContent = tokoh;
      if (resHeroBioText) resHeroBioText.textContent = sejarah;
      if (resFaktaList) resFaktaList.innerHTML = fakta.length ? fakta.map((item) => `<li>${item}</li>`).join('') : '<li>Informasi pecahan ini belum tersedia.</li>';
      if (resCiriKeaslianList) resCiriKeaslianList.innerHTML = ciriKeaslian.length ? ciriKeaslian.map((item) => `<li>${item.title || item}</li>`).join('') : '<li>Informasi pecahan ini belum tersedia.</li>';
      if (resMaknaVisualList) resMaknaVisualList.innerHTML = maknaVisual.length ? maknaVisual.map((item) => `<li>${item.text || item}</li>`).join('') : '<li>Informasi pecahan ini belum tersedia.</li>';
    } else {
      if (resHeroNameTitle) resHeroNameTitle.textContent = '';
      if (resHeroBioText) resHeroBioText.textContent = '';
      if (resFaktaList) resFaktaList.innerHTML = '<li>Informasi pecahan ini belum tersedia.</li>';
      if (resCiriKeaslianList) resCiriKeaslianList.innerHTML = '<li>Informasi pecahan ini belum tersedia.</li>';
      if (resMaknaVisualList) resMaknaVisualList.innerHTML = '<li>Informasi belum tersedia.</li>';
    }

    if (isCertain) {
      setStatus(`AI yakin: ${confidencePercent}% Â· âœ“ Cukup yakin`, 'success');
    } else {
      setStatus(`AI yakin: ${confidencePercent}% Â· âš  Kurang yakin. Coba scan ulang.`, 'error');
    }
    setRescanButton(true);
    scannerMode = SCANNER_MODE.RESULT;
  }

  function clearResultState() {
    resetResultCard();
    setRescanButton(false);
    setStatus('Model AI siap. Klik Jepret untuk memulai.', 'info');
  }

  async function analyzeUploadImage() {
    if (!uploadedImageElement) {
      setStatus('Tolong pilih file gambar terlebih dahulu.', 'error');
      return;
    }
    if (!tmModel) {
      await loadTMModel();
    }
    setStatus('AI sedang mengenali pecahan...', 'processing');
    setCaptureButton('Memproses...', true);
    scannerMode = SCANNER_MODE.PROCESSING;

    try {
      const processedCanvas = resizeSourceToCanvas(uploadedImageElement);
      if (!processedCanvas) throw new Error('Gagal memproses gambar');
      capturedCanvas = processedCanvas;
      const predictions = await tmModel.predict(processedCanvas);
      if (!Array.isArray(predictions) || predictions.length === 0) {
        throw new Error('Prediksi kosong');
      }
      const sortedPredictions = [...predictions].sort((a, b) => b.probability - a.probability);
      const top = sortedPredictions[0];
      const second = sortedPredictions[1] || { probability: 0 };
      const topProbability = top.probability || 0;
      const secondProbability = second.probability || 0;
      const labelRp = normalizeLabelToRp(top.className || top.label || '');
      const note = getNoteInfo(labelRp);
      const isCertain = topProbability >= MIN_CONFIDENCE && (topProbability - secondProbability) >= MIN_MARGIN && !!note;
      renderResult(note, labelRp, topProbability, isCertain, uploadedImageElement.src);
    } catch (error) {
      console.error('Upload prediction error:', error);
      setStatus('Scan gagal. Pastikan gambar jelas dan ulangi.', 'error');
    } finally {
      setCaptureButton('Scan Foto', false);
    }
  }

  async function analyzeCameraFrame() {
    if (!videoPreview) return;
    if (!tmModel) {
      await loadTMModel();
    }
    setStatus('Mengambil gambar...', 'processing');
    setCaptureButton('Memproses...', true);
    scannerMode = SCANNER_MODE.PROCESSING;

    try {
      const processedCanvas = resizeSourceToCanvas(videoPreview);
      if (!processedCanvas) throw new Error('Gagal menangkap frame kamera');
      capturedCanvas = processedCanvas;
      const dataUrl = processedCanvas.toDataURL('image/jpeg');
      const predictions = await tmModel.predict(processedCanvas);
      if (!Array.isArray(predictions) || predictions.length === 0) {
        throw new Error('Prediksi kosong');
      }
      const sortedPredictions = [...predictions].sort((a, b) => b.probability - a.probability);
      const top = sortedPredictions[0];
      const second = sortedPredictions[1] || { probability: 0 };
      const topProbability = top.probability || 0;
      const secondProbability = second.probability || 0;
      const labelRp = normalizeLabelToRp(top.className || top.label || '');
      const note = getNoteInfo(labelRp);
      const isCertain = topProbability >= MIN_CONFIDENCE && (topProbability - secondProbability) >= MIN_MARGIN && !!note;
      stopCamera();
      showResultImage(dataUrl);
      renderResult(note, labelRp, topProbability, isCertain, dataUrl);
    } catch (error) {
      console.error('Camera prediction error:', error);
      stopCamera();
      setStatus('Scan gagal. Pastikan posisi uang jelas dan ulangi.', 'error');
      setCaptureButton('ðŸ“¸ Jepret & Scan', false);
    }
  }

  function setupUploadInput() {
    if (!imageUploadInput) return;
    imageUploadInput.addEventListener('change', (event) => {
      const file = event.target.files && event.target.files[0];
      if (!file) return;
      if (!ALLOWED_IMAGE_TYPES.includes(file.type)) {
        setStatus('Tolong pilih file gambar JPEG, PNG, atau WEBP.', 'error');
        return;
      }
      if (file.size > MAX_IMAGE_SIZE) {
        setStatus('File terlalu besar. Gunakan gambar di bawah 5MB.', 'error');
        return;
      }
      const reader = new FileReader();
      reader.onload = () => {
        const dataUrl = reader.result;
        if (!dataUrl || typeof dataUrl !== 'string') {
          setStatus('Gagal membaca file. Coba ulangi.', 'error');
          return;
        }
        uploadedImageElement = new Image();
        uploadedImageElement.onload = () => {
          showUploadPreview(dataUrl);
          setStatus('Foto siap. Tekan Scan Foto untuk mengenali.', 'info');
          setCaptureButton('Scan Foto', false);
        };
        uploadedImageElement.onerror = () => {
          setStatus('Gagal memuat gambar. Pilih file lain.', 'error');
        };
        uploadedImageElement.src = dataUrl;
      };
      reader.onerror = () => {
        setStatus('Gagal membaca file. Coba lagi.', 'error');
      };
      reader.readAsDataURL(file);
    });
  }

  function handleCaptureButton() {
    if (!captureBtn) return;
    captureBtn.addEventListener('click', async () => {
      if (scannerMode === SCANNER_MODE.UPLOAD) {
        await analyzeUploadImage();
        return;
      }
      if (scannerMode === SCANNER_MODE.CAMERA) {
        await analyzeCameraFrame();
        return;
      }
      if (scannerMode === SCANNER_MODE.RESULT || scannerMode === SCANNER_MODE.IDLE || scannerMode === SCANNER_MODE.ERROR) {
        await startCamera();
        return;
      }
    });
  }

  function setupRescanButton() {
    if (!rescanBtn) return;
    rescanBtn.addEventListener('click', async () => {
      clearResultState();
      await startCamera();
    });
  }

  function setupDismissButton() {
    const dismissBtn = document.getElementById('dismissStatusBtn');
    if (!dismissBtn) return;
    dismissBtn.addEventListener('click', () => {
      if (scannerOverlay) scannerOverlay.classList.add('hidden');
    });
  }

  function initializeScanner() {
    hideAllMedia();
    resetResultCard();
    setRescanButton(false);
    setCaptureButton('<i class="fa-solid fa-camera"></i> Jepret', true);
    setStatus('Memuat model AI...', 'processing');
    if (scannerPreviewImg) {
      scannerPreviewImg.style.display = 'none';
      scannerPreviewImg.src = '';
    }
    loadTMModel().then(() => {
      setCaptureButton('<i class="fa-solid fa-camera"></i> Jepret', false);
      setStatus('Model AI siap. Klik Jepret untuk memulai.', 'success');
      scannerMode = SCANNER_MODE.IDLE;
    }).catch(() => {
      setCaptureButton('<i class="fa-solid fa-camera"></i> Jepret', true);
      scannerMode = SCANNER_MODE.ERROR;
    });
  }

  setupUploadInput();
  handleCaptureButton();
  setupRescanButton();
  setupDismissButton();
  initializeScanner();
});
