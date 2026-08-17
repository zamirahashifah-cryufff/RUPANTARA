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

  const DENOMINATION_MODEL_BASE_PATH = 'model/tm-my-image-model_old/';
  const MODEL_URL = encodeURI(`${DENOMINATION_MODEL_BASE_PATH}model.json`);
  const METADATA_URL = encodeURI(`${DENOMINATION_MODEL_BASE_PATH}metadata.json`);
  const CONDITION_MODEL_URL = './tfjs_model/model.json';
  const DENOMINATION_CONFIDENCE_THRESHOLD = 0.60;

  let scannerMode = SCANNER_MODE.IDLE;
  let tmModel = null;
  let conditionModel = null;
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

  function normalizeDenominationLabel(rawLabel) {
    if (!rawLabel) return null;

    const text = String(rawLabel).trim().toLowerCase();
    const digits = text.replace(/[^0-9]/g, '');

    if (!digits) return null;

    const value = Number(digits);
    if (!Number.isFinite(value) || value <= 0) return null;

    const allowedNominals = [1000, 2000, 5000, 10000, 20000, 50000, 100000];
    if (!allowedNominals.includes(value)) {
      return null;
    }

    return `Rp${value.toLocaleString('id-ID')}`;
  }

  function normalizeLabelToRp(rawLabel) {
    if (!rawLabel) return rawLabel;

    const direct = normalizeDenominationLabel(rawLabel);
    if (direct) return direct;

    const trimmed = String(rawLabel).trim();
    const candidates = [
      trimmed,
      trimmed.replace(/^Rp/i, ''),
      trimmed.replace(/\s+/g, ''),
      trimmed.toUpperCase()
    ];

    for (const candidate of candidates) {
      const digitsOnly = candidate.replace(/[^0-9]/g, '');
      if (!digitsOnly) continue;
      const normalized = Number(digitsOnly);
      if (Number.isFinite(normalized) && normalized > 0) {
        const allowed = [1000, 2000, 5000, 10000, 20000, 50000, 100000];
        if (allowed.includes(normalized)) {
          return `Rp${normalized.toLocaleString('id-ID')}`;
        }
      }
    }

    if (Array.isArray(modelLabels) && modelLabels.length > 0) {
      const exact = modelLabels.find((l) => String(l).trim().toLowerCase() === trimmed.toLowerCase());
      if (exact) {
        const normalized = normalizeDenominationLabel(exact);
        if (normalized) return normalized;
      }

      const metaMatch = modelLabels.find((l) => String(l).replace(/[^0-9]/g, '') === trimmed.replace(/[^0-9]/g, ''));
      if (metaMatch) {
        const normalized = normalizeDenominationLabel(metaMatch);
        if (normalized) return normalized;
      }
    }

    return null;
  }

  function parsePredictionLabel(label) {
    const raw = String(label || '').trim();
    if (!raw) {
      return { nominal: null, condition: null, rawLabel: '', isRupiahLabel: false, isConditionLabel: false };
    }

    const cleaned = raw.replace(/\s+/g, ' ');
    const lower = cleaned.toLowerCase();

    const conditionMap = {
      layak: 'Layak Edar',
      layak_edar: 'Layak Edar',
      'layak edar': 'Layak Edar',
      lusuh: 'Lusuh',
      rusak: 'Lusuh',
      baik: 'Layak Edar',
      tidak_layak: 'Lusuh'
    };

    const normalizedCondition = Object.keys(conditionMap).find((key) => lower.includes(key));
    if (normalizedCondition) {
      const nominal = normalizeLabelToRp(cleaned.replace(/_(?:layak|lusuh|baik|rusak|layak edar|tidak_layak)|\b(?:layak|lusuh|baik|rusak|layak edar|tidak_layak)\b/gi, ''));
      return {
        nominal: nominal || null,
        condition: conditionMap[normalizedCondition],
        rawLabel: cleaned,
        isRupiahLabel: !!nominal,
        isConditionLabel: true
      };
    }

    const nominal = normalizeLabelToRp(cleaned);
    if (nominal) {
      return {
        nominal,
        condition: null,
        rawLabel: cleaned,
        isRupiahLabel: true,
        isConditionLabel: false
      };
    }

    return {
      nominal: null,
      condition: null,
      rawLabel: cleaned,
      isRupiahLabel: false,
      isConditionLabel: false
    };
  }

  function normalizeNominal(rawLabel) {
    const parsed = parsePredictionLabel(rawLabel);
    return parsed.nominal;
  }

  function getNoteInfo(labelRp) {
    const rupiahData = buildRupiahDataMap();
    return rupiahData[labelRp] || null;
  }

  function applyVideoVisibleStyles(videoEl) {
    if (!videoEl) return;
    videoEl.style.display = 'block';
    videoEl.style.visibility = 'visible';
    videoEl.style.opacity = '1';
    videoEl.style.position = 'absolute';
    videoEl.style.inset = '0';
    videoEl.style.left = '0';
    videoEl.style.top = '0';
    videoEl.style.right = '0';
    videoEl.style.bottom = '0';
    videoEl.style.width = '100%';
    videoEl.style.height = '100%';
    videoEl.style.maxWidth = 'none';
    videoEl.style.maxHeight = 'none';
    videoEl.style.minWidth = '100%';
    videoEl.style.minHeight = '100%';
    videoEl.style.margin = '0';
    videoEl.style.padding = '0';
    videoEl.style.objectFit = 'cover';
    videoEl.style.objectPosition = 'center center';
    videoEl.style.transform = 'none';
    videoEl.style.zIndex = '1';
    videoEl.style.borderRadius = 'inherit';
    try {
      videoEl.classList.remove('camera-stream-hidden');
    } catch (e) {}

    const viewport = document.getElementById('scannerViewport');
    console.log('[CAMERA] viewport:', {
      width: viewport ? viewport.clientWidth : null,
      height: viewport ? viewport.clientHeight : null
    });
    console.log('[CAMERA] video:', {
      clientWidth: videoEl.clientWidth,
      clientHeight: videoEl.clientHeight,
      videoWidth: videoEl.videoWidth,
      videoHeight: videoEl.videoHeight,
      display: getComputedStyle(videoEl).display,
      objectFit: getComputedStyle(videoEl).objectFit
    });
  }

  function applyImagePreviewStyles(imageEl) {
    if (!imageEl) return;
    imageEl.style.display = 'block';
    imageEl.style.visibility = 'visible';
    imageEl.style.opacity = '1';
    imageEl.style.position = 'absolute';
    imageEl.style.inset = '0';
    imageEl.style.width = '100%';
    imageEl.style.height = '100%';
    imageEl.style.maxWidth = 'none';
    imageEl.style.maxHeight = 'none';
    imageEl.style.objectFit = 'cover';
    imageEl.style.objectPosition = 'center center';
    imageEl.style.borderRadius = 'inherit';
    imageEl.style.transform = 'none';
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
    applyImagePreviewStyles(scannerPreviewImg);
    scannerMode = SCANNER_MODE.UPLOAD;
    setCaptureButton('Scan Foto', false);
    setRescanButton(false);
    setStatus('Foto siap. Tekan Scan Foto untuk mengenali.', 'info');
  }

  function showResultImage(dataUrl) {
    if (!scannerPreviewImg) return;
    scannerPreviewImg.src = dataUrl;
    applyImagePreviewStyles(scannerPreviewImg);
  }

  function resizeSourceToCanvas(source, maxSize = 1280) {
    const width = source.videoWidth || source.naturalWidth || 640;
    const height = source.videoHeight || source.naturalHeight || 480;
    if (!width || !height) return null;

    const viewport = document.getElementById('scannerViewport');
    const viewportWidth = viewport ? viewport.clientWidth || width : width;
    const viewportHeight = viewport ? viewport.clientHeight || height : height;

    const sourceRatio = width / height;
    const viewportRatio = viewportWidth / Math.max(viewportHeight, 1);

    let cropX = 0;
    let cropY = 0;
    let cropWidth = width;
    let cropHeight = height;

    if (sourceRatio > viewportRatio) {
      cropHeight = height;
      cropWidth = height * viewportRatio;
      cropX = (width - cropWidth) / 2;
    } else {
      cropWidth = width;
      cropHeight = width / viewportRatio;
      cropY = (height - cropHeight) / 2;
    }

    const canvas = document.createElement('canvas');
    canvas.width = Math.round(Math.min(viewportWidth, width));
    canvas.height = Math.round(Math.min(viewportHeight, height));

    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(
      source,
      Math.round(cropX),
      Math.round(cropY),
      Math.round(cropWidth),
      Math.round(cropHeight),
      0,
      0,
      canvas.width,
      canvas.height
    );

    if (width > maxSize || height > maxSize) {
      const ratio = Math.min(maxSize / width, maxSize / height, 1);
      const scaledCanvas = document.createElement('canvas');
      scaledCanvas.width = Math.round(canvas.width * ratio);
      scaledCanvas.height = Math.round(canvas.height * ratio);
      const scaledCtx = scaledCanvas.getContext('2d');
      scaledCtx.drawImage(canvas, 0, 0, scaledCanvas.width, scaledCanvas.height);
      return scaledCanvas;
    }

    return canvas;
  }

  async function loadTMModel() {
    if (tmModel) return tmModel;
    console.log('[AI] Loading denomination model...', MODEL_URL);
    setStatus('Memuat model nominal...', 'processing');
    try {
      tmModel = await tmImage.load(MODEL_URL, METADATA_URL);

      try {
        const res = await fetch(METADATA_URL);
        if (res.ok) {
          const meta = await res.json();
          if (Array.isArray(meta.labels)) {
            modelLabels = meta.labels.map((l) => String(l).trim());
            console.log('[DENOMINATION MODEL] Classes:', modelLabels);
          } else {
            console.warn('[ERROR] Denomination metadata failed to load. Labels missing.');
          }
        } else {
          console.error('[ERROR] Denomination metadata failed to load:', METADATA_URL);
        }
      } catch (metaErr) {
        console.error('[ERROR] Denomination metadata failed to load:', metaErr);
      }

      console.log('[AI] Denomination model loaded.');
      setStatus('Model nominal siap.', 'success');
      return tmModel;
    } catch (error) {
      console.error('[ERROR] Denomination model failed to load:', MODEL_URL, error);
      setStatus('Gagal memuat model nominal. Silakan cek path model dan metadata.', 'error');
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
      setCaptureButton('<i class="fa-solid fa-camera"></i> Jepret', false);
      setStatus('Kamera aktif · Arahkan uang ke dalam bingkai.', 'camera');
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

  function renderResult(note, labelRp, confidence, isCertain, imageSrc, conditionText = '') {
    const resNominalGiant = document.getElementById('resNominalGiant');
    const resJenisTag = document.getElementById('resJenisTag');
    const resConditionTag = document.getElementById('resConditionTag');
    const resBanknoteImg = document.getElementById('resBanknoteImg');
    const resMaknaVisualList = document.getElementById('resMaknaVisualList');
    const resHeroNameTitle = document.getElementById('resHeroNameTitle');
    const resHeroBioText = document.getElementById('resHeroBioText');
    const resFaktaList = document.getElementById('resFaktaList');
    const resCiriKeaslianList = document.getElementById('resCiriKeaslianList');

    const confidencePercent = Math.round(confidence * 100);
    const finalLabel = isCertain && note && labelRp ? labelRp : 'Nominal belum dikenali.';
    if (resNominalGiant) resNominalGiant.textContent = finalLabel;
    if (resJenisTag) resJenisTag.textContent = isCertain && note ? (note?.jenis || 'Rupiah Kertas') : 'AI belum yakin';
    if (resConditionTag) {
      if (conditionText) {
        resConditionTag.textContent = conditionText;
        resConditionTag.style.display = 'inline-block';
      } else {
        resConditionTag.textContent = 'Kondisi uang belum dapat dianalisis.';
        resConditionTag.style.display = 'inline-block';
      }
    }
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
      if (resHeroNameTitle) resHeroNameTitle.textContent = 'Nominal belum dikenali';
      if (resHeroBioText) resHeroBioText.textContent = 'Coba arahkan uang lebih jelas dan scan kembali.';
      if (resFaktaList) resFaktaList.innerHTML = '<li>Informasi pecahan ini belum tersedia.</li>';
      if (resCiriKeaslianList) resCiriKeaslianList.innerHTML = '<li>Informasi pecahan ini belum tersedia.</li>';
      if (resMaknaVisualList) resMaknaVisualList.innerHTML = '<li>Informasi belum tersedia.</li>';
    }

    if (isCertain && note) {
      setStatus(`AI yakin: ${confidencePercent}% · Hasil ditemukan.`, 'success');
    } else {
      setStatus('AI belum yakin dengan hasil scan. Kondisi uang belum dapat dianalisis.', 'error');
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
      console.table(sortedPredictions);
      const top = sortedPredictions[0];
      const second = sortedPredictions[1] || { probability: 0 };
      const topProbability = Number(top.probability || 0);
      const secondProbability = Number(second.probability || 0);
      const modelLabel = top.className || top.label || '';
      console.log('[DENOMINATION] Raw label:', modelLabel);
      console.log('[DENOMINATION] Probability:', topProbability);

      const parsed = parsePredictionLabel(modelLabel);
      const labelRp = normalizeLabelToRp(modelLabel) || parsed.nominal || null;
      console.log('[AI] Raw prediction:', modelLabel);
      console.log('[AI] Normalized denomination:', labelRp);

      const note = labelRp ? getNoteInfo(labelRp) : null;
      console.log('[AI] rupiahData match:', note);

      const isConfidenceOk = topProbability >= DENOMINATION_CONFIDENCE_THRESHOLD;
      const isCertain = isConfidenceOk && (topProbability - secondProbability) >= MIN_MARGIN && !!note;
      const conditionText = parsed.condition ? `Kondisi: ${parsed.condition}` : 'Kondisi uang belum dapat dianalisis.';

      if (!isConfidenceOk && labelRp) {
        console.warn('[AI] Low denomination confidence, not accepting as final result:', topProbability);
      }

      renderResult(note, labelRp, topProbability, isCertain, uploadedImageElement.src, conditionText);
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
      console.table(sortedPredictions);
      const top = sortedPredictions[0];
      const second = sortedPredictions[1] || { probability: 0 };
      const topProbability = Number(top.probability || 0);
      const secondProbability = Number(second.probability || 0);
      const modelLabel = top.className || top.label || '';
      console.log('[DENOMINATION] Raw label:', modelLabel);
      console.log('[DENOMINATION] Probability:', topProbability);

      const parsed = parsePredictionLabel(modelLabel);
      const labelRp = normalizeLabelToRp(modelLabel) || parsed.nominal || null;
      console.log('[AI] Raw prediction:', modelLabel);
      console.log('[AI] Normalized denomination:', labelRp);

      const note = labelRp ? getNoteInfo(labelRp) : null;
      console.log('[AI] rupiahData match:', note);

      const isConfidenceOk = topProbability >= DENOMINATION_CONFIDENCE_THRESHOLD;
      const isCertain = isConfidenceOk && (topProbability - secondProbability) >= MIN_MARGIN && !!note;
      const conditionText = parsed.condition ? `Kondisi: ${parsed.condition}` : 'Kondisi uang belum dapat dianalisis.';

      if (!isConfidenceOk && labelRp) {
        console.warn('[AI] Low denomination confidence, not accepting as final result:', topProbability);
      }

      stopCamera();
      showResultImage(dataUrl);
      renderResult(note, labelRp, topProbability, isCertain, dataUrl, conditionText);
    } catch (error) {
      console.error('Camera prediction error:', error);
      stopCamera();
      setStatus('Scan gagal. Pastikan posisi uang jelas dan ulangi.', 'error');
      setCaptureButton('<i class="fa-solid fa-camera"></i> Jepret', false);
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

    loadTMModel()
      .then(async () => {
        try {
          await startCamera();
          scannerMode = SCANNER_MODE.CAMERA;
        } catch (error) {
          console.error('init camera error:', error);
          scannerMode = SCANNER_MODE.ERROR;
        }
      })
      .catch(() => {
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
