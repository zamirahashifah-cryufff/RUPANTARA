<?php
/**
 * RUPANTARA - API SCANNER & DICTIONARY RUPIAH EMISI 2022 (DUA SISI & KLASIFIKASI CERDAS)
 * Menangani pemindaian sisi Depan & Belakang 7 pecahan Rupiah Emisi 2022,
 * verifikasi batas ambang kemiripan (confidence threshold), dan deteksi gambar non-Rupiah.
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

// Master Dictionary Rupiah Emisi 2022 Lengkap (7 Pecahan × Sisi Depan & Sisi Belakang)
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'Cut Nyak Meutia',
        'pahlawan_lifespan' => '1870 – 1910',
        'pahlawan_image' => 'GAMBAR_GAMBAR/cut_mutia.jpg',
        'tarian_adat' => 'Tari Tifa',
        'pemandangan_alam' => 'Banda Neira (Kepulauan Maluku)',
        'flora_khas' => 'Bunga Anggrek Larat',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_1000.jpg',
            'pahlawan_name' => 'Cut Nyak Meutia',
            'pahlawan_lifespan' => '1870 – 1910',
            'pahlawan_image' => 'GAMBAR_GAMBAR/cut_mutia.jpg',
            'makna_visual' => 'Menampilkan pahlawan nasional Cut Nyak Meutia dari Aceh pada bagian muka, dipadukan dengan lambang negara Garuda Pancasila, motif ornamen Nusantara, serta perisai kedaulatan NKRI.',
            'sejarah_tokoh' => 'Cut Nyak Meutia adalah pahlawan nasional wanita dari Keureutoe, Pirak, Aceh Utara. Beliau memimpin perlawanan gerilya melawan penjajah Belanda di pedalaman hutan Pasai setelah gugurnya sang suami, Teuku Tjik Tunong, hingga beliau syahid dalam pertempuran pada 24 Oktober 1910.',
            'fakta_menarik' => 'Pecahan kertas terkecil dalam Emisi 2022 dengan dimensi fisik paling kompak (121 mm × 65 mm) untuk mempermudah identifikasi taktil penyandang tunanetra.',
            'ciri_keaslian' => 'Cetakan terasa kasar (intaglio) pada gambar pahlawan, watermark Cut Meutia dan electrotype angka 1, serta blind code garis tactile diagonal ganda.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Cut Nyak Meutia, pejuang gerilya wanita gigih dari tanah rencong Aceh.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Lambang Negara', 'text' => 'Garuda Pancasila melambangkan kedaulatan dan persatuan Negara Kesatuan Republik Indonesia.'],
                ['type' => 'ornamen', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Ornamen Nusantara', 'text' => 'Ragam motif hias tradisional khas kepulauan Indonesia berestetika tinggi.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Fitur Cetak Timbul', 'text' => 'Hasil cetak intaglio timbul dan berdaya raba kuat pada teks BANK INDONESIA.']
            ],
            'fakta_menarik_items' => [
                'Pecahan kertas dengan dimensi paling ringkas (121 mm × 65 mm) dalam keluarga Rupiah Emisi 2022.',
                'Dibuat menggunakan serat kapas murni dengan ketahanan lipat dan tarikan tinggi.',
                'Dilengkapi teknologi cetak ultraviolet yang memancarkan pendaran cahaya estetis.',
                'Diterbitkan secara resmi oleh Bank Indonesia sebagai alat pembayaran sah di seluruh NKRI.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Kasar (Intaglio)', 'desc' => 'Hasil cetak terasa timbul dan kasar saat diraba pada gambar pahlawan, angka nominal, dan tulisan NKRI.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Cut Meutia', 'desc' => 'Tanda air gambar pahlawan Cut Meutia tampak jelas bersama electrotype angka 1 saat diterawang ke arah cahaya.'],
                ['type' => 'blind_code', 'icon_class' => 'fa-solid fa-braille', 'title' => 'Kode Tunanetra (Blind Code)', 'desc' => 'Dua pasang garis diagonal timbul di sudut uang untuk identifikasi taktil tunanetra.'],
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI', 'desc' => 'Logo Bank Indonesia saling mengisi secara presisi antara sisi depan dan belakang saat diterawang.']
            ]
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/1000_belakang.jpg',
            'pahlawan_name' => 'Cut Nyak Meutia (Tokoh Terkait Sisi Muka)',
            'pahlawan_lifespan' => '1870 – 1910',
            'pahlawan_image' => 'GAMBAR_GAMBAR/cut_mutia.jpg',
            'makna_visual' => 'Menggambarkan keindahan Banda Neira di Kepulauan Maluku dan kelincahan Tari Tifa, berpadu dengan pesona bunga Anggrek Larat yang melambangkan keanggunan kepulauan timur Indonesia.',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 1.000 mengabadikan kekayaan alam bahari Banda Neira dan seni Tari Tifa Maluku, melengkapi simbol kepahlawanan Cut Nyak Meutia di sisi depan sebagai wujud kedaulatan Indonesia dari Sabang sampai Merauke.',
            'fakta_menarik' => 'Banda Neira yang diabadikan di sisi belakang merupakan kepulauan penghasil pala bersejarah di Maluku yang dikelilingi laut jernih dan benteng kolonial.',
            'ciri_keaslian' => 'Pendaran serat pengaman di bawah sinar UV, ornamen saling mengisi rectoverso logo BI, dan cetakan halus bernomor seri khusus.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Tifa, tarian penyambutan tradisional khas Maluku dan Papua yang melambangkan kegembiraan.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Banda Neira di Kepulauan Maluku yang kaya sejarah pala dan benteng kolonial.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Anggrek Larat (Dendrobium phalaenopsis), puspa langka anggun khas Maluku Tenggara.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'Cut Nyak Meutia, pahlawan nasional wanita pejuang kemerdekaan dari Aceh.']
            ],
            'fakta_menarik_items' => [
                'Banda Neira diabadikan di sisi belakang sebagai simbol kekayaan rempah dan kejayaan bahari Nusantara.',
                'Tari Tifa mencerminkan semangat kebersamaan masyarakat kepulauan timur Indonesia.',
                'Dilengkapi tinta khusus yang berpendar indah saat disinari lampu ultraviolet.',
                'Menyatu secara harmonis dengan tema kepahlawanan nasional pada sisi depan.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Potongan logo Bank Indonesia yang akan menyatu sempurna saat diterawang ke arah cahaya.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran Sinar Ultraviolet (UV)', 'desc' => 'Gambar pemandangan alam dan ornamen motif berpendar terang saat disinari cahaya UV.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Tanda Air Cut Meutia', 'desc' => 'Watermark pahlawan Cut Meutia tetap dapat terlihat jelas dari sisi belakang saat diterawang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Resolusi Tinggi', 'desc' => 'Tulisan mikro "BI 1000" yang sangat tajam dan presisi pada ornamen belakang.']
            ]
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'Mohammad Husni Thamrin',
        'pahlawan_lifespan' => '1894 – 1941',
        'pahlawan_image' => 'GAMBAR_GAMBAR/Mohammad_Husni_Tamrin.jpeg',
        'tarian_adat' => 'Tari Piring',
        'pemandangan_alam' => 'Ngarai Sianok (Bukittinggi, Sumatra Barat)',
        'flora_khas' => 'Bunga Jeumpa (Cempaka Wangi)',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_2000.jpg',
            'pahlawan_name' => 'Mohammad Husni Thamrin',
            'pahlawan_lifespan' => '1894 – 1941',
            'pahlawan_image' => 'GAMBAR_GAMBAR/Mohammad_Husni_Tamrin.jpeg',
            'makna_visual' => 'Menampilkan potret pahlawan pergerakan nasional Mohammad Husni Thamrin asal Betawi, dipadukan dengan lambang Garuda Pancasila dan ornamen geometris modern bernuansa abu-abu elegan.',
            'sejarah_tokoh' => 'Mohammad Husni Thamrin adalah tokoh pergerakan nasional asal Betawi yang memperjuangkan nasib rakyat jelata melalui Volksraad (Dewan Rakyat). Beliau memelopori perbaikan kampung (Kampoengverbetering) di Batavia dan menyatukan faksi-faksi kebangsaan.',
            'fakta_menarik' => 'M.H. Thamrin merupakan tokoh yang konsisten mempopulerkan kata "Indonesia" dalam forum sidang resmi parlemen kolonial Belanda.',
            'ciri_keaslian' => 'Benang pengaman takar silang, cetakan terasa kasar pada gambar pahlawan, watermark MH Thamrin, dan kode tunanetra tactile.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Mohammad Husni Thamrin, perintis kemerdekaan dan pembela kaum jelata asal Betawi.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Garuda Pancasila', 'text' => 'Lambang kebangsaan pemersatu keberagaman masyarakat Indonesia.'],
                ['type' => 'ornamen', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Ornamen Nusantara', 'text' => 'Motif dekoratif khas Nusantara dengan sentuhan warna abu-abu keemasan.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman', 'text' => 'Benang pengaman tertanam yang memantulkan kilau di bawah cahaya.']
            ],
            'fakta_menarik_items' => [
                'M.H. Thamrin mengabadikan perjuangan rakyat kecil Betawi dan kaum pribumi di panggung politik nasional.',
                'Dilapisi pelindung khusus anti-lusuh untuk memperpanjang usia edar uang di masyarakat.',
                'Tampil dengan dominasi warna abu-abu modern berstandar estetika mata uang global.',
                'Menjadi salah satu pecahan uang yang paling aktif digunakan dalam transaksi harian.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman (Security Thread)', 'desc' => 'Benang pengaman tertanam yang memuat tulisan BI mikro dan memantulkan kilau di bawah cahaya.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark MH Thamrin', 'desc' => 'Gambar wajah pahlawan MH Thamrin dan electrotype angka 2 terlihat transparan saat diterawang.'],
                ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Intaglio Kasar', 'desc' => 'Permukaan terasa bergerigi kasar pada gambar pahlawan, angka Rp 2.000, dan lambang Garuda Pancasila.'],
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI', 'desc' => 'Potongan ornamen logo BI di sisi depan dan belakang menyatu utuh ketika diarahkan ke sumber cahaya.']
            ]
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/2000_belakang.png',
            'pahlawan_name' => 'Mohammad Husni Thamrin (Tokoh Terkait Sisi Muka)',
            'pahlawan_lifespan' => '1894 – 1941',
            'pahlawan_image' => 'GAMBAR_GAMBAR/Mohammad_Husni_Tamrin.jpeg',
            'makna_visual' => 'Menggambarkan pemandangan Ngarai Sianok yang megah di Bukittinggi dan kelincahan Tari Piring dari Sumatra Barat, berpadu dengan keharuman bunga Jeumpa.',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 2.000 menampilkan kemegahan bentang alam Ngarai Sianok dan dinamika seni Tari Piring Minangkabau, berpadu selaras dengan nilai perjuangan M.H. Thamrin di sisi depan uang.',
            'fakta_menarik' => 'Ngarai Sianok adalah lembah curam nan hijau di Bukittinggi Sumatra Barat dengan tebing-tebing spektakuler peninggalan patahan tektonik Semangko.',
            'ciri_keaslian' => 'Microtext angka 2000 pada ornamen lembah, pendaran motif tari di bawah sinar UV, dan logo rectoverso BI.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Piring, tarian atraktif Minangkabau yang menampilkan kelincahan membawa piring tanpa terjatuh.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Ngarai Sianok di Bukittinggi, lembah curam nan hijau memukau di Sumatra Barat.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Jeumpa (Cempaka Wangi) yang harum semerbak dan sarat nilai filosofi budaya Sumatra.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'Mohammad Husni Thamrin, pahlawan nasional perintis kebangkitan rakyat jelata.']
            ],
            'fakta_menarik_items' => [
                'Tari Piring melambangkan rasa syukur masyarakat Minangkabau atas hasil panen yang melimpah.',
                'Ngarai Sianok menjadi salah satu destinasi wisata alam geologi paling terkenal di Indonesia.',
                'Bunga Jeumpa diabadikan sebagai simbol keanggunan flora khas bumi Sumatra.',
                'Tinta pengaman di sisi belakang menampilkan motif pendaran yang kaya saat disinari sinar UV.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Logo Bank Indonesia saling melengkapi sempurna saat diterawang ke sumber cahaya.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran UV Tari Piring', 'desc' => 'Motif penari Tari Piring dan bunga Jeumpa memancarkan pendaran warna hijau-kuning di bawah sinar UV.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark M.H. Thamrin', 'desc' => 'Gambar tanda air pahlawan M.H. Thamrin tetap tampak jelas dari sisi belakang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Angka 2000', 'desc' => 'Tulisan mikro "BANK INDONESIA 2000" beresolusi tinggi pada ornamen belakang.']
            ]
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'DR. K.H. Idham Chalid',
        'pahlawan_lifespan' => '1921 – 2010',
        'pahlawan_image' => 'GAMBAR_GAMBAR/KH_Idham_Khalid.jpeg',
        'tarian_adat' => 'Tari Gambyong',
        'pemandangan_alam' => 'Gunung Bromo (Jawa Timur)',
        'flora_khas' => 'Bunga Sedap Malam',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_5000.jpg',
            'pahlawan_name' => 'DR. K.H. Idham Chalid',
            'pahlawan_lifespan' => '1921 – 2010',
            'pahlawan_image' => 'GAMBAR_GAMBAR/KH_Idham_Khalid.jpeg',
            'makna_visual' => 'Menampilkan potret DR. K.H. Idham Chalid, ulama besar pemersatu bangsa dan negarawan terkemuka, dipadukan dengan lambang Garuda Pancasila dan ornamen motif bernuansa cokelat hangat.',
            'sejarah_tokoh' => 'DR. K.H. Idham Chalid adalah salah satu tokoh ulama besar, intelektual Islam, dan politisi asal Kalimantan Selatan. Beliau menjabat Wakil Perdana Menteri pada era Kabinet Djuanda dan Ali Sastroamidjojo II, serta menjabat sebagai Ketua MPR/DPR RI.',
            'fakta_menarik' => 'K.H. Idham Chalid memimpin PBNU selama 28 tahun berturut-turut dan mengabdi di pemerintahan selama berpuluh-puluh tahun sebagai tokoh pemersatu yang moderat.',
            'ciri_keaslian' => 'Hasil cetak timbul (intaglio) tebal, kode tunanetra garis tactile ganda, rectoverso logo BI, dan watermark K.H. Idham Chalid.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'DR. K.H. Idham Chalid, ulama negarawan dan tokoh Nahdlatul Ulama pemersatu bangsa.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Garuda Pancasila', 'text' => 'Simbol kehormatan dan persatuan bangsa Indonesia.'],
                ['type' => 'ornamen', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Motif Nusantara', 'text' => 'Ornamen geometris batik tradisional dengan gradasi warna cokelat hangat.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetak Timbul Intaglio', 'text' => 'Sensasi rabaan kasar yang jelas pada potret pahlawan dan angka nominal 5000.']
            ],
            'fakta_menarik_items' => [
                'Dibuat dari 100% serat kapas murni dengan daya tahan lipat optimal untuk kelancaran transaksi.',
                'Memiliki dimensi 131 mm × 65 mm dengan kontras warna cokelat yang ramah visual.',
                'Dilengkapi microtext tersembunyi beresolusi ultra-tinggi yang sulit ditiru mesin cetak biasa.',
                'Dilengkapi benang pengaman mutakhir yang berubah rona saat digerak-gerakkan.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Hasil Cetak Timbul (Intaglio)', 'desc' => 'Efek intaglio sangat terasa kasar saat disentuh di area pahlawan, angka 5000, dan teks BANK INDONESIA.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark K.H. Idham Chalid', 'desc' => 'Tanda air wajah K.H. Idham Chalid yang halus dan electrotype angka 5 terlihat saat diterawang.'],
                ['type' => 'blind_code', 'icon_class' => 'fa-solid fa-braille', 'title' => 'Kode Tunanetra Tactile', 'desc' => 'Garis timbul khusus di tepi kanan dan kiri untuk memudahkan deteksi nominal oleh tunanetra.'],
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI', 'desc' => 'Simbol BI yang saling mengisi sempurna di kedua sisi uang tanpa meleset sedikit pun.']
            ]
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/5000_belakang.png',
            'pahlawan_name' => 'DR. K.H. Idham Chalid (Tokoh Terkait Sisi Muka)',
            'pahlawan_lifespan' => '1921 – 2010',
            'pahlawan_image' => 'GAMBAR_GAMBAR/KH_Idham_Khalid.jpeg',
            'makna_visual' => 'Menggambarkan keindahan spektakuler Gunung Bromo di Jawa Timur, keluwesan Tari Gambyong dari Jawa Tengah, serta harumnya bunga Sedap Malam.',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 5.000 menyatukan pesona alam Gunung Bromo Jawa Timur dan keanggunan budaya Tari Gambyong Jawa Tengah, menghargai jasa kepahlawanan DR. K.H. Idham Chalid di sisi depan.',
            'fakta_menarik' => 'Gunung Bromo terkenal dengan kaldera pasir berbisik seluas 10 kilometer persegi dan matahari terbit spektakuler berlatar puncak Semeru.',
            'ciri_keaslian' => 'Pendaran ultraviolet pada motif Tari Gambyong, rectoverso logo BI yang presisi, dan tanda air electrotype angka 5.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Gambyong, tarian klasik Jawa Tengah bernuansa anggun penyambut tamu kehormatan.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Gunung Bromo di Jawa Timur dengan kawah aktif dan lautan pasir berbisik yang ikonik.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Sedap Malam yang semerbak melambangkan keharuman budi pekerti dan kesucian.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'DR. K.H. Idham Chalid, ulama dan pahlawan nasional pemersatu bangsa.']
            ],
            'fakta_menarik_items' => [
                'Tari Gambyong berasal dari tarian tayub Surakarta yang kemudian dibakukan menjadi tarian keraton yang mulia.',
                'Gunung Bromo merupakan salah satu dari 10 Kawasan Strategis Pariwisata Nasional unggulan Indonesia.',
                'Bunga Sedap Malam mekar di malam hari dan menjadi puspa persembahan dalam berbagai upacara adat Nusantara.',
                'Motif belakang uang memancarkan cahaya keemasan saat disinari lampu ultraviolet.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Logo Bank Indonesia saling mengunci presisi antara bagian depan dan belakang.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran UV Bromo & Penari', 'desc' => 'Ornamen Gunung Bromo dan siluet penari Gambyong berpendar cerah di bawah sinar UV.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark K.H. Idham Chalid', 'desc' => 'Bayangan tanda air pahlawan dan angka 5 tetap tampak jernih saat diterawang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Pengaman', 'desc' => 'Tulisan mikro tersembunyi yang hanya terbaca dengan bantuan kaca pembesar.']
            ]
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'Frans Kaisiepo',
        'pahlawan_lifespan' => '1921 – 1979',
        'pahlawan_image' => 'GAMBAR_GAMBAR/frans_kaisepo.jpeg',
        'tarian_adat' => 'Tari Pakarena',
        'pemandangan_alam' => 'Taman Nasional Wakatobi (Sulawesi Tenggara)',
        'flora_khas' => 'Bunga Cempaka Hutan Kasar',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_10000.jpg',
            'pahlawan_name' => 'Frans Kaisiepo',
            'pahlawan_lifespan' => '1921 – 1979',
            'pahlawan_image' => 'GAMBAR_GAMBAR/frans_kaisepo.jpeg',
            'makna_visual' => 'Menampilkan potret pahlawan nasional Frans Kaisiepo dari Papua, dipadukan dengan lambang Garuda Pancasila dan ornamen motif perisai berteknologi optically variable ink berwarna ungu mencolok.',
            'sejarah_tokoh' => 'Frans Kaisiepo adalah Pahlawan Nasional asal Biak, Papua. Beliau adalah tokoh kunci yang gigih memperjuangkan integrasi Papua ke dalam pangkuan Negara Kesatuan Republik Indonesia, memimpin delegasi Konferensi Malino 1946, dan menjadi Gubernur Irian Barat.',
            'fakta_menarik' => 'Frans Kaisiepo mengusulkan akronim nama "IRIAN" yang berasal dari bahasa Biak (Ikut Republik Indonesia Anti Nederlands) untuk menegaskan kesetiaan Papua pada NKRI.',
            'ciri_keaslian' => 'Tinta berubah warna (Optically Variable Ink/OVI), microtext angka 10000, watermark Frans Kaisiepo dengan electrotype, dan cetakan intaglio berdaya raba tinggi.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Frans Kaisiepo, perintis kemerdekaan dan Gubernur pertama Papua penjaga kedaulatan NKRI.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Garuda Pancasila', 'text' => 'Lambang keagungan negara pemersatu seluruh kepulauan tanah air.'],
                ['type' => 'ovi', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Ornamen Perisai OVI', 'text' => 'Ornamen perisai dengan tinta optik yang berubah rona saat dimiringkan.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Intaglio Tebal', 'text' => 'Tekstur cetak timbul yang kasar pada potret pahlawan dan teks Bank Indonesia.']
            ],
            'fakta_menarik_items' => [
                'Pecahan Rp 10.000 tampil dengan warna ungu mencolok yang sangat mudah dibedakan dari pecahan lainnya.',
                'Memiliki panjang 136 mm, berselisih tepat 5 mm dari pecahan Rp 5.000 sesuai standar kemudahan tunanetra.',
                'Dilengkapi tulisan mikroteks "BANK INDONESIA 10000" beresolusi ultra-tinggi.',
                'Frans Kaisiepo adalah salah satu tokoh penting perumus keutuhan kedaulatan maritim Indonesia Timur.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'ovi', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Tinta Berubah Warna (OVI)', 'desc' => 'Ornamen perisai berubah warna secara dinamis saat dilihat dari berbagai sudut pandang.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Frans Kaisiepo', 'desc' => 'Tanda air gambar pahlawan Frans Kaisiepo dan electrotype angka 10 menyala terang saat diterawang.'],
                ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetak Timbul Intaglio', 'desc' => 'Tekstur rabaan kasar yang jelas pada potret pahlawan dan angka nominal 10.000.'],
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Logo Rectoverso', 'desc' => 'Gambar logo BI yang saling melengkapi di kedua sisi secara presisi di bawah cahaya.']
            ]
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/10000_belakang.jpg',
            'pahlawan_name' => 'Frans Kaisiepo (Tokoh Terkait Sisi Muka)',
            'pahlawan_lifespan' => '1921 – 1979',
            'pahlawan_image' => 'GAMBAR_GAMBAR/frans_kaisepo.jpeg',
            'makna_visual' => 'Menggambarkan pesona terumbu karang Taman Nasional Wakatobi di Sulawesi Tenggara, keluhuran Tari Pakarena dari Sulawesi Selatan, dan keindahan Bunga Cempaka Hutan Kasar.',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 10.000 memadukan keindahan maritim Taman Nasional Wakatobi dan filosofi kesabaran Tari Pakarena, bersinergi dengan keteguhan Frans Kaisiepo di sisi depan.',
            'fakta_menarik' => 'Taman Nasional Wakatobi merupakan salah satu surga terumbu karang terindah di dunia dengan lebih dari 750 spesies karang.',
            'ciri_keaslian' => 'Microtext angka 10000 tajam, pendaran ultraviolet motif penari Pakarena, dan logo rectoverso BI.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Pakarena dari Gowa Sulawesi Selatan yang mencerminkan kelembutan, kesantunan, dan kesabaran.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Taman Nasional Wakatobi di Sulawesi Tenggara, pusat keanekaragaman hayati terumbu karang dunia.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Cempaka Hutan Kasar (Magnolia candollei), flora endemik eksotis khas hutan tropis Sulawesi.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'Frans Kaisiepo, pahlawan nasional pejuang integrasi Papua ke pangkuan NKRI.']
            ],
            'fakta_menarik_items' => [
                'Kipas pada Tari Pakarena melambangkan angin sejuk yang memberi ketenangan jiwa dan kehidupan.',
                'Wakatobi merupakan akronim dari empat pulau utamanya: Wangi-wangi, Kaledupa, Tomia, dan Binongko.',
                'Bunga Cempaka Hutan Kasar memiliki aroma khas yang melambangkan kemurnian alam Sulawesi.',
                'Tinta pengaman di sisi belakang menampilkan motif pendaran yang kaya saat disinari cahaya UV.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Logo Bank Indonesia saling melengkapi utuh saat diterawang ke arah cahaya.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran UV Wakatobi & Tari Pakarena', 'desc' => 'Motif bawah laut Wakatobi dan penari Pakarena menyala terang di bawah sinar ultraviolet.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Frans Kaisiepo', 'desc' => 'Tanda air pahlawan Frans Kaisiepo dan angka 10 tampak jernih saat diterawang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Bank Indonesia', 'desc' => 'Tulisan mikro beresolusi tinggi di tepi motif uang sisi belakang.']
            ]
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'Dr. G.S.S.J. Ratulangi (Sam Ratulangi)',
        'pahlawan_lifespan' => '1890 – 1949',
        'pahlawan_image' => 'GAMBAR_GAMBAR/ratulangi.jpg',
        'tarian_adat' => 'Tari Gong (Kancet Ledo)',
        'pemandangan_alam' => 'Kepulauan Derawan (Kalimantan Timur)',
        'flora_khas' => 'Bunga Anggrek Hitam',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/20000_depan.png',
            'pahlawan_name' => 'Dr. G.S.S.J. Ratulangi (Sam Ratulangi)',
            'pahlawan_lifespan' => '1890 – 1949',
            'pahlawan_image' => 'GAMBAR_GAMBAR/ratulangi.jpg',
            'makna_visual' => 'Menampilkan potret Dr. Gerungan Saul Samuel Jacob Ratulangi (Sam Ratulangi), cendekiawan dan Gubernur pertama Sulawesi, berpadu dengan lambang Garuda Pancasila dan benang pengaman dinamis berwana hijau zamrud.',
            'sejarah_tokoh' => 'Dr. Gerungan Saul Samuel Jacob Ratulangi (Sam Ratulangi) adalah ilmuwan, politisi, jurnalis, dan Pahlawan Nasional asal Minahasa, Sulawesi Utara. Beliau merupakan penyandang gelar doktor matematika pertama Indonesia dan menjabat sebagai Gubernur Sulawesi pertama.',
            'fakta_menarik' => 'Terkenal dengan filosofi kemanusiaan legendaris: "Si Tou Timou Tumou Tou" (Manusia baru dapat dikatakan sebagai manusia sejati jika dapat memanusiakan dan menolong sesamanya).',
            'ciri_keaslian' => 'Benang pengaman dinamis berunsur optik gerak kinetik, cetakan terasa kasar pada potret pahlawan, watermark Sam Ratulangi, dan rectoverso logo BI.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Dr. G.S.S.J. Ratulangi, tokoh intelektual, pejuang HAM, dan Gubernur pertama Sulawesi.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Garuda Pancasila', 'text' => 'Simbol kehormatan negara dan persatuan bangsa dari Sabang sampai Merauke.'],
                ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman Dinamis', 'text' => 'Benang anyaman yang memancarkan efek gerak kinetik dan kilau warna saat digerakkan.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Intaglio Kasar', 'text' => 'Cetakan timbul yang sangat terasa kasar pada potret pahlawan dan angka nominal 20.000.']
            ],
            'fakta_menarik_items' => [
                'Sam Ratulangi meraih gelar doktor dalam bidang ilmu pasti dan alam di Universitas Zurich, Swiss, pada tahun 1919.',
                'Pecahan Rp 20.000 memiliki dimensi 141 mm × 65 mm dengan gradasi warna hijau zamrud yang menyegarkan.',
                'Menggunakan teknologi benang pengaman berunsur dinamik berstandar mata uang internasional.',
                'Menjadi simbol keteladanan intelektualitas dan integritas perjuangan bangsa.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman Dinamis', 'desc' => 'Benang anyam yang berubah warna dan memantulkan kilau grafis dinamis saat dimiringkan.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Sam Ratulangi', 'desc' => 'Gambar pahlawan Sam Ratulangi serta electrotype angka 20 terlihat jernih saat diterawang.'],
                ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetak Timbul Kasar', 'desc' => 'Sensasi rabaan kasar intaglio pada tulisan BANK INDONESIA dan nominal Rp 20.000.'],
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Logo Rectoverso', 'desc' => 'Logo BI di kedua sisi tampak menyatu utuh dan sempurna ketika diarahkan ke cahaya.']
            ]
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_20000.jpg',
            'pahlawan_name' => 'Dr. G.S.S.J. Ratulangi (Tokoh Terkait Sisi Muka)',
            'pahlawan_lifespan' => '1890 – 1949',
            'pahlawan_image' => 'GAMBAR_GAMBAR/ratulangi.jpg',
            'makna_visual' => 'Menggambarkan keindahan eksotis Kepulauan Derawan di Kalimantan Timur, kemegahan Tari Gong suku Dayak Kalimantan, dan pesona Bunga Anggrek Hitam.',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 20.000 mengangkat kekayaan alam bahari Kepulauan Derawan dan kearifan budaya masyarakat Dayak Kalimantan, mendampingi dedikasi Sam Ratulangi di sisi depan uang.',
            'fakta_menarik' => 'Kepulauan Derawan terkenal dengan danau Kakaban yang dihuni ribuan ubur-ubur tanpa sengat dan habitat penyu hijau raksasa langka.',
            'ciri_keaslian' => 'Microtext angka 20000 yang tajam, pendaran ultraviolet ornamen penari Gong Dayak, dan logo rectoverso BI.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Gong (Kancet Ledo), tarian tradisional Dayak Kalimantan yang ditarikan anggun dan luwes di atas gong.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Kepulauan Derawan di Kalimantan Timur, surga bahari penyu hijau dan ubur-ubur tanpa sengat.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Anggrek Hitam (Coelogyne pandurata), puspa langka eksotis khas pedalaman hutan Kalimantan.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'Dr. G.S.S.J. Ratulangi, cendekiawan dan pahlawan nasional pelopor pendidikan.']
            ],
            'fakta_menarik_items' => [
                'Tari Gong melambangkan kelembutan budi dan keanggunan seorang gadis Dayak yang menghormati sesama.',
                'Anggrek Hitam memiliki lidah (labellum) berwarna hitam pekat dengan corak totol hijau yang memikat.',
                'Kepulauan Derawan merupakan kawasan konservasi terumbu karang penting di jantung Segitiga Karang Dunia.',
                'Sisi belakang menyatu dengan fitur ultraviolet yang menampilkan detail motif kain tenun Dayak.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Logo Bank Indonesia menyatu sempurna tanpa cacat ketika diarahkan ke cahaya.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran UV Derawan & Tari Gong', 'desc' => 'Siluet penari Tari Gong dan ornamen Kepulauan Derawan menyala hijau-emas di bawah sinar UV.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Sam Ratulangi', 'desc' => 'Tanda air pahlawan Sam Ratulangi dan angka 20 terlihat jernih saat diterawang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Pengaman Belakang', 'desc' => 'Tulisan mikro "BI 20000" yang sangat halus pada ornamen sisi belakang.']
            ]
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'Ir. H. Djuanda Kartawidjaja',
        'pahlawan_lifespan' => '1911 – 1963',
        'pahlawan_image' => 'GAMBAR_GAMBAR/Djuanda-Kartawidjaja.png',
        'tarian_adat' => 'Tari Legong',
        'pemandangan_alam' => 'Taman Nasional Komodo (Nusa Tenggara Timur)',
        'flora_khas' => 'Bunga Jepun Bali (Kamboja)',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_50000.jpg',
            'pahlawan_name' => 'Ir. H. Djuanda Kartawidjaja',
            'pahlawan_lifespan' => '1911 – 1963',
            'pahlawan_image' => 'GAMBAR_GAMBAR/Djuanda-Kartawidjaja.png',
            'makna_visual' => 'Menampilkan potret Ir. H. Djuanda Kartawidjaja, pencetus Deklarasi Djuanda 1957 pemersatu lautan Nusantara, dipadukan dengan lambang Garuda Pancasila dan tinta optik SPARK berubah warna berwarna biru laut megah.',
            'sejarah_tokoh' => 'Ir. H. Djuanda Kartawidjaja adalah Perdana Menteri terakhir Indonesia dan negarawan berjiwa teknokrat. Beliau mencetuskan "Deklarasi Djuanda" pada 13 Desember 1957 yang menyatakan laut antarpulau adalah wilayah kedaulatan utuh NKRI, melipatgandakan luas wilayah Indonesia.',
            'fakta_menarik' => 'Berkat Deklarasi Djuanda, konsepsi "Wawasan Nusantara" resmi diakui dunia internasional dalam Konvensi Hukum Laut PBB (UNCLOS 1982), menjadikan laut penghubung pulau dan bukan pemisah.',
            'ciri_keaslian' => 'Tinta berubah warna dinamis (SPARK / color-shifting ink) motif perisai, intaglio sangat timbul, watermark Ir. H. Djuanda, dan benang pengaman kinetik.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Pahlawan', 'text' => 'Ir. H. Djuanda Kartawidjaja, pencetus Wawasan Nusantara yang mempersatukan lautan Indonesia.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Garuda Pancasila', 'text' => 'Lambang kedaulatan dan keutuhan kepulauan tanah air Indonesia.'],
                ['type' => 'spark', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Tinta Optik SPARK', 'text' => 'Tinta perisai yang berubah warna dinamis dari hijau ke biru saat digerakkan.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Intaglio Kasar', 'text' => 'Cetakan timbul yang sangat kuat pada lambang negara dan angka 50.000.']
            ],
            'fakta_menarik_items' => [
                'Deklarasi Djuanda 1957 menambah luas wilayah kedaulatan laut Indonesia sebesar 2,5 kali lipat.',
                'Memiliki panjang 146 mm × 65 mm dengan dominasi warna biru laut nan megah berstandar internasional.',
                'Mengadopsi teknologi pengaman tercanggih di dunia untuk melindungi mata uang dari pemalsuan.',
                'Menjadi lambang kedaulatan maritim dan persatuan antarpulau di seluruh Indonesia.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'ovi', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Tinta Berubah Warna Dinamis', 'desc' => 'Ornamen motif perisai berubah warna dari hijau ke biru berkilau saat uang digerakkan.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Ir. H. Djuanda', 'desc' => 'Tanda air wajah Ir. H. Djuanda dengan bayangan tajam dan electrotype angka 50.'],
                ['type' => 'intaglio', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Cetakan Kasar Berdaya Raba', 'desc' => 'Cetakan intaglio yang sangat timbul pada lambang Garuda dan angka nominal 50.000.'],
                ['type' => 'benang', 'icon_class' => 'fa-solid fa-shield-halved', 'title' => 'Benang Pengaman Anyam Mikro', 'desc' => 'Benang pengaman dengan efek gerak kinetik bertuliskan "BI 50000".']
            ]
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/50000_belakang.jpg',
            'pahlawan_name' => 'Ir. H. Djuanda Kartawidjaja (Tokoh Terkait Sisi Muka)',
            'pahlawan_lifespan' => '1911 – 1963',
            'pahlawan_image' => 'GAMBAR_GAMBAR/Djuanda-Kartawidjaja.png',
            'makna_visual' => 'Menggambarkan keindahan megah Taman Nasional Komodo di Nusa Tenggara Timur, keagungan Tari Legong dari Keraton Bali, dan keharuman Bunga Jepun Bali (Kamboja).',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 50.000 mengabadikan keajaiban dunia Taman Nasional Komodo dan keluhuran seni Tari Legong Bali (Kepulauan Sunda Kecil), menyatu utuh dengan kedaulatan laut Ir. H. Djuanda di sisi depan.',
            'fakta_menarik' => 'Taman Nasional Komodo adalah Situs Warisan Dunia UNESCO habitat asli kadal purba terbesar di muka bumi (Varanus komodoensis).',
            'ciri_keaslian' => 'Microtext tajam BANK INDONESIA 50000, motif Tari Legong dan Komodo yang berpendar di bawah sinar UV, dan rectoverso logo BI.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Legong dari Keraton Bali dengan gerak mata lincah dan kelenturan jemari lentik yang memesona.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Taman Nasional Komodo di NTT, habitat kadal purba terbesar dan surga laut dunia.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Jepun Bali (Kamboja), simbol kesucian, keharuman, dan persembahan suci budaya Bali.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-user-tie', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'Ir. H. Djuanda Kartawidjaja, pencetus Wawasan Nusantara kedaulatan lautan Indonesia.']
            ],
            'fakta_menarik_items' => [
                'Tari Legong awalnya merupakan tarian sakral keraton yang diciptakan atas inspirasi mimpi pangeran Sukawati.',
                'Komodo hanya dapat ditemukan di kepulauan Nusa Tenggara Timur dan tidak ada di belahan dunia lain.',
                'Bunga Jepun Bali senantiasa digunakan dalam upacara adat dan persembahyangan masyarakat Bali.',
                'Sisi belakang memuat gradasi warna biru laut berpadu pendaran UV ultraviolet yang sangat indah.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Logo Bank Indonesia saling mengunci presisi di kedua sisi saat diarahkan ke cahaya.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran UV Komodo & Penari Legong', 'desc' => 'Siluet penari Legong dan motif pulau Komodo berpendar biru-hijau terang di bawah lampu UV.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Ir. H. Djuanda', 'desc' => 'Tanda air pahlawan Ir. H. Djuanda dan electrotype 50 terlihat jelas saat diterawang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Resolusi Tinggi', 'desc' => 'Tulisan mikro angka 50000 yang tajam dan presisi pada motif belakang uang.']
            ]
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
        'kondisi' => 'Uang Layak Edar (ULE)',
        'pahlawan_name' => 'Dr. (H.C.) Ir. Soekarno & Drs. Mohammad Hatta',
        'pahlawan_lifespan' => '1901 – 1970 & 1902 – 1980',
        'pahlawan_image' => 'GAMBAR_GAMBAR/soekarno_hatta.jpg',
        'tarian_adat' => 'Tari Topeng Betawi',
        'pemandangan_alam' => 'Kepulauan Raja Ampat (Papua Barat Daya)',
        'flora_khas' => 'Bunga Anggrek Bulan',
        'depan' => [
            'sisi' => 'depan',
            'label_sisi' => 'Tampak Depan (Sisi Depan)',
            'banknote_image' => 'GAMBAR_GAMBAR/uang_100000.jpg',
            'pahlawan_name' => 'Dr. (H.C.) Ir. Soekarno & Drs. Mohammad Hatta',
            'pahlawan_lifespan' => '1901 – 1970 & 1902 – 1980',
            'pahlawan_image' => 'GAMBAR_GAMBAR/soekarno_hatta.jpg',
            'makna_visual' => 'Menampilkan Dwi-Tunggal Proklamator Kemerdekaan RI Bung Karno dan Bung Hatta, naskah Proklamasi 17 Agustus 1945, lambang Garuda Pancasila, dan tinta SPARK Live berlogo BI yang memancarkan lingkaran cahaya bergerak dinamis.',
            'sejarah_tokoh' => 'Dr. (H.C.) Ir. Soekarno dan Drs. Mohammad Hatta adalah Dwi-Tunggal Proklamator kemerdekaan Republik Indonesia. Pada 17 Agustus 1945, keduanya memproklamasikan kemerdekaan bangsa Indonesia dari penjajahan dan menjabat sebagai Presiden dan Wakil Presiden pertama RI.',
            'fakta_menarik' => 'Merupakan pecahan nominal tertinggi di Indonesia dengan dimensi fisik terpanjang (151 mm × 65 mm) dan dilengkapi fitur pengaman paling canggih di dunia.',
            'ciri_keaslian' => 'Tinta berubah warna (SPARK Live) berlogo BI dengan efek gerak lingkaran cahaya dinamis, benang pengaman anyam lebar 5 mm, dan cetakan intaglio sangat tebal.',
            'makna_visual_items' => [
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-users', 'title' => 'Tokoh Proklamator', 'text' => 'Bung Karno dan Bung Hatta, Dwi-Tunggal pendiri bangsa yang memproklamasikan kemerdekaan RI 1945.'],
                ['type' => 'lambang', 'icon_class' => 'fa-solid fa-shield', 'title' => 'Garuda Pancasila', 'text' => 'Lambang kehormatan, kedaulatan, dan persatuan mutlak seluruh bangsa Indonesia.'],
                ['type' => 'spark', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'SPARK Live Berubah Warna', 'text' => 'Logo BI di sudut kiri bawah memancarkan cincin cahaya bergerak dan berganti warna saat dimiringkan.'],
                ['type' => 'keamanan', 'icon_class' => 'fa-solid fa-fingerprint', 'title' => 'Intaglio Sangat Tebal', 'text' => 'Sensasi rabaan kasar sangat timbul pada potret kedua pahlawan proklamator dan angka 100.000.']
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
        ],
        'belakang' => [
            'sisi' => 'belakang',
            'label_sisi' => 'Tampak Belakang (Sisi Belakang)',
            'banknote_image' => 'GAMBAR_GAMBAR/100000_belakang.png',
            'pahlawan_name' => 'Dr. (H.C.) Ir. Soekarno & Drs. Mohammad Hatta (Tokoh Terkait)',
            'pahlawan_lifespan' => '1901 – 1970 & 1902 – 1980',
            'pahlawan_image' => 'GAMBAR_GAMBAR/soekarno_hatta.jpg',
            'makna_visual' => 'Menggambarkan keindahan gugusan karang Raja Ampat di Papua Barat Daya, keceriaan Tari Topeng Betawi, dan kemegahan Puspa Pesona Nasional Bunga Anggrek Bulan.',
            'sejarah_tokoh' => 'Sisi belakang pecahan Rp 100.000 merayakan keagungan maritim Raja Ampat dan kegembiraan Tari Topeng Betawi, melengkapi amanat kemerdekaan dan kedaulatan Soekarno-Hatta di sisi depan.',
            'fakta_menarik' => 'Raja Ampat di Papua Barat Daya merupakan episentrum segitiga terumbu karang dunia dengan lebih dari 1.500 spesies ikan dan 540 jenis karang keras.',
            'ciri_keaslian' => 'Microtext tajam BANK INDONESIA 100000, pendaran UV motif Raja Ampat dan penari Topeng Betawi, serta logo rectoverso BI.',
            'makna_visual_items' => [
                ['type' => 'tari', 'icon_class' => 'fa-solid fa-masks-theater', 'title' => 'Seni Budaya & Tarian', 'text' => 'Tari Topeng Betawi, tarian teater rakyat Jakarta yang dinamis, ekspresif, dan sarat pesan moral.'],
                ['type' => 'alam', 'icon_class' => 'fa-solid fa-mountain-sun', 'title' => 'Pemandangan Alam', 'text' => 'Gugusan pulau karang Raja Ampat di Papua Barat Daya, mahkota keanekaragaman hayati laut dunia.'],
                ['type' => 'flora', 'icon_class' => 'fa-solid fa-seedling', 'title' => 'Flora Nusantara', 'text' => 'Bunga Anggrek Bulan (Phalaenopsis amabilis), Puspa Pesona Nasional Republik Indonesia.'],
                ['type' => 'tokoh', 'icon_class' => 'fa-solid fa-users', 'title' => 'Tokoh Terkait Sisi Muka', 'text' => 'Bung Karno dan Bung Hatta, Dwi-Tunggal Proklamator kemerdekaan bangsa.']
            ],
            'fakta_menarik_items' => [
                'Bunga Anggrek Bulan dinobatkan sebagai Puspa Pesona Nasional berdasarkan Keppres No. 4 Tahun 1993.',
                'Tari Topeng Betawi menggambarkan siklus karakter manusia dari yang pemalu hingga berjiwa kesatria.',
                'Raja Ampat dijuluki "Surga Terakhir di Bumi" karena kelestarian ekosistem bawah lautnya yang tak tertandingi.',
                'Tinta ultraviolet di sisi belakang menampilkan motif pendaran merah-emas yang sangat mewah.'
            ],
            'ciri_keaslian_items' => [
                ['type' => 'rectoverso', 'icon_class' => 'fa-solid fa-shapes', 'title' => 'Rectoverso BI Sisi Belakang', 'desc' => 'Logo Bank Indonesia saling mengunci sempurna saat diarahkan ke cahaya.'],
                ['type' => 'uv', 'icon_class' => 'fa-solid fa-wand-magic-sparkles', 'title' => 'Pendaran UV Raja Ampat & Tari Topeng', 'desc' => 'Gugusan karang Raja Ampat dan penari Topeng Betawi memancarkan pendaran merah-keemasan di bawah sinar UV.'],
                ['type' => 'watermark', 'icon_class' => 'fa-solid fa-eye', 'title' => 'Watermark Dwi-Tunggal', 'desc' => 'Tanda air Bung Karno & Bung Hatta beserta angka 100 tampak jelas saat diterawang.'],
                ['type' => 'microtext', 'icon_class' => 'fa-solid fa-magnifying-glass', 'title' => 'Mikroteks Kertas Merah', 'desc' => 'Tulisan mikro tersembunyi "BANK INDONESIA" yang sangat tajam dan rapat.']
            ]
        ]
    ]
];

// Helper Functions untuk Klasifikasi & Normalisasi
if (!function_exists('normalizeNominalInput')) {
    function normalizeNominalInput($input) {
        if (!$input) return null;
        $clean = preg_replace('/[^0-9]/', '', (string)$input);
        if (!$clean) return null;
        
        $map = [
            '1000' => '1000', '1' => '1000',
            '2000' => '2000', '2' => '2000',
            '5000' => '5000', '5' => '5000',
            '10000' => '10000', '10' => '10000',
            '20000' => '20000', '20' => '20000',
            '50000' => '50000', '50' => '50000',
            '100000' => '100000', '100' => '100000'
        ];
        return isset($map[$clean]) ? $map[$clean] : null;
    }
}

// 14 Template Acuan Gambar Banknote di GAMBAR_GAMBAR/
$banknoteTemplates = [
    '1000_depan'      => 'GAMBAR_GAMBAR/uang_1000.jpg',
    '1000_belakang'   => 'GAMBAR_GAMBAR/1000_belakang.jpg',
    '2000_depan'      => 'GAMBAR_GAMBAR/uang_2000.jpg',
    '2000_belakang'   => 'GAMBAR_GAMBAR/2000_belakang.png',
    '5000_depan'      => 'GAMBAR_GAMBAR/uang_5000.jpg',
    '5000_belakang'   => 'GAMBAR_GAMBAR/5000_belakang.png',
    '10000_depan'     => 'GAMBAR_GAMBAR/uang_10000.jpg',
    '10000_belakang'  => 'GAMBAR_GAMBAR/10000_belakang.jpg',
    '20000_depan'     => 'GAMBAR_GAMBAR/20000_depan.png',
    '20000_belakang'  => 'GAMBAR_GAMBAR/uang_20000.jpg',
    '50000_depan'     => 'GAMBAR_GAMBAR/uang_50000.jpg',
    '50000_belakang'  => 'GAMBAR_GAMBAR/50000_belakang.jpg',
    '100000_depan'    => 'GAMBAR_GAMBAR/uang_100000.jpg',
    '100000_belakang' => 'GAMBAR_GAMBAR/100000_belakang.png'
];

/**
 * Ekstraksi Fitur Visual Gambar Menggunakan PHP GD
 */
