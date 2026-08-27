<?php
/**
 * RUPANTARA - API SCANNER & DICTIONARY RUPIAH EMISI 2022
 * Menangani permintaan pemindaian uang Rupiah dan menyediakan data komprehensif 7 pecahan.
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Master Dictionary Rupiah Emisi 2022
$rupiahDictionary = [
    '1000' => [
        'id' => '1000',
        'nominal' => '1.000',
        'numeric_value' => 1000,
        'formatted_nominal' => 'Rp 1.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Kuning-Kehijauan / Hijau Zaitun',
        'dimensi' => '121 mm × 65 mm',
        'pahlawan_name' => 'Cut Nyak Meutia',
        'pahlawan_lifespan' => '1870 – 1910',
        'pahlawan_image' => 'GAMBAR_GAMBAR/cut_mutia.jpg',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_1000.jpg',
        'makna_visual' => 'Menggambarkan keindahan Banda Neira dan Tari Tifa dari Maluku, berpadu dengan pesona bunga Anggrek Larat yang melambangkan keanggunan kepulauan timur Indonesia.',
        'sejarah_tokoh' => 'Cut Nyak Meutia adalah pahlawan nasional wanita dari Keureutoe, Pirak, Aceh Utara. Beliau merupakan pejuang kemerdekaan yang gigih memimpin perlawanan gerilya melawan penjajah Belanda di pedalaman hutan Pasai setelah gugurnya sang suami, Teuku Tjik Tunong, hingga beliau syahid dalam pertempuran pada 24 Oktober 1910.',
        'fakta_menarik' => 'Merupakan nominal pecahan kertas terkecil dalam Emisi 2022 dan memiliki dimensi ukuran fisik paling kecil untuk memudahkan identifikasi bagi penyandang tunanetra.',
        'ciri_keaslian' => 'Cetakan terasa kasar (intaglio) pada gambar utama pahlawan, watermark/tanda air bergambar Cut Meutia, dan kode tuna netra (blind code) berupa garis tactile di sudut uang.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Cut Nyak Meutia, pejuang gerilya wanita gigih dari tanah rencong Aceh.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Banda Neira di Kepulauan Maluku yang kaya sejarah pala dan benteng kolonial.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Tifa, tarian penyambutan tradisional khas Maluku dan Papua.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Anggrek Larat, puspa langka khas Maluku bagian tenggara.']
        ],
        'fakta_menarik_items' => [
            'Pecahan kertas dengan dimensi paling kompak (121 mm × 65 mm) dalam keluarga Rupiah Emisi 2022.',
            'Dibuat menggunakan serat kapas murni dengan ketahanan lipat dan tarikan tinggi.',
            'Dilengkapi teknologi cetak ultraviolet yang menampilkan motif pendaran cahaya indah.',
            'Diterbitkan secara resmi oleh Bank Indonesia sebagai alat pembayaran yang sah di seluruh NKRI.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Kasar (Intaglio)', 'desc' => 'Hasil cetak terasa timbul dan kasar saat diraba pada gambar pahlawan, angka nominal, dan tulisan NKRI.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Cut Meutia', 'desc' => 'Tanda air gambar pahlawan Cut Meutia tampak jelas bersama electrotype angka 1 saat diterawang ke arah cahaya.'],
            ['type' => 'blind_code', 'icon_class' => 'fa-solid fa-braille', 'title' => 'Kode Tunanetra (Blind Code)', 'desc' => 'Dua pasang garis diagonal timbul di sisi samping uang untuk identifikasi taktil tunanetra.'],
            ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI', 'desc' => 'Logo Bank Indonesia saling mengisi secara presisi antara sisi depan dan belakang saat diterawang.']
        ]
    ],
    '2000' => [
        'id' => '2000',
        'nominal' => '2.000',
        'numeric_value' => 2000,
        'formatted_nominal' => 'Rp 2.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Abu-abu / Gray',
        'dimensi' => '126 mm × 65 mm',
        'pahlawan_name' => 'Mohammad Husni Thamrin',
        'pahlawan_lifespan' => '1894 – 1941',
        'pahlawan_image' => 'GAMBAR_GAMBAR/Mohammad_Husni_Tamrin.jpeg',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_2000.jpg',
        'makna_visual' => 'Menggambarkan pemandangan Ngarai Sianok yang megah di Bukittinggi dan Tari Piring dari Sumatra Barat, berpadu dengan keindahan bunga Jeumpa.',
        'sejarah_tokoh' => 'Mohammad Husni Thamrin adalah tokoh pergerakan nasional asal Betawi yang memperjuangkan nasib rakyat jelata melalui Volksraad (Dewan Rakyat). Beliau memelopori perbaikan kampung (Kampoengverbetering) di Batavia dan menyatukan faksi-faksi kebangsaan.',
        'fakta_menarik' => 'Tokoh pergerakan nasional asal Betawi yang gigih memperjuangkan hak dan kesejahteraan rakyat, diabadikan pada uang kertas berdominasi warna abu-abu berdimensi 126 mm × 65 mm.',
        'ciri_keaslian' => 'Benang pengaman takar silang, cetakan terasa kasar pada tulisan Bank Indonesia, watermark gambar MH Thamrin, dan logo rectoverso BI yang presisi.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Mohammad Husni Thamrin, perintis kemerdekaan dan pembela kaum jelata asal Betawi.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Ngarai Sianok di Bukittinggi, lembah curam nan hijau di Sumatra Barat.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Piring, tarian atraktif Minangkabau yang menampilkan kelincahan membawa piring.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Jeumpa (Cempaka Wangi) yang harum dan sarat nilai budaya Sumatra.']
        ],
        'fakta_menarik_items' => [
            'M.H. Thamrin mempopulerkan penyebutan kata "Indonesia" secara konsisten dalam sidang resmi parlemen kolonial.',
            'Uang pecahan Rp 2.000 Emisi 2022 dilapisi penguat khusus untuk memperpanjang usia edar uang di masyarakat.',
            'Dominasi warna abu-abu dipadu aksen keemasan modern berstandar internasional.',
            'Menjadi salah satu pecahan uang yang paling sering berpindah tangan dalam transaksi harian.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman (Security Thread)', 'desc' => 'Benang pengaman tertanam yang memuat tulisan BI mikro dan memantulkan kilau di bawah cahaya.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark MH Thamrin', 'desc' => 'Gambar wajah pahlawan MH Thamrin dan electrotype angka 2 terlihat transparan saat diterawang.'],
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Intaglio Kasar', 'desc' => 'Permukaan terasa bergerigi kasar pada gambar pahlawan, angka Rp 2.000, dan lambang Garuda Pancasila.'],
            ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI', 'desc' => 'Potongan ornamen logo BI di sisi depan dan belakang menyatu utuh ketika diarahkan ke sumber cahaya.']
        ]
    ],
    '5000' => [
        'id' => '5000',
        'nominal' => '5.000',
        'numeric_value' => 5000,
        'formatted_nominal' => 'Rp 5.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Cokelat / Brown',
        'dimensi' => '131 mm × 65 mm',
        'pahlawan_name' => 'DR. K.H. Idham Chalid',
        'pahlawan_lifespan' => '1921 – 2010',
        'pahlawan_image' => 'GAMBAR_GAMBAR/KH_Idham_Khalid.jpeg',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_5000.jpg',
        'makna_visual' => 'Menggambarkan keindahan Gunung Bromo di Jawa Timur, keluwesan Tari Gambyong dari Jawa Tengah, serta aroma keanggunan bunga Sedap Malam.',
        'sejarah_tokoh' => 'DR. K.H. Idham Chalid adalah salah satu tokoh ulama besar, intelektual Islam, dan politisi asal Kalimantan Selatan. Beliau menjabat Wakil Perdana Menteri pada era Kabinet Djuanda dan Ali Sastroamidjojo II, serta menjabat sebagai Ketua MPR/DPR RI.',
        'fakta_menarik' => 'Idham Chalid adalah salah satu tokoh ulama dan pahlawan nasional terlama di kabinet Indonesia yang dikenal sebagai sosok pemersatu bangsa yang sangat santun dan moderat.',
        'ciri_keaslian' => 'Hasil cetak timbul (intaglio) tebal, kode tuna netra (blind code) garis tactile, rectoverso logo BI, dan pendaran serat pengaman di bawah sinar ultraviolet.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'DR. K.H. Idham Chalid, ulama negarawan dan tokoh Nahdlatul Ulama yang memimpin parlemen.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Gunung Bromo di Jawa Timur dengan kaldera pasir berbisik yang ikonik.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Gambyong, tarian klasik Jawa Tengah bernuansa anggun penyambut tamu kehormatan.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Sedap Malam yang mekar di malam hari melambangkan keharuman budi pekerti.']
        ],
        'fakta_menarik_items' => [
            'K.H. Idham Chalid memimpin PBNU selama 28 tahun dan mengabdi di pemerintahan selama berpuluh-puluh tahun.',
            'Pecahan Rp 5.000 memiliki ukuran 131 mm × 65 mm dengan gradasi warna cokelat hangat yang kontras.',
            'Dilengkapi microtext tersembunyi beresolusi ultra-tinggi yang sulit ditiru mesin pemindai biasa.',
            'Menggunakan benang pengaman mutakhir yang berubah rona saat digerakkan.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Hasil Cetak Timbul (Intaglio)', 'desc' => 'Efek intaglio sangat terasa kasar saat disentuh di area pahlawan, angka 5000, dan teks BANK INDONESIA.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark K.H. Idham Chalid', 'desc' => 'Tanda air wajah K.H. Idham Chalid yang halus dan electrotype angka 5 terlihat saat diterawang.'],
            ['type' => 'blind_code', 'icon_class' => 'fa-solid fa-braille', 'title' => 'Kode Tunanetra Tactile', 'desc' => 'Garis timbul khusus di tepi kanan dan kiri untuk memudahkan deteksi nominal oleh tunanetra.'],
            ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI', 'desc' => 'Simbol BI yang saling mengisi sempurna di kedua sisi uang tanpa meleset sedikit pun.']
        ]
    ],
    '10000' => [
        'id' => '10000',
        'nominal' => '10.000',
        'numeric_value' => 10000,
        'formatted_nominal' => 'Rp 10.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Ungu / Purple',
        'dimensi' => '136 mm × 65 mm',
        'pahlawan_name' => 'Frans Kaisiepo',
        'pahlawan_lifespan' => '1921 – 1979',
        'pahlawan_image' => 'GAMBAR_GAMBAR/frans_kaisepo.jpeg',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_10000.jpg',
        'makna_visual' => 'Menggambarkan Taman Nasional Wakatobi dan Tari Pakarena dari Sulawesi Selatan, dipadukan dengan pesona bunga Cempaka Hutan Kasar.',
        'sejarah_tokoh' => 'Frans Kaisiepo adalah Pahlawan Nasional asal Biak, Papua. Beliau adalah tokoh kunci yang gigih memperjuangkan integrasi Papua ke dalam pangkuan Negara Kesatuan Republik Indonesia, memimpin delegasi Konferensi Malino 1946, dan menjadi Gubernur Irian Barat.',
        'fakta_menarik' => 'Frans Kaisiepo mengusulkan nama "Irian" yang berasal dari bahasa Biak (Ikut Republik Indonesia Anti Nederlands), menegaskan tekad rakyat Papua bersatu dengan NKRI.',
        'ciri_keaslian' => 'Tinta berubah warna (optically variable ink), microtext tajam angka 10000, watermark Frans Kaisiepo dengan electrotype, dan cetakan timbul intaglio berdaya raba tinggi.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Frans Kaisiepo, perintis kemerdekaan dan Gubernur pertama Papua penjaga kedaulatan NKRI.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Taman Nasional Wakatobi di Sulawesi Tenggara, surga terumbu karang dunia.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Pakarena dari Gowa Sulawesi Selatan yang mencerminkan kelembutan dan kesabaran wanita.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Cempaka Hutan Kasar (Magnolia candollei) khas hutan Sulawesi.']
        ],
        'fakta_menarik_items' => [
            'Frans Kaisiepo mengabadikan akronim "IRIAN" yang membakar semangat pembebasan Papua dari cengkeraman penjajah.',
            'Pecahan Rp 10.000 Emisi 2022 tampil dengan warna ungu mencolok yang mudah dibedakan dari nominal lain.',
            'Dilengkapi tulisan mikroteks "BANK INDONESIA" dan angka 10000 yang hanya terlihat di bawah kaca pembesar.',
            'Memiliki panjang 136 mm, berselisih tepat 5 mm dari pecahan Rp 5.000.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'ovi', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Tinta Berubah Warna (OVI)', 'desc' => 'Ornamen perisai berubah warna secara dinamis saat dilihat dari berbagai sudut pandang.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Frans Kaisiepo', 'desc' => 'Tanda air gambar pahlawan Frans Kaisiepo dan electrotype angka 10 menyala terang saat diterawang.'],
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetak Timbul Intaglio', 'desc' => 'Tekstur rabaan kasar yang jelas pada potret pahlawan dan angka nominal 10.000.'],
            ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Logo Rectoverso', 'desc' => 'Gambar logo BI yang saling melengkapi di kedua sisi secara presisi di bawah cahaya.']
        ]
    ],
    '20000' => [
        'id' => '20000',
        'nominal' => '20.000',
        'numeric_value' => 20000,
        'formatted_nominal' => 'Rp 20.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Hijau / Green',
        'dimensi' => '141 mm × 65 mm',
        'pahlawan_name' => 'Dr. G.S.S.J. Ratulangi (Sam Ratulangi)',
        'pahlawan_lifespan' => '1890 – 1949',
        'pahlawan_image' => 'GAMBAR_GAMBAR/ratulangi.jpg',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_20000.jpg',
        'makna_visual' => 'Menggambarkan keindahan Kepulauan Derawan di Kalimantan Timur, kemegahan Tari Gong dari suku Dayak, dan anggrek hitam langka khas Kalimantan.',
        'sejarah_tokoh' => 'Dr. Gerungan Saul Samuel Jacob Ratulangi (Sam Ratulangi) adalah ilmuwan, politisi, jurnalis, dan Pahlawan Nasional asal Minahasa, Sulawesi Utara. Beliau merupakan penyandang gelar doktor matematika pertama Indonesia dan menjabat sebagai Gubernur Sulawesi pertama.',
        'fakta_menarik' => 'Terkenal dengan semboyan legendaris "Si Tou Timou Tumou Tou" (Manusia baru dapat dikatakan sebagai manusia jika dapat memanusiakan manusia lain).',
        'ciri_keaslian' => 'Benang pengaman berunsur dinamik yang berkilau saat dimiringkan, cetakan terasa kasar pada gambar utama, microtext Bank Indonesia, dan rectoverso logo BI.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Dr. G.S.S.J. Ratulangi, tokoh intelektual, pejuang HAM, dan Gubernur pertama Sulawesi.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Kepulauan Derawan di Kalimantan Timur yang terkenal dengan ubur-ubur tanpa sengat dan penyu hijau.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Gong (Kancet Ledo), tarian tradisional Dayak Kalimantan yang ditarikan anggun di atas gong.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Anggrek Hitam (Coelogyne pandurata), puspa langka eksotis khas Kalimantan.']
        ],
        'fakta_menarik_items' => [
            'Sam Ratulangi adalah doktor ilmu pasti dan alam lulusan Universitas Zurich, Swiss, pada tahun 1919.',
            'Pecahan Rp 20.000 memiliki dimensi 141 mm × 65 mm dengan dominasi warna hijau zamrud yang menyegarkan.',
            'Mengusung kekayaan alam Kalimantan dan kearifan budaya masyarakat Dayak pada sisi belakang.',
            'Menggunakan benang pengaman anyaman canggih berteknologi hologram optik.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman Dinamis', 'desc' => 'Benang anyam yang berubah warna dan memantulkan kilau grafis dinamis saat dimiringkan.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Sam Ratulangi', 'desc' => 'Gambar pahlawan Sam Ratulangi serta electrotype angka 20 terlihat jernih saat diterawang.'],
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetak Timbul Kasar', 'desc' => 'Sensasi rabaan kasar intaglio pada tulisan BANK INDONESIA dan nominal Rp 20.000.'],
            ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Logo Rectoverso', 'desc' => 'Logo BI di kedua sisi tampak menyatu utuh dan sempurna ketika diarahkan ke cahaya.']
        ]
    ],
    '50000' => [
        'id' => '50000',
        'nominal' => '50.000',
        'numeric_value' => 50000,
        'formatted_nominal' => 'Rp 50.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Biru / Blue',
        'dimensi' => '146 mm × 65 mm',
        'pahlawan_name' => 'Ir. H. Djuanda Kartawidjaja',
        'pahlawan_lifespan' => '1911 – 1963',
        'pahlawan_image' => 'GAMBAR_GAMBAR/Djuanda-Kartawidjaja.png',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_50000.jpg',
        'makna_visual' => 'Menggambarkan keindahan Taman Nasional Komodo di Nusa Tenggara Timur, Tari Legong yang agung dari Bali, dan harumnya bunga Jepun Bali (Kamboja).',
        'sejarah_tokoh' => 'Ir. H. Djuanda Kartawidjaja adalah Perdana Menteri terakhir Indonesia dan negarawan berjiwa teknokrat. Beliau mencetuskan "Deklarasi Djuanda" pada 13 Desember 1957 yang menyatakan laut antarpulau adalah wilayah kedaulatan utuh NKRI, melipatgandakan luas wilayah Indonesia.',
        'fakta_menarik' => 'Pencetus Deklarasi Djuanda 1957 yang menyatukan wilayah laut kepulauan Indonesia menjadi kesatuan tanah air tanpa celah laut internasional di dalamnya.',
        'ciri_keaslian' => 'Tinta berubah warna dinamis (SPARK / color-shifting ink) saat dimiringkan, efek intaglio tebal, watermark Ir. H. Djuanda, dan rectoverso berpresisi tinggi.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Ir. H. Djuanda Kartawidjaja, pencetus Wawasan Nusantara yang mempersatukan lautan Indonesia.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Taman Nasional Komodo di NTT, habitat kadal purba terbesar di muka bumi.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Legong dari Keraton Bali dengan gerak mata dan jemari lentik yang memukau.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Jepun Bali (Kamboja) yang menjadi simbol kesucian dan persembahan budaya.']
        ],
        'fakta_menarik_items' => [
            'Berkat Deklarasi Djuanda, luas wilayah kedaulatan Indonesia bertambah 2,5 kali lipat hingga diakui di UNCLOS 1982.',
            'Memiliki panjang 146 mm × 65 mm dengan dominasi warna biru laut nan megah.',
            'Sisi belakang uang melambangkan keindahan kepulauan Sunda Kecil (Bali & Nusa Tenggara).',
            'Mengadopsi teknologi pengaman canggih berstandar mata uang global.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'ovi', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Tinta Berubah Warna Dinamis', 'desc' => 'Ornamen motif perisai berubah warna dari hijau ke biru berkilau saat uang digerakkan.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Ir. H. Djuanda', 'desc' => 'Tanda air wajah Ir. H. Djuanda dengan bayangan tajam dan electrotype angka 50.'],
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Kasar Berdaya Raba', 'desc' => 'Cetakan intaglio yang sangat timbul pada lambang Garuda dan angka nominal 50.000.'],
            ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman Anyam Mikro', 'desc' => 'Benang pengaman dengan efek gerak kinetik bertuliskan "BI 50000".']
        ]
    ],
    '100000' => [
        'id' => '100000',
        'nominal' => '100.000',
        'numeric_value' => 100000,
        'formatted_nominal' => 'Rp 100.000',
        'jenis' => 'Rupiah Kertas',
        'emisi' => 'Tahun Emisi 2022',
        'warna_dominan' => 'Merah / Red',
        'dimensi' => '151 mm × 65 mm',
        'pahlawan_name' => 'Dr. (H.C.) Ir. Soekarno & Drs. Mohammad Hatta',
        'pahlawan_lifespan' => '1901 – 1970 & 1902 – 1980',
        'pahlawan_image' => 'GAMBAR_GAMBAR/soekarno_hatta.jpg',
        'banknote_image' => 'GAMBAR_GAMBAR/uang_100000.jpg',
        'makna_visual' => 'Menggambarkan keindahan gugusan karang Raja Ampat di Papua Barat Daya, keceriaan Tari Topeng Betawi, dan kemegahan puspa pesona Bunga Anggrek Bulan.',
        'sejarah_tokoh' => 'Dr. (H.C.) Ir. Soekarno dan Drs. Mohammad Hatta adalah Dwi-Tunggal Proklamator kemerdekaan Republik Indonesia. Pada 17 Agustus 1945, keduanya memproklamasikan kemerdekaan bangsa Indonesia dari penjajahan dan menjabat sebagai Presiden dan Wakil Presiden pertama RI.',
        'fakta_menarik' => 'Merupakan uang pecahan tertinggi di Indonesia yang menampilkan Dwi-Tunggal Proklamator Kemerdekaan RI dengan dimensi terpanjang (151 mm × 65 mm) dan fitur pengaman paling mutakhir.',
        'ciri_keaslian' => 'Tinta berubah warna (SPARK Live) berlogo BI yang memancarkan kilau lingkaran cahaya, benang pengaman tampak seperti dianyam, dan cetakan intaglio sangat tebal.',
        'makna_visual_items' => [
            ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-users', 'title' => 'Tokoh Proklamator', 'text' => 'Bung Karno dan Bung Hatta, Dwi-Tunggal pendiri bangsa yang memproklamasikan kemerdekaan 1945.'],
            ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Kepulauan Raja Ampat di Papua Barat Daya, mahkota keanekaragaman hayati laut dunia.'],
            ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya', 'text' => 'Tari Topeng Betawi, tarian teater rakyat Jakarta yang dinamis dan sarat pesan moral.'],
            ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Anggrek Bulan (Phalaenopsis amabilis), Puspa Pesona Nasional Indonesia.']
        ],
        'fakta_menarik_items' => [
            'Pecahan tertinggi di Indonesia dengan dimensi terpanjang (151 mm) dan lapisan pelindung anti-lusuh mutakhir.',
            'Menampilkan dua tokoh pahlawan sekaligus sebagai penghormatan tertinggi kepada proklamator bangsa.',
            'Dominasi warna merah menyala yang melambangkan keberanian, kedaulatan, dan semangat persatuan.',
            'Dilengkapi fitur pengaman kelas dunia yang sangat sulit dipalsukan.'
        ],
        'ciri_keaslian_items' => [
            ['type' => 'spark', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Tinta SPARK Live Berubah Warna', 'desc' => 'Logo BI di sudut kiri bawah memancarkan efek lingkaran cahaya bergerak dan berganti warna saat dimiringkan.'],
            ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman Anyam Lebar', 'desc' => 'Benang pengaman selebar 5 mm tampak seperti dianyam pada kertas dengan efek gerak berorientasi optik.'],
            ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Dwi-Tunggal', 'desc' => 'Tanda air gambar Bung Karno dan Bung Hatta beserta electrotype angka 100 terlihat jelas saat diterawang.'],
            ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Intaglio Tebal', 'desc' => 'Hasil cetak timbul berdaya raba sangat kuat pada potret kedua pahlawan, teks, dan angka nominal.']
        ]
    ]
];

if (!function_exists('normalizeNominalInput')) {
    function normalizeNominalInput($input) {
        if (!$input) return null;
        $clean = preg_replace('/[^0-9]/', '', (string)$input);
        if (!$clean) return null;
        
        $map = [
            '1000' => '1000',
            '1' => '1000',
            '2000' => '2000',
            '2' => '2000',
            '5000' => '5000',
            '5' => '5000',
            '10000' => '10000',
            '10' => '10000',
            '20000' => '20000',
            '20' => '20000',
            '50000' => '50000',
            '50' => '50000',
            '100000' => '100000',
            '100' => '100000'
        ];
        
        return isset($map[$clean]) ? $map[$clean] : null;
    }
}

// Tangkap input dari berbagai sumber (POST, GET, JSON Body, File Upload)
$targetNominal = null;
$rawBody = file_get_contents('php://input');
$jsonData = json_decode($rawBody, true);

if (isset($_GET['action']) && $_GET['action'] === 'all') {
    echo json_encode([
        'status' => 'success',
        'total' => count($rupiahDictionary),
        'data' => array_values($rupiahDictionary)
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (isset($_POST['nominal'])) {
    $targetNominal = normalizeNominalInput($_POST['nominal']);
} elseif (isset($_GET['nominal'])) {
    $targetNominal = normalizeNominalInput($_GET['nominal']);
} elseif (is_array($jsonData)) {
    if (isset($jsonData['nominal'])) {
        $targetNominal = normalizeNominalInput($jsonData['nominal']);
    } elseif (isset($jsonData['detected_nominal'])) {
        $targetNominal = normalizeNominalInput($jsonData['detected_nominal']);
    } elseif (isset($jsonData['label'])) {
        $targetNominal = normalizeNominalInput($jsonData['label']);
    }
}

if (!$targetNominal && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $filename = strtolower($_FILES['image']['name']);
    $targetNominal = normalizeNominalInput($filename);
    if (!$targetNominal) {
        $targetNominal = '10000';
    }
}

if (!$targetNominal) {
    $targetNominal = '10000';
}

if (isset($rupiahDictionary[$targetNominal])) {
    $item = $rupiahDictionary[$targetNominal];
    $response = [
        'status' => 'success',
        'nominal' => $item['nominal'],
        'formatted_nominal' => $item['formatted_nominal'],
        'pahlawan_name' => $item['pahlawan_name'],
        'pahlawan_lifespan' => $item['pahlawan_lifespan'],
        'pahlawan_image' => $item['pahlawan_image'],
        'banknote_image' => $item['banknote_image'],
        'makna_visual' => $item['makna_visual'],
        'sejarah_tokoh' => $item['sejarah_tokoh'],
        'fakta_menarik' => $item['fakta_menarik'],
        'ciri_keaslian' => $item['ciri_keaslian'],
        'warna_dominan' => $item['warna_dominan'],
        'emisi' => $item['emisi'],
        'dimensi' => $item['dimensi'],
        'kondisi' => 'Uang Layak Edar (ULE)',
        'makna_visual_items' => $item['makna_visual_items'],
        'fakta_menarik_items' => $item['fakta_menarik_items'],
        'ciri_keaslian_items' => $item['ciri_keaslian_items']
    ];
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Pecahan nominal Rupiah tidak ditemukan dalam database Emisi 2022.',
        'available_nominals' => ['1.000', '2.000', '5.000', '10.000', '20.000', '50.000', '100.000']
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
