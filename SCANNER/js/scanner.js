/* Minimal scanner script — upload-only, shows nominal from mapping
   Replaced complex camera + model logic per user request.
*/

document.addEventListener('DOMContentLoaded', () => {
  const imageUploadInput = document.getElementById('imageUploadInput');
  const captureBtn = document.getElementById('captureBtn');
  const scannerPreviewImg = document.getElementById('scannerPreviewImg');
  const statusText = document.getElementById('statusText');
  const videoPreview = document.getElementById('cameraStream');
  const rescanBtn = document.getElementById('rescanBtn');

  const mapping = {
    '1000': 'Rp1.000',
    '2000': 'Rp2.000',
    '5000': 'Rp5.000',
    '10000': 'Rp10.000',
    '20000': 'Rp20.000',
    '50000': 'Rp50.000',
    '100000': 'Rp100.000'
  };

  let lastUploadedDataUrl = '';
  let cameraStream = null;
  let cameraActive = false;
  let tmModel = null;
  const MODEL_BASE_PATH = 'model/tm-my-image-model (1)/';
  const MODEL_URL = encodeURI(`${MODEL_BASE_PATH}model.json`);
  const METADATA_URL = encodeURI(`${MODEL_BASE_PATH}metadata.json`);

  if (imageUploadInput) {
    imageUploadInput.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = () => {
        lastUploadedDataUrl = reader.result;
        if (scannerPreviewImg) {
            scannerPreviewImg.src = lastUploadedDataUrl;
            scannerPreviewImg.style.display = 'block';
          }
          if (statusText) statusText.textContent = 'Foto diunggah. Tekan Jepret untuk memindai.';
        const overlay = document.getElementById('scannerStatusOverlay');
        if (overlay) overlay.classList.add('hidden');
      };
      reader.readAsDataURL(file);
    });
  }

  if (rescanBtn) {
    rescanBtn.addEventListener('click', () => {
      // reset UI to scanner view
      if (scannerPreviewImg) scannerPreviewImg.style.display = 'none';
      if (videoPreview) videoPreview.style.display = 'none';
      if (statusText) statusText.textContent = 'Pilih Kamera, Upload Foto, atau Klik Jepret';
      if (captureBtn) captureBtn.innerHTML = '<i class="fa-solid fa-camera"></i> Jepret';
      // clear results area
      const resNominalGiant = document.getElementById('resNominalGiant');
      if (resNominalGiant) resNominalGiant.textContent = '';
    });
  }

    // Hide sample preview image initially to show empty scanner area
    if (scannerPreviewImg) {
      scannerPreviewImg.style.display = 'none';
    }

    // Disable capture button until model is preloaded to improve responsiveness
    if (captureBtn) captureBtn.disabled = true;

    // Preload TM model in background so first interaction is faster
    loadTMModel().then(() => {
      if (captureBtn) captureBtn.disabled = false;
    }).catch(() => {
      if (captureBtn) captureBtn.disabled = false;
    });

    // Load Teachable Machine model
    async function loadTMModel() {
      if (tmModel) return tmModel;
      try {
        if (statusText) statusText.textContent = 'Memuat model...';
        tmModel = await tmImage.load(MODEL_URL, METADATA_URL);
        if (statusText) statusText.textContent = 'Model siap. Tekan Jepret untuk membuka kamera.';
        return tmModel;
      } catch (err) {
        console.error('Gagal memuat model:', err);
        if (statusText) statusText.textContent = 'Gagal memuat model. Jalankan lewat Live Server dan periksa folder model.';
        throw err;
      }
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
      // only remove the hiding helper class; preserve other classes
      try { videoEl.classList.remove('camera-stream-hidden'); } catch (e) {}
    }

    function hideVideoAndShowPreview(dataUrl) {
      try {
        if (cameraStream) {
          cameraStream.getTracks().forEach(t => t.stop());
          cameraStream = null;
        }
      } catch (e) {}
      if (videoPreview) {
        videoPreview.srcObject = null;
        videoPreview.style.display = 'none';
        videoPreview.classList.add('camera-stream-hidden');
      }
      if (scannerPreviewImg) {
        if (dataUrl) {
          scannerPreviewImg.src = dataUrl;
        }
        scannerPreviewImg.style.display = 'block';
      }
      cameraActive = false;
      if (captureBtn) captureBtn.innerHTML = '<i class="fa-solid fa-camera"></i> Jepret';
    }

    function normalizeLabelToRp(rawLabel) {
      if (!rawLabel) return rawLabel;
      let s = String(rawLabel).trim();
      // if label already like "50.000" or "100.000"
      s = s.replace(/[^0-9.,]/g, '').replace(/,/g, '.');
      if (!s) return rawLabel;
      if (/^\d+\.\d+$/.test(s)) {
        return 'Rp' + s;
      }
      const n = Number(s);
      if (Number.isFinite(n)) return 'Rp' + n.toLocaleString('id-ID');
      return 'Rp' + s;
    }

  // Capture button: first click opens camera, second click captures & scans
  if (captureBtn) {
    captureBtn.addEventListener('click', async () => {
      // prevent double clicks
      if (captureBtn) captureBtn.disabled = true;
      try {
        // ensure model is loaded (preloaded usually)
        await loadTMModel();

        // If an uploaded image is visible, prefer analyzing the uploaded image (Upload mode)
        if (scannerPreviewImg && scannerPreviewImg.src && scannerPreviewImg.style.display && scannerPreviewImg.style.display !== 'none' && !cameraActive) {
          try {
            if (statusText) statusText.textContent = 'Menganalisis foto unggahan...';
            const predictions = await tmModel.predict(scannerPreviewImg);
            if (!Array.isArray(predictions) || predictions.length === 0) {
              if (statusText) statusText.textContent = 'Model tidak mengembalikan prediksi.';
              return;
            }
            const top = predictions.sort((a, b) => b.probability - a.probability)[0];
            const rawLabel = top.className || top.label || '';
            const labelRp = normalizeLabelToRp(rawLabel);
            // render same as camera flow
            const dataUrl = scannerPreviewImg.src;
            // find matching banknote
            let found = null;
            try { const banknotes = (window.rupantaraData && window.rupantaraData.banknotes) || []; found = banknotes.find(b => b.nominalFormatted === labelRp || b.nominalFormatted.replace(/\./g,'') === labelRp.replace(/\D/g,'')); } catch (e) { found = null; }
            const resNominalGiant = document.getElementById('resNominalGiant');
            const resJenisTag = document.getElementById('resJenisTag');
            const resBanknoteImg = document.getElementById('resBanknoteImg');
            const resMaknaVisualList = document.getElementById('resMaknaVisualList');
            const resHeroNameTitle = document.getElementById('resHeroNameTitle');
            const resHeroBioText = document.getElementById('resHeroBioText');
            const resFaktaList = document.getElementById('resFaktaList');
            const resCiriKeaslianList = document.getElementById('resCiriKeaslianList');
            if (resNominalGiant) resNominalGiant.textContent = labelRp;
            if (resJenisTag) resJenisTag.textContent = (found && found.jenis) || 'Rupiah Kertas';
            if (resBanknoteImg && dataUrl) resBanknoteImg.src = dataUrl;
            if (found) {
              if (resHeroNameTitle) resHeroNameTitle.textContent = found.pahlawan || '';
              if (resHeroBioText) resHeroBioText.textContent = found.sejarahTokoh || '';
              if (resFaktaList) resFaktaList.innerHTML = (found.faktaMenarik || []).map(i => `<li>${i}</li>`).join('');
              if (resCiriKeaslianList) resCiriKeaslianList.innerHTML = (found.ciriKeaslian || []).map(i => `<li>${i.title || i}</li>`).join('');
              if (resMaknaVisualList) resMaknaVisualList.innerHTML = (found.maknaVisual || []).map(i => `<li>${i.text || i}</li>`).join('');
            } else {
              if (resFaktaList) resFaktaList.innerHTML = '<li>Informasi untuk pecahan ini belum tersedia.</li>';
            }
            if (statusText) statusText.textContent = `Hasil: ${labelRp} (${Math.round((top.probability||0)*100)}%)`;
            return;
          } catch (e) {
            console.error('Error predicting uploaded image:', e);
            if (statusText) statusText.textContent = 'Terjadi kesalahan saat menganalisis foto unggahan.';
            return;
          }
        }

        if (!cameraActive) {
          // start camera
          if (statusText) statusText.textContent = 'Membuka kamera...';
          try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: { ideal: 'environment' } } });
            cameraStream = stream;
            if (videoPreview) {
              videoPreview.srcObject = stream;
              applyVideoVisibleStyles(videoPreview);
              videoPreview.setAttribute('autoplay', '');
              videoPreview.setAttribute('muted', '');
              videoPreview.setAttribute('playsinline', '');
              await videoPreview.play();
            }
            if (scannerPreviewImg) scannerPreviewImg.style.display = 'none';
            cameraActive = true;
            if (captureBtn) captureBtn.innerHTML = '📸 Jepret & Scan';
            if (statusText) statusText.textContent = 'Kamera aktif. Arahkan lalu tekan Jepret & Scan.';
            if (captureBtn) captureBtn.disabled = false;
            return;
          } catch (err) {
            console.error('getUserMedia error:', err);
            if (statusText) statusText.textContent = 'Gagal membuka kamera. Periksa izin atau jalankan lewat Live Server.';
            if (captureBtn) captureBtn.disabled = false;
            return;
          }
        }

        // if camera is active -> capture frame and analyze
        if (!videoPreview) return;
        if (statusText) statusText.textContent = 'Mengambil frame...';
        const canvas = document.createElement('canvas');
        canvas.width = videoPreview.videoWidth || 640;
        canvas.height = videoPreview.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(videoPreview, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/jpeg');
        if (statusText) statusText.textContent = 'Menganalisis gambar...';

        const predictions = await tmModel.predict(canvas);
        if (!Array.isArray(predictions) || predictions.length === 0) {
          if (statusText) statusText.textContent = 'Model tidak mengembalikan prediksi.';
          hideVideoAndShowPreview(dataUrl);
          return;
        }
        const top = predictions.sort((a, b) => b.probability - a.probability)[0];
        const rawLabel = top.className || top.label || '';
        const labelRp = normalizeLabelToRp(rawLabel);

        // find matching banknote in window.rupantaraData.banknotes by nominalFormatted
        let found = null;
        try {
          const banknotes = (window.rupantaraData && window.rupantaraData.banknotes) || [];
          found = banknotes.find(b => b.nominalFormatted === labelRp || b.nominalFormatted.replace(/\./g,'') === labelRp.replace(/\D/g,''));
        } catch (e) { found = null; }

        // render results
        const resNominalGiant = document.getElementById('resNominalGiant');
        const resJenisTag = document.getElementById('resJenisTag');
        const resBanknoteImg = document.getElementById('resBanknoteImg');
        const resMaknaVisualList = document.getElementById('resMaknaVisualList');
        const resHeroNameTitle = document.getElementById('resHeroNameTitle');
        const resHeroTtl = document.getElementById('resHeroTtl');
        const resHeroBioText = document.getElementById('resHeroBioText');
        const resFaktaList = document.getElementById('resFaktaList');
        const resCiriKeaslianList = document.getElementById('resCiriKeaslianList');

        if (resNominalGiant) resNominalGiant.textContent = labelRp;
        if (resJenisTag) resJenisTag.textContent = (found && found.jenis) || 'Rupiah Kertas';
        if (resBanknoteImg && dataUrl) resBanknoteImg.src = dataUrl;

        if (found) {
          if (resHeroNameTitle) resHeroNameTitle.textContent = found.pahlawan || found.pahlawan || '';
          if (resHeroBioText) resHeroBioText.textContent = found.sejarahTokoh || found.sejarahTokoh || '';
          if (resFaktaList) resFaktaList.innerHTML = (found.faktaMenarik || found.faktaMenarik || []).map(i => `<li>${i}</li>`).join('');
          if (resCiriKeaslianList) resCiriKeaslianList.innerHTML = (found.ciriKeaslian || found.ciriKeaslian || []).map(i => `<li>${i.title || i}</li>`).join('');
          if (resMaknaVisualList) resMaknaVisualList.innerHTML = (found.maknaVisual || []).map(i => `<li>${i.text || i}</li>`).join('');
        } else {
          if (resFaktaList) resFaktaList.innerHTML = '<li>Informasi untuk pecahan ini belum tersedia.</li>';
          if (resCiriKeaslianList) resCiriKeaslianList.innerHTML = '<li>Informasi untuk pecahan ini belum tersedia.</li>';
          if (resMaknaVisualList) resMaknaVisualList.innerHTML = '<li>Informasi belum tersedia.</li>';
          if (resHeroNameTitle) resHeroNameTitle.textContent = '';
          if (resHeroBioText) resHeroBioText.textContent = '';
        }

        if (statusText) statusText.textContent = `Hasil: ${labelRp} (${Math.round((top.probability||0)*100)}%)`;

        // stop camera and show captured preview
        hideVideoAndShowPreview(dataUrl);
        if (captureBtn) captureBtn.disabled = false;
      } catch (err) {
        console.error('Error during capture/scan:', err);
        if (statusText) statusText.textContent = 'Terjadi kesalahan saat memindai. Lihat console untuk detail.';
        hideVideoAndShowPreview();
        if (captureBtn) captureBtn.disabled = false;
      }
    });
  }
  // Manual nominal input removed for simpler UX — scanning and upload now auto-display results via model.

  const dismissBtn = document.getElementById('dismissStatusBtn');
  if (dismissBtn) {
    dismissBtn.addEventListener('click', () => {
      const overlay = document.getElementById('scannerStatusOverlay');
      if (overlay) overlay.classList.add('hidden');
    });
  }
});