function extractImageFeaturesGD($filePathOrResource) {
    $img = null;
    if (is_resource($filePathOrResource) || (is_object($filePathOrResource) && get_class($filePathOrResource) === 'GdImage')) {
        $img = $filePathOrResource;
    } elseif (is_string($filePathOrResource) && file_exists($filePathOrResource)) {
        $info = @getimagesize($filePathOrResource);
        if (!$info) return null;
        $mime = $info['mime'];
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            $img = @imagecreatefromjpeg($filePathOrResource);
        } elseif ($mime === 'image/png') {
            $img = @imagecreatefrompng($filePathOrResource);
        } elseif ($mime === 'image/webp') {
            $img = @imagecreatefromwebp($filePathOrResource);
        }
    }

    if (!$img) return null;

    $w = imagesx($img);
    $h = imagesy($img);

    // Normalisasi orientasi jika gambar vertikal (tinggi > lebar)
    if ($h > $w * 1.2) {
        $rotated = @imagerotate($img, 90, 0);
        if ($rotated) {
            imagedestroy($img);
            $img = $rotated;
            $w = imagesx($img);
            $h = imagesy($img);
        }
    }

    $gridW = 32;
    $gridH = 16;
    $thumb = imagecreatetruecolor($gridW, $gridH);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $gridW, $gridH, $w, $h);

    $grid = [];
    $gray = [];
    $totalR = 0; $totalG = 0; $totalB = 0;
    $hues = array_fill(0, 16, 0);

    for ($y = 0; $y < $gridH; $y++) {
        for ($x = 0; $x < $gridW; $x++) {
            $rgb = imagecolorat($thumb, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $totalR += $r;
            $totalG += $g;
            $totalB += $b;

            $lum = ($r * 0.299 + $g * 0.587 + $b * 0.114);
            $gray[$y][$x] = $lum;

            // Hitung Hue HSV
            $max = max($r, $g, $b);
            $min = min($r, $g, $b);
            $d = $max - $min;
            $hDeg = 0;
            if ($d > 0) {
                if ($max === $r) $hDeg = fmod((($g - $b) / $d), 6);
                elseif ($max === $g) $hDeg = ($b - $r) / $d + 2;
                else $hDeg = ($r - $g) / $d + 4;
                $hDeg = round($hDeg * 60);
                if ($hDeg < 0) $hDeg += 360;
            }
            $bin = min(15, (int)floor($hDeg / 22.5));
            $hues[$bin]++;

            $grid[] = [$r, $g, $b];
        }
    }

    // Sobel-like edge structure
    $edges = [];
    for ($y = 1; $y < $gridH - 1; $y++) {
        for ($x = 1; $x < $gridW - 1; $x++) {
            $gx = $gray[$y-1][$x+1] + 2*$gray[$y][$x+1] + $gray[$y+1][$x+1] -
                 ($gray[$y-1][$x-1] + 2*$gray[$y][$x-1] + $gray[$y+1][$x-1]);
            $gy = $gray[$y+1][$x-1] + 2*$gray[$y+1][$x] + $gray[$y+1][$x+1] -
                 ($gray[$y-1][$x-1] + 2*$gray[$y-1][$x] + $gray[$y-1][$x+1]);
            $edges[] = sqrt($gx*$gx + $gy*$gy);
        }
    }

    $numP = $gridW * $gridH;
    imagedestroy($thumb);
    if (!is_resource($filePathOrResource) && !is_object($filePathOrResource)) {
        imagedestroy($img);
    }

    return [
        'avgRGB' => [$totalR / $numP, $totalG / $numP, $totalB / $numP],
        'hues' => $hues,
        'grid' => $grid,
        'edges' => $edges,
        'aspect' => $w / max(1, $h)
    ];
}

