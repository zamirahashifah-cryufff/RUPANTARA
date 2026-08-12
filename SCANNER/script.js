const MODEL_BASE_PATH = 'model/tm-my-image-model (1)/';
const MODEL_URL = encodeURI(`${MODEL_BASE_PATH}model.json`);
const METADATA_URL = encodeURI(`${MODEL_BASE_PATH}metadata.json`);

let tmModel = null;

const rupiahData = {
  'Rp1.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  },
  'Rp2.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  },
  'Rp5.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  },
  'Rp10.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  },
  'Rp20.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  },
  'Rp50.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  },
  'Rp100.000': {
    tokoh: '[Data tokoh belum diisi]',
    caraMerawat: ['[Data cara merawat belum diisi]'],
    ciriCiri: ['[Data ciri-ciri belum diisi]'],
    fakta: ['[Data fakta menarik belum diisi]'],
    sejarah: '[Data sejarah belum diisi]'
  }
};

function formatLabelToRp(rawLabel) {
  if (!rawLabel || typeof rawLabel !== 'string') return rawLabel || '';
  const digits = rawLabel.replace(/[^0-9]+/g, '');
  if (!digits) return rawLabel;
  return 'Rp' + Number(digits).toLocaleString('id-ID');
}

window.addEventListener('DOMContentLoaded', () => {
  const aiImageUpload = document.getElementById('aiImageUpload');
  const aiCameraButton = document.getElementById('aiCameraButton');
  const scanButton = document.getElementById('scanButton');
  const aiPreviewImage = document.getElementById('aiPreviewImage');
  const aiVideoPreview = document.getElementById('aiVideoPreview');
  const aiStatusText = document.getElementById('aiStatusText');
  const aiResultArea = document.getElementById('aiResultArea');
  const aiInfoArea = document.getElementById('aiInfoArea');

  let cameraStream = null;

  if (!aiImageUpload || !aiCameraButton || !scanButton || !aiPreviewImage || !aiVideoPreview || !aiStatusText || !aiResultArea || !aiInfoArea) {
    return;
  }

  aiStatusText.textContent = 'Model sedang dimuat...';
  scanButton.disabled = true;

  async function loadModel() {
    try {
      tmModel = await tmImage.load(MODEL_URL, METADATA_URL);
      aiStatusText.textContent = 'Model siap. Unggah foto dan klik Scan Rupiah.';
    } catch (error) {
      console.error('Gagal memuat model:', error);
      aiStatusText.textContent = 'Gagal memuat model. Pastikan folder model tersedia dan jalankan lewat Live Server.';
      aiResultArea.innerHTML = '<div class="ai-error">Gagal memuat model. Cek console browser untuk detail.</div>';
    }
  }

  function stopCamera() {
    if (cameraStream) {
      cameraStream.getTracks().forEach(track => track.stop());
      cameraStream = null;
    }
    aiVideoPreview.pause();
    aiVideoPreview.srcObject = null;
    aiVideoPreview.style.display = 'none';
  }

  function showPreview(src) {
    stopCamera();
    aiPreviewImage.src = src;
    aiPreviewImage.classList.add('loaded');
    aiPreviewImage.style.display = 'block';
  }

  async function waitForVideoReady() {
    if (aiVideoPreview.readyState >= 2) {
      return;
    }
    await new Promise((resolve) => {
      aiVideoPreview.onloadeddata = () => resolve();
    });
  }

  function renderPrediction(label, confidence) {
    const textLabel = formatLabelToRp(label);
    aiResultArea.innerHTML = `
      <div class="ai-result-row"><strong>Hasil Deteksi:</strong> ${textLabel}</div>
      <div class="ai-result-row"><strong>Confidence:</strong> ${confidence}%</div>
    `;
    return textLabel;
  }

  function renderInfo(labelRp) {
    const info = rupiahData[labelRp];
    if (!info) {
      aiInfoArea.innerHTML = '<div class="ai-error">Informasi untuk pecahan ini belum tersedia.</div>';
      return;
    }

    const caraList = info.caraMerawat.map(item => `<li>${item}</li>`).join('');
    const ciriList = info.ciriCiri.map(item => `<li>${item}</li>`).join('');
    const faktaList = info.fakta.map(item => `<li>${item}</li>`).join('');

    aiInfoArea.innerHTML = `
      <div class="ai-result-row"><strong>Tokoh / Pahlawan:</strong> ${info.tokoh}</div>
      <div class="ai-result-row"><strong>Sejarah:</strong> ${info.sejarah}</div>
      <div class="ai-result-row"><strong>Cara Merawat:</strong><ul>${caraList}</ul></div>
      <div class="ai-result-row"><strong>Ciri-Ciri:</strong><ul>${ciriList}</ul></div>
      <div class="ai-result-row"><strong>Fakta Menarik:</strong><ul>${faktaList}</ul></div>
    `;
  }

  aiCameraButton.addEventListener('click', async () => {
    try {
      aiStatusText.textContent = 'Membuka kamera untuk scan...';
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
      aiVideoPreview.srcObject = stream;
      aiVideoPreview.style.display = 'block';
      await waitForVideoReady();

      const canvas = document.createElement('canvas');
      canvas.width = aiVideoPreview.videoWidth || 640;
      canvas.height = aiVideoPreview.videoHeight || 480;
      const context = canvas.getContext('2d');
      context.drawImage(aiVideoPreview, 0, 0, canvas.width, canvas.height);
      const dataUrl = canvas.toDataURL('image/jpeg');
      showPreview(dataUrl);
      aiStatusText.textContent = 'Sedang menganalisis hasil kamera...';
      aiResultArea.textContent = '';

      const predictions = await tmModel.predict(canvas);
      if (!Array.isArray(predictions) || predictions.length === 0) {
        aiStatusText.textContent = 'Tidak ada hasil prediksi dari kamera.';
        aiResultArea.innerHTML = '<div class="ai-error">Model tidak mengembalikan prediksi.</div>';
        stream.getTracks().forEach(track => track.stop());
        aiVideoPreview.srcObject = null;
        aiVideoPreview.style.display = 'none';
        return;
      }

      const top = predictions.sort((a, b) => b.probability - a.probability)[0];
      const rawLabel = top.className || top.label || '';
      const labelRp = renderPrediction(rawLabel, Math.round((top.probability || 0) * 100));
      renderInfo(labelRp);
      aiStatusText.textContent = 'Prediksi kamera selesai.';

      stream.getTracks().forEach(track => track.stop());
      aiVideoPreview.srcObject = null;
      aiVideoPreview.style.display = 'none';
    } catch (error) {
      console.error('Gagal melakukan scan kamera:', error);
      aiStatusText.textContent = 'Gagal scan kamera. Pastikan kamera boleh diakses.';
      aiResultArea.innerHTML = '<div class="ai-error">Scan kamera gagal. Lihat console untuk detail.</div>';
    }
  });

  aiImageUpload.addEventListener('change', async (event) => {
    const file = event.target.files && event.target.files[0];
    if (!file) {
      return;
    }

    const reader = new FileReader();
    reader.onload = () => {
      const dataUrl = reader.result;
      showPreview(dataUrl);
      aiStatusText.textContent = 'Foto siap. Klik Scan Rupiah.';
      aiResultArea.textContent = '';
      scanButton.disabled = false;
    };
    reader.onerror = () => {
      aiStatusText.textContent = 'Gagal membaca file. Silakan pilih foto ulang.';
      aiResultArea.innerHTML = '<div class="ai-error">Gagal membaca file.</div>';
    };
    reader.readAsDataURL(file);
  });

  scanButton.addEventListener('click', async () => {
    if (!tmModel) {
      aiStatusText.textContent = 'Model belum siap. Tunggu beberapa detik lagi.';
      return;
    }
    if (!aiPreviewImage.src) {
      aiStatusText.textContent = 'Silakan unggah foto atau gunakan tombol Scan Kamera.';
      return;
    }

    aiStatusText.textContent = 'Sedang menganalisis...';
    aiResultArea.textContent = '';
    scanButton.disabled = true;

    try {
      let inputElement;
      if (aiPreviewImage.src) {
        inputElement = aiPreviewImage;
      } else {
        await waitForVideoReady();
        const canvas = document.createElement('canvas');
        canvas.width = aiVideoPreview.videoWidth || 640;
        canvas.height = aiVideoPreview.videoHeight || 480;
        const context = canvas.getContext('2d');
        context.drawImage(aiVideoPreview, 0, 0, canvas.width, canvas.height);
        inputElement = canvas;
      }
      const predictions = await tmModel.predict(inputElement);
      if (!Array.isArray(predictions) || predictions.length === 0) {
        aiStatusText.textContent = 'Tidak ada hasil prediksi dari model.';
        aiResultArea.innerHTML = '<div class="ai-error">Model tidak mengembalikan prediksi.</div>';
        return;
      }

      const top = predictions.sort((a, b) => b.probability - a.probability)[0];
      const rawLabel = top.className || top.label || '';
      const labelRp = renderPrediction(rawLabel, Math.round((top.probability || 0) * 100));
      renderInfo(labelRp);
      aiStatusText.textContent = 'Prediksi selesai.';
    } catch (error) {
      console.error('Gagal melakukan prediksi:', error);
      aiStatusText.textContent = 'Terjadi kesalahan saat menganalisis gambar.';
      aiResultArea.innerHTML = '<div class="ai-error">Prediksi gagal. Buka console untuk detail.</div>';
    } finally {
      scanButton.disabled = false;
    }
  });

  loadModel();
});
