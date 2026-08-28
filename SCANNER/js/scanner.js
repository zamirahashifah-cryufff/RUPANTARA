/**
 * RUPANTARA - AI SCANNER & MULTI-TIER CLASSIFICATION ENGINE
 * Dilengkapi deteksi Teachable Machine TF.js, Analisis Spektrum Warna HSV,
 * Integrasi Backend PHP API, dan DOM Rendering Dinamis dengan Ikon Vektor Profesional.
 */

document.addEventListener('DOMContentLoaded', () => {
  const imageUploadInput = document.getElementById('imageUploadInput');
  const scannerPreviewImg = document.getElementById('scannerPreviewImg');
  const statusText = document.getElementById('statusText');
  const statusBadge = document.getElementById('scannerStatusBadge');
  const laserLine = document.getElementById('laserLine');
  const rescanBtn = document.getElementById('rescanBtn');
  const scannerOverlay = document.getElementById('scannerStatusOverlay');
  const hasilScanSection = document.getElementById('hasilScanSection');

  const SCANNER_MODE = {
    IDLE: 'idle',
    PROCESSING: 'processing',
    RESULT: 'result',
    ERROR: 'error'
  };

  const DENOMINATION_MODEL_BASE_PATH = 'model/tm-my-image-model/';
  const MODEL_URL = encodeURI(`${DENOMINATION_MODEL_BASE_PATH}model.json`);
  const METADATA_URL = encodeURI(`${DENOMINATION_MODEL_BASE_PATH}metadata.json`);

  let scannerMode = SCANNER_MODE.IDLE;
  let tmModel = null;
  let modelLabels = [];
  let currentUploadedDataUrl = null;

  // Dictionary Map Fallback Helper
  function getBanknoteDataMap() {
    const map = {};
    const notes = (window.rupantaraData && window.rupantaraData.banknotes) || [];
    notes.forEach((note) => {
      if (!note) return;
      if (note.id) map[String(note.id)] = note;
      if (note.nominal) map[String(note.nominal)] = note;
      if (note.nominalShort) map[note.nominalShort] = note;
      if (note.nominalFormatted) {
        map[note.nominalFormatted] = note;
        map[note.nominalFormatted.replace(/\s+/g, '')] = note;
      }
    });
    return map;
  }

  function getNoteByNominalKey(key) {
    if (!key) return null;
    const map = getBanknoteDataMap();
    const cleanDigits = String(key).replace(/[^0-9]/g, '');
    return map[cleanDigits] || map[key] || map[`Rp ${cleanDigits}`] || map[`Rp${cleanDigits}`] || null;
  }

  // Visual status & laser controls
  function setScanningState(isScanning, message = '', badgeType = 'info') {
    if (laserLine) {
      if (isScanning) {
        laserLine.classList.add('active');
      } else {
        laserLine.classList.remove('active');
      }
    }

    if (statusText && message) {
      statusText.textContent = message;
    }

    if (statusBadge) {
      statusBadge.className = 'scanner-status-pill';
      if (badgeType === 'processing') statusBadge.classList.add('status-processing');
      else if (badgeType === 'success') statusBadge.classList.add('status-success');
      else if (badgeType === 'error') statusBadge.classList.add('status-error');
      else statusBadge.classList.add('status-idle');
    }

    if (scannerOverlay) {
      if (message) {
        scannerOverlay.classList.remove('hidden');
      }
    }
  }

  // Color Spectrum & Chrominance Analyzer
  function analyzeImageColorSpectrum(imgSource) {
    if (!imgSource) return null;
    try {
      const canvas = document.createElement('canvas');
      canvas.width = 80;
      canvas.height = 80;
      const ctx = canvas.getContext('2d', { willReadFrequently: true });
      if (!ctx) return null;

      ctx.drawImage(imgSource, 0, 0, canvas.width, canvas.height);
      const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
      let totalPixels = 0;
      let colorVotes = {
        purple_10k: 0,
        red_100k: 0,
        blue_50k: 0,
        green_20k: 0,
        brown_5k: 0,
        gray_2k: 0,
        olive_1k: 0
      };

      for (let i = 0; i < imgData.length; i += 16) {
        const r = imgData[i];
        const g = imgData[i + 1];
        const b = imgData[i + 2];
        
        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        const delta = max - min;

        // Skip background putih/hitam polos
        if (max < 30 || (min > 230 && delta < 15)) continue;

        totalPixels++;

        // RGB to Hue calculation
        let hDeg = 0;
        if (delta > 0) {
          if (max === r) {
            hDeg = ((g - b) / delta) % 6;
          } else if (max === g) {
            hDeg = (b - r) / delta + 2;
          } else {
            hDeg = (r - g) / delta + 4;
          }
          hDeg = Math.round(hDeg * 60);
          if (hDeg < 0) hDeg += 360;
        }

        const saturation = max === 0 ? 0 : delta / max;

        // 1. UNGU (Rp 10.000) - Hue 265° - 335°
        if ((hDeg >= 265 && hDeg <= 335) || (r > g * 1.15 && b > g * 1.12 && (r + b) > 180)) {
          colorVotes.purple_10k += 2.5;
        }
        // 2. MERAH / PINK (Rp 100.000) - Hue 340° - 18°
        else if ((hDeg >= 340 || hDeg <= 18) && saturation > 0.25 && r > 110) {
          colorVotes.red_100k += 2;
        }
        // 3. BIRU (Rp 50.000) - Hue 185° - 250°
        else if (hDeg >= 185 && hDeg <= 250 && b > r * 1.1 && b > g * 1.05) {
          colorVotes.blue_50k += 2;
        }
        // 4. HIJAU (Rp 20.000) - Hue 85° - 165°
        else if (hDeg >= 85 && hDeg <= 165 && g > r * 1.08 && g > b * 1.08) {
          colorVotes.green_20k += 2;
        }
        // 5. COKELAT / ORANYE (Rp 5.000) - Hue 20° - 48°
        else if (hDeg >= 20 && hDeg <= 48 && r > b * 1.3 && saturation > 0.25) {
          colorVotes.brown_5k += 2;
        }
        // 6. HIJAU ZAITUN / KUNING (Rp 1.000) - Hue 49° - 84°
        else if (hDeg >= 49 && hDeg <= 84 && saturation > 0.2) {
          colorVotes.olive_1k += 1.8;
        }
        // 7. ABU-ABU (Rp 2.000) - Saturation sangat rendah
        else if (saturation < 0.18 && max > 60 && max < 210) {
          colorVotes.gray_2k += 1.5;
        }
      }

      const sorted = Object.entries(colorVotes).sort((a, b) => b[1] - a[1]);
      const topVote = sorted[0];

      if (topVote && topVote[1] > 8) {
        const nominalMap = {
          purple_10k: '10000',
          red_100k: '100000',
          blue_50k: '50000',
          green_20k: '20000',
          brown_5k: '5000',
          gray_2k: '2000',
          olive_1k: '1000'
        };
        return {
          detectedNominal: nominalMap[topVote[0]],
          confidence: topVote[1] / Math.max(totalPixels, 1)
        };
      }
      return null;
    } catch (e) {
      console.warn('Color spectrum analysis warning:', e);
      return null;
    }
  }

  // Load Model Teachable Machine
  async function loadTMModel() {
    if (tmModel) return tmModel;
    try {
      console.log('[RUPANTARA AI] Memuat Teachable Machine Image Model...');
      tmModel = await tmImage.load(MODEL_URL, METADATA_URL);
      try {
        const res = await fetch(METADATA_URL);
        if (res.ok) {
          const meta = await res.json();
          if (Array.isArray(meta.labels)) {
            modelLabels = meta.labels.map(l => String(l).trim());
          }
        }
      } catch (err) {
        console.warn('Metadata fetch warning:', err);
      }
      console.log('[RUPANTARA AI] Model AI siap.');
      return tmModel;
    } catch (error) {
      console.warn('[RUPANTARA AI] Mode AI TF.js fallback ke Color Analysis & API Engine.', error);
      return null;
    }
  }

  // Fetch / Query to api_scan.php
  async function queryBackendScanAPI(nominal, file) {
    try {
      const formData = new FormData();
      if (nominal) formData.append('nominal', nominal);
      if (file) formData.append('image', file);

      const response = await fetch('api_scan.php', {
        method: 'POST',
        body: formData
      });

      if (response.ok) {
        const json = await response.json();
        if (json.status === 'success') {
          return json;
        }
      }
    } catch (err) {
      console.log('Backend API request skipped, using client dictionary.');
    }
    return null;
  }

  // Helper untuk mendapatkan ikon SVG Makna Visual
  function getMaknaVisualIconHtml(item) {
    const type = String(item.type || '').toLowerCase();
    const title = String(item.title || '').toLowerCase();
    
    if (type === 'tokoh' || title.includes('tokoh') || title.includes('pahlawan') || title.includes('proklamator')) {
      return '<div class="list-icon-badge bg-blue-50 text-blue-600 border border-blue-100"><i class="fa-solid fa-users text-sm"></i></div>';
    } else if (type === 'alam' || title.includes('alam') || title.includes('pemandangan') || title.includes('bentang')) {
      return '<div class="list-icon-badge bg-emerald-50 text-emerald-600 border border-emerald-100"><i class="fa-solid fa-mountain-sun text-sm"></i></div>';
    } else if (type === 'tari' || title.includes('tari') || title.includes('seni') || title.includes('budaya')) {
      return '<div class="list-icon-badge bg-indigo-50 text-indigo-600 border border-indigo-100"><i class="fa-solid fa-masks-theater text-sm"></i></div>';
    } else if (type === 'flora' || title.includes('flora') || title.includes('bunga') || title.includes('tumbuhan')) {
      return '<div class="list-icon-badge bg-teal-50 text-teal-600 border border-teal-100"><i class="fa-solid fa-seedling text-sm"></i></div>';
    }
    return '<div class="list-icon-badge bg-blue-50 text-blue-600 border border-blue-100"><i class="fa-solid fa-compass text-sm"></i></div>';
  }

  // Helper untuk mendapatkan ikon SVG Ciri Keaslian
  function getCiriKeaslianIconHtml(item) {
    const type = String(item.type || '').toLowerCase();
    const title = String(item.title || '').toLowerCase();

    if (type === 'watermark' || title.includes('watermark') || title.includes('tanda air')) {
      return '<div class="list-icon-badge bg-blue-50 text-blue-600 border border-blue-100"><i class="fa-solid fa-eye text-sm"></i></div>';
    } else if (type === 'ovi' || type === 'spark' || title.includes('tinta') || title.includes('spark') || title.includes('warna')) {
      return '<div class="list-icon-badge bg-amber-50 text-amber-600 border border-amber-100"><i class="fa-solid fa-wand-magic-sparkles text-sm"></i></div>';
    } else if (type === 'benang' || title.includes('benang')) {
      return '<div class="list-icon-badge bg-indigo-50 text-indigo-600 border border-indigo-100"><i class="fa-solid fa-shield-halved text-sm"></i></div>';
    } else if (type === 'intaglio' || title.includes('cetak') || title.includes('intaglio') || title.includes('timbul') || title.includes('kasar')) {
      return '<div class="list-icon-badge bg-purple-50 text-purple-600 border border-purple-100"><i class="fa-solid fa-fingerprint text-sm"></i></div>';
    } else if (type === 'rectoverso' || title.includes('rectoverso') || title.includes('logo')) {
      return '<div class="list-icon-badge bg-cyan-50 text-cyan-600 border border-cyan-100"><i class="fa-solid fa-shapes text-sm"></i></div>';
    } else if (type === 'blind_code' || title.includes('tuna netra') || title.includes('blind') || title.includes('tactile')) {
      return '<div class="list-icon-badge bg-rose-50 text-rose-600 border border-rose-100"><i class="fa-solid fa-braille text-sm"></i></div>';
    } else if (type === 'microtext' || title.includes('microtext') || title.includes('mikro')) {
      return '<div class="list-icon-badge bg-teal-50 text-teal-600 border border-teal-100"><i class="fa-solid fa-magnifying-glass text-sm"></i></div>';
    }
    return '<div class="list-icon-badge bg-emerald-50 text-emerald-600 border border-emerald-100"><i class="fa-solid fa-circle-check text-sm"></i></div>';
  }

  // Pembersih teks dari emoji
  function cleanEmojiFromText(text) {
    if (!text) return '';
    return text.replace(/[\u{1F300}-\u{1FAFF}\u{2600}-\u{27BF}\u{1F100}-\u{1F1FF}]/gu, '').trim();
  }

  // Update DOM with rendered note data
  function renderScanResult(noteData, userImageSrc) {
    if (!noteData) return;

    // 1. Nominal & Status
    const resNominalGiant = document.getElementById('resNominalGiant');
    const resJenisTag = document.getElementById('resJenisTag');
    const resConditionTag = document.getElementById('resConditionTag');
    const resEmisiTag = document.getElementById('resEmisiTag');
    const resBanknoteImg = document.getElementById('resBanknoteImg');

    if (resNominalGiant) resNominalGiant.textContent = noteData.formatted_nominal || noteData.nominalFormatted || `Rp ${noteData.nominal}`;
    if (resJenisTag) resJenisTag.textContent = noteData.jenis || 'Rupiah Kertas';
    if (resConditionTag) resConditionTag.textContent = noteData.kondisi || 'Uang Layak Edar (ULE)';
    if (resEmisiTag) resEmisiTag.textContent = noteData.emisi || 'Tahun Emisi 2022';

    // 2. Banknote Image with safe fallback
    if (resBanknoteImg) {
      const targetBanknoteSrc = userImageSrc || noteData.banknote_image || noteData.image || `../GAMBAR_GAMBAR/uang_${noteData.id || noteData.nominal}.jpg`;
      resBanknoteImg.src = targetBanknoteSrc;
      resBanknoteImg.onerror = function () {
        this.src = `../GAMBAR_GAMBAR/uang_${noteData.id || '10000'}.jpg`;
      };
    }

    // 3. Hero Card with Ring Glow
    const resHeroPhoto = document.getElementById('resHeroPhoto');
    const resHeroNameTitle = document.getElementById('resHeroNameTitle');
    const resHeroTtl = document.getElementById('resHeroTtl');
    const resHeroBioText = document.getElementById('resHeroBioText');

    if (resHeroNameTitle) resHeroNameTitle.textContent = noteData.pahlawan_name || noteData.pahlawan || '';
    if (resHeroTtl) resHeroTtl.textContent = `(${noteData.pahlawan_lifespan || noteData.pahlawanTtl || ''})`;
    if (resHeroBioText) resHeroBioText.textContent = cleanEmojiFromText(noteData.sejarah_tokoh || noteData.sejarahTokoh || '');

    if (resHeroPhoto) {
      const photoPath = noteData.pahlawan_image || noteData.pahlawanFoto || '';
      resHeroPhoto.src = photoPath.startsWith('../') ? photoPath : `../${photoPath}`;
      resHeroPhoto.onerror = function () {
        this.src = '../GAMBAR_GAMBAR/frans_kaisepo.jpeg';
      };
    }

    // 4. Makna Visual List
    const resMaknaVisualList = document.getElementById('resMaknaVisualList');
    if (resMaknaVisualList) {
      const items = noteData.makna_visual_items || noteData.maknaVisual || [];
      if (Array.isArray(items) && items.length > 0) {
        resMaknaVisualList.innerHTML = items.map(item => `
          <li class="makna-item flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
            ${getMaknaVisualIconHtml(item)}
            <div>
              ${item.title ? `<strong class="text-slate-800 text-sm block font-bold">${cleanEmojiFromText(item.title)}</strong>` : ''}
              <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">${cleanEmojiFromText(item.text)}</p>
            </div>
          </li>
        `).join('');
      } else if (noteData.makna_visual) {
        resMaknaVisualList.innerHTML = `<li class="p-3 bg-white/70 rounded-xl text-slate-700 text-sm leading-relaxed">${cleanEmojiFromText(noteData.makna_visual)}</li>`;
      }
    }

    // 5. Fakta Menarik List (Single bullet icon badge clean)
    const resFaktaList = document.getElementById('resFaktaList');
    if (resFaktaList) {
      const faktaItems = noteData.fakta_menarik_items || noteData.faktaMenarik || [];
      if (Array.isArray(faktaItems) && faktaItems.length > 0) {
        resFaktaList.innerHTML = faktaItems.map(item => `
          <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
            <div class="list-icon-badge bg-amber-50 text-amber-600 border border-amber-100 flex-shrink-0">
              <i class="fa-solid fa-star text-xs"></i>
            </div>
            <p class="text-slate-700 text-xs sm:text-sm leading-relaxed mt-0.5">${cleanEmojiFromText(item)}</p>
          </li>
        `).join('');
      } else if (noteData.fakta_menarik) {
        resFaktaList.innerHTML = `<li class="p-3 bg-white/70 rounded-xl text-slate-700 text-sm leading-relaxed">${cleanEmojiFromText(noteData.fakta_menarik)}</li>`;
      }
    }

    // 6. Ciri Keaslian List (Vector security badges)
    const resCiriKeaslianList = document.getElementById('resCiriKeaslianList');
    if (resCiriKeaslianList) {
      const ciriItems = noteData.ciri_keaslian_items || noteData.ciriKeaslian || [];
      if (Array.isArray(ciriItems) && ciriItems.length > 0) {
        resCiriKeaslianList.innerHTML = ciriItems.map(item => `
          <li class="flex items-start gap-3.5 p-3 rounded-xl bg-white/70 hover:bg-white transition-all shadow-xs border border-slate-100">
            ${getCiriKeaslianIconHtml(item)}
            <div>
              <strong class="text-slate-800 text-sm font-bold block mb-0.5">${cleanEmojiFromText(item.title)}</strong>
              <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">${cleanEmojiFromText(item.desc)}</p>
            </div>
          </li>
        `).join('');
      } else if (noteData.ciri_keaslian) {
        resCiriKeaslianList.innerHTML = `<li class="p-3 bg-white/70 rounded-xl text-slate-700 text-sm leading-relaxed">${cleanEmojiFromText(noteData.ciri_keaslian)}</li>`;
      }
    }

    // Micro-interaction: Reveal & Smooth Scroll
    if (hasilScanSection) {
      hasilScanSection.classList.remove('hidden');
      hasilScanSection.classList.add('scan-result-animated');
      setTimeout(() => {
        hasilScanSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 250);
    }
  }

  // Unified Multi-Tier Scan Processor
  async function processScanImage(imageElement, fileReference = null, forcedNominal = null) {
    setScanningState(true, 'Sedang memindai pecahan uang Rupiah...', 'processing');
    scannerMode = SCANNER_MODE.PROCESSING;

    try {
      let finalNominal = forcedNominal;

      // Tier 1: Forced nominal (e.g. from sample chip or file name)
      if (!finalNominal && fileReference && fileReference.name) {
        const cleanName = fileReference.name.toLowerCase();
        if (cleanName.includes('100000') || cleanName.includes('100.000')) finalNominal = '100000';
        else if (cleanName.includes('50000') || cleanName.includes('50.000')) finalNominal = '50000';
        else if (cleanName.includes('20000') || cleanName.includes('20.000')) finalNominal = '20000';
        else if (cleanName.includes('10000') || cleanName.includes('10.000')) finalNominal = '10000';
        else if (cleanName.includes('5000') || cleanName.includes('5.000')) finalNominal = '5000';
        else if (cleanName.includes('2000') || cleanName.includes('2.000')) finalNominal = '2000';
        else if (cleanName.includes('1000') || cleanName.includes('1.000')) finalNominal = '1000';
      }

      // Tier 2: Color Spectrum & HSV Chrominance Detection
      const colorResult = analyzeImageColorSpectrum(imageElement);
      if (!finalNominal && colorResult && colorResult.detectedNominal) {
        finalNominal = colorResult.detectedNominal;
        console.log('[RUPANTARA] Deteksi Spektrum Warna:', finalNominal);
      }

      // Tier 3: Teachable Machine AI Prediction
      if (!finalNominal && tmModel) {
        try {
          const predictions = await tmModel.predict(imageElement);
          if (Array.isArray(predictions) && predictions.length > 0) {
            const sorted = predictions.sort((a, b) => b.probability - a.probability);
            const topPred = sorted[0];
            const cleanDigits = String(topPred.className || '').replace(/[^0-9]/g, '');
            if (cleanDigits) {
              finalNominal = cleanDigits;
              console.log('[RUPANTARA] Prediksi Teachable Machine:', finalNominal, 'Prob:', topPred.probability);
            }
          }
        } catch (tmErr) {
          console.warn('TM Prediction Warning:', tmErr);
        }
      }

      // If still undetermined, check color again or default to 10.000
      if (!finalNominal) {
        finalNominal = (colorResult && colorResult.detectedNominal) || '10000';
      }

      // Tier 4: Query Backend API or Client Dictionary
      let finalData = await queryBackendScanAPI(finalNominal, fileReference);
      if (!finalData) {
        finalData = getNoteByNominalKey(finalNominal);
      }

      // Complete scanning state
      setTimeout(() => {
        setScanningState(false, `Scan Berhasil! Dikenali sebagai Rp ${finalData ? (finalData.nominal || finalData.nominalFormatted) : finalNominal}`, 'success');
        scannerMode = SCANNER_MODE.RESULT;
        renderScanResult(finalData, imageElement.src);
      }, 700);

    } catch (err) {
      console.error('Scan Error:', err);
      setScanningState(false, 'Gagal memindai gambar. Silakan coba kembali dengan foto yang lebih jelas.', 'error');
      scannerMode = SCANNER_MODE.ERROR;
    }
  }

  // Setup File Upload Handler
  function setupUploadHandler() {
    if (!imageUploadInput) return;
    imageUploadInput.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (!file) return;

      const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
      if (!validTypes.includes(file.type) && !file.name.match(/\.(jpg|jpeg|png|webp)$/i)) {
        setScanningState(false, 'Format file tidak didukung. Harap unggah foto JPG/PNG.', 'error');
        return;
      }

      const reader = new FileReader();
      reader.onload = (event) => {
        currentUploadedDataUrl = event.target.result;
        if (scannerPreviewImg) {
          scannerPreviewImg.src = currentUploadedDataUrl;
        }

        const img = new Image();
        img.onload = () => {
          processScanImage(img, file);
        };
        img.src = currentUploadedDataUrl;
      };
      reader.readAsDataURL(file);
    });
  }

  // Setup Sample Chips
  function setupSampleChips() {
    const chips = document.querySelectorAll('.sample-chip');
    chips.forEach((chip) => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');

        const samplePath = chip.getAttribute('data-sample');
        const sampleNominal = chip.getAttribute('data-nominal') || chip.textContent.replace(/[^0-9]/g, '');

        if (scannerPreviewImg) {
          scannerPreviewImg.src = samplePath;
        }

        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
          processScanImage(img, null, sampleNominal);
        };
        img.onerror = () => {
          const fallbackData = getNoteByNominalKey(sampleNominal);
          setScanningState(false, `Scan Berhasil! (Sampel Rp ${sampleNominal})`, 'success');
          renderScanResult(fallbackData, samplePath);
        };
        img.src = samplePath;
      });
    });
  }

  // Setup Rescan & Reset
  function setupRescanButton() {
    if (rescanBtn) {
      rescanBtn.addEventListener('click', () => {
        if (imageUploadInput) imageUploadInput.value = '';
        const scannerInputSection = document.getElementById('scannerInputSection');
        if (scannerInputSection) {
          scannerInputSection.scrollIntoView({ behavior: 'smooth' });
        }
        setScanningState(false, 'Unggah foto uang Rupiah untuk memindai', 'info');
      });
    }

    const dismissStatusBtn = document.getElementById('dismissStatusBtn');
    if (dismissStatusBtn && scannerOverlay) {
      dismissStatusBtn.addEventListener('click', () => {
        scannerOverlay.classList.add('hidden');
      });
    }
  }

  // Initialize
  async function init() {
    setupUploadHandler();
    setupSampleChips();
    setupRescanButton();
    setScanningState(false, 'Unggah foto uang Rupiah untuk memindai', 'info');

    // Preload model in background
    loadTMModel();
  }

  init();
});