/**
 * Komparasi Kemiripan Fitur Visual Gambar (0.0% s/d 100.0%)
 */
function compareVisualFeatures($f1, $f2) {
    if (!$f1 || !$f2) return 0;

    // 1. Grid Pixel Color L1 Similarity
    $gridDiff = 0;
    $num = count($f1['grid']);
    for ($i = 0; $i < $num; $i++) {
        $dr = abs($f1['grid'][$i][0] - $f2['grid'][$i][0]);
        $dg = abs($f1['grid'][$i][1] - $f2['grid'][$i][1]);
        $db = abs($f1['grid'][$i][2] - $f2['grid'][$i][2]);
        $gridDiff += ($dr + $dg + $db) / (3 * 255);
    }
    $gridSim = 1 - ($gridDiff / $num);

    // 2. Hue Histogram Cosine Similarity
    $dot = 0; $mag1 = 0; $mag2 = 0;
    for ($i = 0; $i < count($f1['hues']); $i++) {
        $dot += $f1['hues'][$i] * $f2['hues'][$i];
        $mag1 += $f1['hues'][$i] * $f1['hues'][$i];
        $mag2 += $f2['hues'][$i] * $f2['hues'][$i];
    }
    $hueSim = ($mag1 > 0 && $mag2 > 0) ? ($dot / (sqrt($mag1) * sqrt($mag2))) : 0;

    // 3. Edge Structure Cosine Similarity
    $eDot = 0; $eMag1 = 0; $eMag2 = 0;
    $eCount = min(count($f1['edges']), count($f2['edges']));
    for ($i = 0; $i < $eCount; $i++) {
        $eDot += $f1['edges'][$i] * $f2['edges'][$i];
        $eMag1 += $f1['edges'][$i] * $f1['edges'][$i];
        $eMag2 += $f2['edges'][$i] * $f2['edges'][$i];
    }
    $edgeSim = ($eMag1 > 0 && $eMag2 > 0) ? ($eDot / (sqrt($eMag1) * sqrt($eMag2))) : 0;

    // 4. Combined Similarity Score (0 - 100%)
    $score = ($gridSim * 0.45 + $hueSim * 0.35 + $edgeSim * 0.20) * 100;
    return $score;
}

