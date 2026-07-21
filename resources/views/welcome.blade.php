{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraSense — Platform Asesmen Literasi AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green-dark: #0d2b1f;
            --green-700: #1a5c40;
            --green-600: #2a8f6d;
            --green-100: #d4f0e4;
            --green-50: #edf9f4;
            --white: #ffffff;
            --gray-50: #f8faf9;
            --gray-100: #f0f4f2;
            --gray-200: #dce5e0;
            --gray-400: #8fa89d;
            --gray-600: #4a6358;
            --gray-800: #243b30;
            --amber: #f59e0b;
            --red: #ef4444;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--white);
            color: var(--gray-800);
            line-height: 1.6;
        }

        /* ─── NAVIGATION ─────────────────────────── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 40px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-mark {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-700) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 18px;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 700;
            color: var(--green-dark);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-ghost {
            padding: 8px 18px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 5px;
            border: 1px solid var(--gray-200);
            background: none;
            color: var(--gray-600);
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: var(--gray-50);
            color: var(--gray-800);
            border-color: var(--gray-400);
        }

        .btn-solid {
            padding: 9px 22px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 5px;
            border: none;
            background: var(--green-dark);
            color: var(--white);
            text-decoration: none;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-solid:hover {
            background: #0a1f17;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 43, 31, .15);
        }

        /* ─── HERO SECTION ─────────────────────────── */
        .hero {
            padding: 170px 40px;
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-700) 100%);
            color: var(--white);
            text-align: center;
        }

        .hero-inner {
            max-width: 900px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .hero-badge i {
            color: var(--green-100);
        }

        .hero-title {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--white);
        }

        .hero-title em {
            color: var(--green-100);
            font-style: italic;
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 13px 32px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            background: var(--green-100);
            color: var(--green-dark);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .15);
        }

        .btn-secondary {
            padding: 13px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, .3);
            background: transparent;
            color: var(--white);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .5);
        }

        /* ─── FEATURES OVERVIEW ─────────────────────────── */
        .overview {
            padding: 60px 40px;
            background: var(--gray-50);
        }

        .overview-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 12px;
        }

        .section-title em {
            color: var(--green-700);
            font-style: italic;
        }

        .section-subtitle {
            font-size: 16px;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            transition: all .2s;
        }

        .feature-card:hover {
            border-color: var(--green-600);
            box-shadow: 0 8px 20px rgba(26, 92, 64, .08);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: var(--green-50);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--green-700);
            margin: 0 auto 14px;
        }

        .feature-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 12px;
            color: var(--gray-600);
            line-height: 1.6;
        }

        /* ─── EXAMPLE RESULTS ─────────────────────────── */
        .example-section {
            padding: 60px 40px;
            background: var(--white);
        }

        .example-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .example-content h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 16px;
        }

        .example-content em {
            color: var(--green-700);
            font-style: italic;
        }

        .example-content p {
            font-size: 15px;
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .result-card {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-700) 100%);
            border-radius: 12px;
            padding: 30px;
            color: var(--white);
            margin-bottom: 20px;
        }

        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .result-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: rgba(255, 255, 255, .6);
        }

        .overall-score {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .overall-value {
            font-size: 48px;
            font-weight: 700;
            color: var(--green-100);
        }

        .overall-label {
            font-size: 12px;
            color: rgba(255, 255, 255, .6);
        }

        .dimension-bars {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .dimension-bar {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 8px;
            padding: 14px;
        }

        .dim-name {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 8px;
        }

        .dim-score {
            font-size: 20px;
            font-weight: 700;
            color: var(--green-100);
            margin-bottom: 8px;
        }

        .dim-track {
            height: 4px;
            background: rgba(255, 255, 255, .1);
            border-radius: 2px;
            overflow: hidden;
        }

        .dim-fill {
            height: 100%;
            background: var(--green-100);
            border-radius: 2px;
        }

        .dim-status {
            font-size: 10px;
            color: rgba(255, 255, 255, .4);
            margin-top: 6px;
        }

        /* ─── RESEARCH INFO ─────────────────────────── */
        .research-section {
            padding: 60px 40px;
            background: var(--gray-50);
        }

        .research-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .research-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        .research-box {
            background: var(--white);
            border-left: 4px solid var(--green-700);
            border-radius: 8px;
            padding: 24px;
        }

        .research-box h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 12px;
        }

        .research-box p {
            font-size: 13px;
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 10px;
        }

        .research-box ul {
            list-style: none;
            font-size: 13px;
            color: var(--gray-600);
            line-height: 1.8;
            margin-left: 0;
        }

        .research-box li:before {
            content: "✓ ";
            color: var(--green-700);
            font-weight: 700;
            margin-right: 8px;
        }
        

        /* ─── PRIVACY DISCLAIMER ─────────────────────────── */
        .privacy-section {
            padding: 60px 40px;
            background: #fff9e6;
            border: 1px solid var(--amber);
            border-left: 4px solid var(--amber);
        }

        .privacy-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .privacy-icon {
            font-size: 48px;
            color: var(--amber);
        }

        .privacy-content h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 12px;
        }

        .privacy-content p {
            font-size: 13px;
            color: var(--gray-700);
            line-height: 1.8;
            margin-bottom: 12px;
        }

        .privacy-list {
            list-style: none;
            font-size: 13px;
            color: var(--gray-700);
            line-height: 1.8;
        }

        .privacy-list li:before {
            content: "• ";
            color: var(--amber);
            font-weight: 700;
            margin-right: 8px;
        }

        /* ─── REFERENCES ─────────────────────────── */
        .references-section {
            padding: 60px 40px;
            background: var(--white);
        }

        .references-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .reference-box {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 24px;
        }

        .reference-box h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reference-box ul {
            list-style: none;
            font-size: 12px;
            color: var(--gray-600);
            line-height: 1.8;
        }

        .reference-box li {
            margin-bottom: 8px;
            padding-left: 0;
        }

        .reference-box li:before {
            content: "→ ";
            color: var(--green-700);
            font-weight: 700;
            margin-right: 6px;
        }

        .reference-box a {
            color: var(--green-700);
            text-decoration: none;
        }

        /* ─── FOOTER ─────────────────────────── */
        footer {
            background: var(--green-dark);
            color: var(--white);
            padding: 40px;
            text-align: center;
            font-size: 13px;
            line-height: 1.8;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 30px;
            text-align: left;
        }

        .footer-col h5 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 12px;
        }

        .footer-col p {
            color: rgba(255, 255, 255, .6);
            line-height: 1.7;
        }

        .footer-divider {
            border-top: 1px solid rgba(255, 255, 255, .1);
            padding-top: 20px;
            color: rgba(255, 255, 255, .4);
        }

        /* ─── RESPONSIVE ─────────────────────────── */
        @media (max-width: 991px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .example-inner,
            .research-grid,
            .privacy-inner,
            .references-grid,
            .footer-content {
                grid-template-columns: 1fr;
            }

            .hero-title {
                font-size: 36px;
            }

            .section-title {
                font-size: 24px;
            }
        }

        @media (max-width: 640px) {
            .nav {
                padding: 0 16px;
                height: 60px;
            }

            .nav-actions {
                gap: 8px;
            }

            .btn-ghost,
            .btn-solid {
                padding: 8px 14px;
                font-size: 12px;
            }

            .hero {
                padding: 40px 20px;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-desc {
                font-size: 14px;
            }

            .overview,
            .example-section,
            .research-section,
            .privacy-section,
            .references-section {
                padding: 40px 20px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .feature-card {
                padding: 20px;
            }

            .section-title {
                font-size: 20px;
            }

            .dimension-bars {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="nav">
        <a href="/" class="nav-logo">
            <div class="logo-mark">L</div>
            <span class="logo-text">LiteraSense</span>
        </a>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-solid">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="btn-solid">
                    Daftar <i class="bi bi-arrow-right"></i>
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-inner">
            <h1 class="hero-title">
                Ukur & Pahami<br>
                <em>Literasi AI</em> Anda
            </h1>
            <p class="hero-desc">
                LiteraSense adalah platform asesmen literasi kecerdasan buatan berbasis instrumen ilmiah
                yang dirancang khusus untuk sivitas akademika Politeknik Negeri Jakarta.
                Dapatkan pengukuran terstruktur, analisis mendalam, dan rekomendasi pembelajaran yang dipersonalisasi.
            </p>
            <div class="hero-cta">
                @guest
                    <a href="{{ route('register') }}" class="btn-primary">
                        <i class="bi bi-play-fill"></i> Mulai Asesmen
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary">
                        Masuk Akun <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        <i class="bi bi-graph-up"></i> Ke Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="overview">
        <div class="overview-inner">
            <div class="section-header">
                <h2 class="section-title">
                    Fitur <em>Unggulan</em>
                </h2>
                <p class="section-subtitle">
                    Platform yang dirancang untuk mengukur literasi AI secara komprehensif dan terukur
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <h3 class="feature-title">Asesmen Terstruktur</h3>
                    <p class="feature-desc">40 pertanyaan Likert + 20 MCQ berbasis instrumen penelitian yang valid dan
                        reliabel</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h3 class="feature-title">Analitik Mendalam</h3>
                    <p class="feature-desc">Laporan detail dengan breakdown per dimensi, visualisasi, dan interpretasi
                        hasil</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-book-fill"></i></div>
                    <h3 class="feature-title">Rekomendasi Pembelajaran</h3>
                    <p class="feature-desc">Sistem otomatis merekomendasikan konten pembelajaran berdasarkan kebutuhan
                        Anda</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h3 class="feature-title">Aman & Terpercaya</h3>
                    <p class="feature-desc">Data tersimpan aman dengan enkripsi dan privacy policy yang jelas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Example Results -->
    <section class="example-section">
        <div class="example-inner">
            <div class="example-content">
                <h3>Contoh Hasil <em>Literasi AI</em></h3>
                <p>
                    Setelah menyelesaikan asesmen, Anda akan mendapatkan laporan komprehensif yang menampilkan:
                </p>
                <p>
                    <strong>• Overall Score:</strong> Skor total literasi AI Anda (0-100)<br>
                    <strong>• Skor Per Dimensi:</strong> Breakdown untuk 4 dimensi pembelajaran<br>
                    <strong>• Kategori Status:</strong> Rendah, Sedang, atau Tinggi<br>
                    <strong>• Visualisasi:</strong> Radar chart untuk perbandingan dimensi<br>
                    <strong>• Rekomendasi:</strong> Modul pembelajaran yang sesuai
                </p>
            </div>

            <div>
                <div class="result-card">
                    <div class="result-header">
                        <span class="result-title">📊 Sample AI Literacy Report</span>
                        <div class="overall-score">
                            <div class="overall-value">78%</div>
                            <div class="overall-label">Overall Score</div>
                        </div>
                    </div>

                    <div class="dimension-bars">
                        <div class="dimension-bar">
                            <div class="dim-name">Conceptual Understanding</div>
                            <div class="dim-score">82%</div>
                            <div class="dim-track">
                                <div class="dim-fill" style="width: 82%;"></div>
                            </div>
                            <div class="dim-status">✓ Tinggi</div>
                        </div>

                        <div class="dimension-bar">
                            <div class="dim-name">Application & Skills</div>
                            <div class="dim-score">75%</div>
                            <div class="dim-track">
                                <div class="dim-fill" style="width: 75%;"></div>
                            </div>
                            <div class="dim-status">✓ Tinggi</div>
                        </div>

                        <div class="dimension-bar">
                            <div class="dim-name">Critical Thinking</div>
                            <div class="dim-score">76%</div>
                            <div class="dim-track">
                                <div class="dim-fill" style="width: 76%;"></div>
                            </div>
                            <div class="dim-status">✓ Tinggi</div>
                        </div>

                        <div class="dimension-bar">
                            <div class="dim-name">Ethical Awareness</div>
                            <div class="dim-score">79%</div>
                            <div class="dim-track">
                                <div class="dim-fill" style="width: 79%;"></div>
                            </div>
                            <div class="dim-status">✓ Tinggi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Research Info -->
    <section class="research-section">
        <div class="research-inner">
            <div class="section-header" style="grid-column: 1/-1; margin-bottom: 40px;">
                <h2 class="section-title">
                    Tentang <em>Penelitian</em>
                </h2>
                <p class="section-subtitle">
                    Platform ini dikembangkan dalam konteks penelitian akademik
                </p>
            </div>

            <div class="research-grid">

                <div class="research-box">
                    <h4><i class="bi bi-person"></i> Peneliti 1</h4>
                    <p><strong>Dr., Ir. DEWI YANTI LILIANA, S.Kom., M.Kom</strong></p>
                    <p style="color: var(--gray-500);">Dosen Teknik Informatika</p>
                    <p>Politeknik Negeri Jakarta (PNJ)</p>
                </div>

                <div class="research-box">
                    <h4><i class="bi bi-person"></i> Peneliti 2</h4>
                    <p><strong>Muhammad Fauzan Permana</strong></p>
                    <p style="color: var(--gray-500);">Mahasiswa Teknik Informatika</p>
                    <p>Politeknik Negeri Jakarta (PNJ)</p>
                </div>

                <div class="research-box">
                    <h4><i class="bi bi-journal-bookmark"></i> Judul Penelitian</h4>
                    <p><strong>PENGEMBANGAN RESPONSIBLE AI DI POLITEKNIK NEGERI JAKARTA</strong></p>
                </div>

                <div class="research-box">
                    <h4><i class="bi bi-journal-bookmark"></i> Sub Judul</h4>
                    <p><strong>PENGEMBANGAN DASHBOARD AI LITERACY SCORE UNTUK MENINGKATKAN LITERASI ARTIFICIAL
                            INTELLIGENCE DI POLITEKNIK NEGERI JAKARTA</strong></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Disclaimer -->
    <section class="privacy-section">
        <div class="privacy-inner">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div class="privacy-icon"><i class="bi bi-exclamation-circle"></i></div>
            </div>

            <div class="privacy-content">
                <h3><i class="bi bi-shield-lock"></i> Pemberitahuan Privasi & Penggunaan Data</h3>

                <p>
                    <strong>Pengumpulan Data untuk Kepentingan Penelitian</strong>
                </p>

                <p>
                    Platform LiteraSense mengumpulkan data asesmen Anda <strong>HANYA untuk kepentingan penelitian
                        akademik</strong>
                    yang dilakukan sebagai bagian dari skripsi di Politeknik Negeri Jakarta.
                </p>

                <ul class="privacy-list">
                    <li><strong>Data yang Dikumpulkan:</strong> Respons asesmen, profil pengguna (nama, jurusan,
                        semester)</li>
                    <li><strong>Penggunaan Data:</strong> Analisis hasil penelitian, evaluasi instrumen, improvement
                        sistem</li>
                    <li><strong>Keamanan:</strong> Data disimpan secara aman dengan enkripsi end-to-end</li>
                    <li><strong>Transparansi:</strong> Tidak ada penjualan atau sharing data ke pihak ketiga</li>
                    <li><strong>Penghapusan:</strong> Data akan <strong>DIHAPUS SEPENUHNYA</strong> 6 bulan setelah
                        penelitian berakhir</li>
                    <li><strong>Hak Anda:</strong> Anda dapat meminta penghapusan data kapan saja dengan menghubungi
                        admin</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- References -->
    <section class="references-section">
        <div class="references-inner">
            <div class="section-header" style="grid-column: 1/-1; margin-bottom: 40px;">
                <h2 class="section-title">
                    Referensi <em>Instrumen & Soal</em>
                </h2>
            </div>

            <div class="reference-box">
                <h4><i class="bi bi-journal-bookmark"></i> Framework dan Soal Literasi AI</h4>
                <ul>
                    <a class="reference-link" target="_blank" href="https://www.researchgate.net/publication/339272039_What_is_AI_Literacy_Competencies_and_Design_Considerations">
                        <li>Long, D. and Magerko, B. (2020) 'What is AI Literacy? Competencies and Design Considerations', in Proceedings of the 2020 CHI Conference on Human Factors in Computing Systems. New York: Association for Computing Machinery, pp. 1-16.</li>
                    </a>
                    <a class="reference-link" target="_blank" href="https://researchportal.hkust.edu.hk/en/publications/conceptualizing-ai-literacy-an-exploratory-review">
                        <li>Ng, D. T. K., Leung, J. K. L., Chu, S. K. W. and Qiao, M. S. (2021) 'Conceptualizing AI literacy: An exploratory review', Computers and Education: Artificial Intelligence, 2, p. 100041. doi: 10.1016/j.caeai.2021.100041.</li>
                    </a>
                    <a class="reference-link" target="_blank" href="https://pedagogia.umsida.ac.id/index.php/pedagogia/article/view/2097">
                        <li>Prasetyoningrum, I. D., Fajar, M. and Ratnawati, D. P. (2026) 'Artificial Intelligence Usage and Determinants of Student Academic Achievement', Pedagogia: Jurnal Pendidikan, 15(1).</li>
                    </a>
                    <a class="reference-link" target="_blank" href="https://journal.uns.ac.id/index.php/isep/article/view/2757">
                        <li>Suwahyu, I., Waratman, A. A. and Pratama, A. A. (2024) 'Analisis Literasi AI Mahasiswa Pada Perguruan Tinggi', INTEC Journal: Information Technology Education Journal, 3(1).</li>
                    </a>
                </ul>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>

        <div class="footer-divider">
            <p>
                © {{ date('Y') }} LiteraSense - Politeknik Negeri Jakarta<br>
                Platform ini dikembangkan dalam konteks penelitian akademik dengan standar etika penelitian
                internasional.
            </p>
        </div>
    </footer>

</body>

</html>