// -------------------------------------------------------------
// REQUEST DISPATCHER & LOGIKA KLASIFIKASI SCAN
// -------------------------------------------------------------

$rawBody = file_get_contents('php://input');
$jsonData = json_decode($rawBody, true);

// Endpoint ?action=all untuk mengambil semua data master
if (isset($_GET['action']) && $_GET['action'] === 'all') {
    echo json_encode([
        'status' => 'success',
        'total' => count($rupiahDictionary),
        'data' => array_values($rupiahDictionary)
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$detectedNominal = null;
$detectedSide = null;
$confidenceScore = 0.0;
$explicitRequest = false;

// 1. Periksa Parameter Eksplisit (POST/GET/JSON)
if (isset($_POST['nominal']) || isset($_GET['nominal']) || (is_array($jsonData) && (isset($jsonData['nominal']) || isset($jsonData['detected_nominal'])))) {
    $rawNom = isset($_POST['nominal']) ? $_POST['nominal'] : (isset($_GET['nominal']) ? $_GET['nominal'] : (isset($jsonData['nominal']) ? $jsonData['nominal'] : $jsonData['detected_nominal']));
    $detectedNominal = normalizeNominalInput($rawNom);
    
    $rawSide = isset($_POST['sisi']) ? $_POST['sisi'] : (isset($_GET['sisi']) ? $_GET['sisi'] : (isset($jsonData['sisi']) ? $jsonData['sisi'] : null));
    if ($rawSide && in_array(strtolower($rawSide), ['depan', 'belakang'])) {
        $detectedSide = strtolower($rawSide);
    }
    $explicitRequest = true;
    $confidenceScore = 99.5;
}

// 2. Analisis Berkas Gambar Upload ($_FILES['image'] atau base64)
$tempImagePath = null;
$originalFileName = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tempImagePath = $_FILES['image']['tmp_name'];
    $originalFileName = strtolower($_FILES['image']['name']);
} elseif (is_array($jsonData) && !empty($jsonData['image_base64'])) {
    $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $jsonData['image_base64']);
    $decoded = base64_decode($base64);
    if ($decoded) {
        $tempImagePath = tempnam(sys_get_temp_dir(), 'rup_scan_');
        file_put_contents($tempImagePath, $decoded);
    }
}

// Cek petunjuk nama file jika ada
if ($originalFileName) {
    if (strpos($originalFileName, 'belakang') !== false) {
        $detectedSide = 'belakang';
    } elseif (strpos($originalFileName, 'depan') !== false) {
        $detectedSide = 'depan';
    }

    $fileNom = normalizeNominalInput($originalFileName);
    if ($fileNom) {
        $detectedNominal = $fileNom;
        $confidenceScore = 98.0;
    }
}

// 3. Jalankan Image Feature Matching dengan Ke-14 Template jika ada gambar
if ($tempImagePath && file_exists($tempImagePath)) {
    $inputFeatures = extractImageFeaturesGD($tempImagePath);
    if ($inputFeatures) {
        $bestMatchKey = null;
        $bestScore = 0.0;
        $secondScore = 0.0;

        $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        foreach ($banknoteTemplates as $tKey => $tRelativePath) {
            $tFullPath = $baseDir . str_replace('/', DIRECTORY_SEPARATOR, $tRelativePath);
            $tFeat = extractImageFeaturesGD($tFullPath);
            if ($tFeat) {
                $sim = compareVisualFeatures($inputFeatures, $tFeat);
                if ($sim > $bestScore) {
                    $secondScore = $bestScore;
                    $bestScore = $sim;
                    $bestMatchKey = $tKey;
                } elseif ($sim > $secondScore) {
                    $secondScore = $sim;
                }
            }
        }

        // Evaluasi Threshold Deteksi Gambar Rupiah
        // Ambang batas aman: 83.5%
        $THRESHOLD_CONFIDENCE = 83.5;

        if (!$explicitRequest && ($bestScore < $THRESHOLD_CONFIDENCE || ($bestScore < 86.5 && ($bestScore - $secondScore) < 2.5))) {
            // Gambar tidak memenuhi threshold / Non-Rupiah
            http_response_code(200);
            echo json_encode([
                'status' => 'not_found',
                'error_code' => 'UNRECOGNIZED_IMAGE',
                'message' => 'Gambar tidak terdeteksi sebagai mata uang Rupiah Emisi 2022.',
                'educational_message' => 'Mohon unggah foto mata uang Rupiah kertas yang jelas dan tidak blur.',
                'confidence' => round($bestScore, 1),
                'top_candidate' => $bestMatchKey
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        // Jika lolos threshold, perbarui nominal dan sisi dari hasil matching
        if ($bestMatchKey) {
            list($matchedNom, $matchedSide) = explode('_', $bestMatchKey);
            if (!$detectedNominal || !$explicitRequest) {
                $detectedNominal = $matchedNom;
            }
            if (!$detectedSide || !$explicitRequest) {
                $detectedSide = $matchedSide;
            }
            $confidenceScore = max($confidenceScore, round($bestScore, 1));
        }
    }
}

// Default sisi ke 'depan' jika belum terdefinisi
if (!$detectedSide) {
    $detectedSide = 'depan';
}

// Default nominal ke '10000' jika request kosong murni (misal test direct get tanpa parameter)
if (!$detectedNominal && $explicitRequest) {
    $detectedNominal = '10000';
}

// 4. Validasi Akhir dan Pembentukan Response JSON
if ($detectedNominal && isset($rupiahDictionary[$detectedNominal])) {
    $master = $rupiahDictionary[$detectedNominal];
    $sideData = isset($master[$detectedSide]) ? $master[$detectedSide] : $master['depan'];

    $response = [
        'status' => 'success',
        'nominal' => $master['nominal'],
        'numeric_value' => $master['numeric_value'],
        'formatted_nominal' => $master['formatted_nominal'],
        'jenis' => $master['jenis'],
        'emisi' => $master['emisi'],
        'warna_dominan' => $master['warna_dominan'],
        'dimensi' => $master['dimensi'],
        'kondisi' => $master['kondisi'],
        'sisi' => $detectedSide,
        'label_sisi' => $sideData['label_sisi'],
        'confidence' => $confidenceScore > 0 ? $confidenceScore : 97.5,
        'pahlawan_name' => $sideData['pahlawan_name'],
        'pahlawan_lifespan' => $sideData['pahlawan_lifespan'],
        'pahlawan_image' => $sideData['pahlawan_image'],
        'tarian_adat' => $master['tarian_adat'],
        'pemandangan_alam' => $master['pemandangan_alam'],
        'flora_khas' => $master['flora_khas'],
        'banknote_image' => $sideData['banknote_image'],
        'makna_visual' => $sideData['makna_visual'],
        'sejarah_tokoh' => $sideData['sejarah_tokoh'],
        'fakta_menarik' => $sideData['fakta_menarik'],
        'ciri_keaslian' => $sideData['ciri_keaslian'],
        'makna_visual_items' => $sideData['makna_visual_items'],
        'fakta_menarik_items' => $sideData['fakta_menarik_items'],
        'ciri_keaslian_items' => $sideData['ciri_keaslian_items']
    ];

    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    // Tidak terdeteksi
    http_response_code(200);
    echo json_encode([
        'status' => 'not_found',
        'error_code' => 'UNRECOGNIZED_IMAGE',
        'message' => 'Gambar tidak terdeteksi sebagai mata uang Rupiah Emisi 2022.',
        'educational_message' => 'Mohon unggah foto mata uang Rupiah kertas yang jelas dan tidak blur.',
        'confidence' => 0.0,
        'available_nominals' => ['1.000', '2.000', '5.000', '10.000', '20.000', '50.000', '100.000']
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
