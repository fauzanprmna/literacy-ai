<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Literacy AI — Asesmen Literasi Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" crossorigin="anonymous"/>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-dark: #0d2b1f;
            --green-600: #1a5c40;
            --green-500: #2a9468;
            --green-100: #d4f0e4;
            --green-50: #edf9f4;
            --white: #ffffff;
            --gray-50: #f8faf9;
            --gray-100: #f0f4f2;
            --gray-200: #dce5e0;
            --gray-400: #8fa89d;
            --gray-600: #4a6358;
            --gray-800: #243b30;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--white);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
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
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
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
            background: var(--green-dark);
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

        .logo-text em {
            font-style: italic;
            color: var(--green-500);
            margin-left: 3px;
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
        }

        .btn-ghost:hover {
            background: var(--gray-50);
            color: var(--gray-800);
            border-color: var(--gray-300);
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
        }

        .btn-solid:hover {
            background: #0a1f17;
            text-decoration: none;
            color: var(--white);
        }

        /* ─── HERO ─────────────────────────── */
        .hero {
            padding: 80px 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            color: var(--gray-800);
            margin-bottom: 20px;
        }

        .hero-title em {
            color: var(--green-500);
            font-style: italic;
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.7;
            color: var(--gray-600);
            margin-bottom: 30px;
            max-width: 480px;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 12px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 5px;
            border: none;
            background: var(--green-dark);
            color: var(--white);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
        }

        .btn-primary:hover {
            background: #0a1f17;
            color: var(--white);
        }

        .btn-secondary {
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 5px;
            border: 1px solid var(--gray-200);
            background: var(--white);
            color: var(--gray-600);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
        }

        .btn-secondary:hover {
            border-color: var(--green-100);
            background: var(--green-50);
            color: var(--green-600);
        }

        /* ─── HERO VISUAL ─────────────────────────── */
        .hero-visual {
            background: var(--green-dark);
            border-radius: 8px;
            padding: 30px;
            color: var(--white);
        }

        .visual-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 24px;
        }

        .visual-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,.3);
        }

        .visual-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: rgba(255,255,255,.5);
            margin-left: auto;
        }

        .visual-scores {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .visual-score {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 6px;
            padding: 14px;
            text-align: center;
        }

        .visual-score-val {
            font-size: 24px;
            font-weight: 700;
            color: var(--green-100);
            line-height: 1;
            margin-bottom: 4px;
        }

        .visual-score-label {
            font-size: 11px;
            color: rgba(255,255,255,.4);
        }

        .visual-bars {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .visual-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .visual-bar-name {
            font-size: 12px;
            color: rgba(255,255,255,.6);
            width: 100px;
            flex-shrink: 0;
        }

        .visual-bar-track {
            flex: 1;
            height: 6px;
            background: rgba(255,255,255,.1);
            border-radius: 3px;
            overflow: hidden;
        }

        .visual-bar-fill {
            height: 100%;
            background: var(--green-100);
            border-radius: 3px;
        }

        .visual-bar-pct {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,.5);
            width: 35px;
            text-align: right;
        }

        /* ─── HOW IT WORKS ─────────────────────────── */
        .how-section {
            padding: 60px 40px;
            max-width: 1200px;
            margin: 0 auto;
            border-top: 1px solid var(--gray-200);
        }

        .how-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .how-step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .step-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--green-dark);
            color: var(--white);
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 6px;
        }

        .step-desc {
            font-size: 13px;
            color: var(--gray-600);
            line-height: 1.6;
        }

        /* ─── FEATURES ─────────────────────────── */
        .features {
            background: var(--green-dark);
            color: var(--white);
            padding: 60px 40px;
        }

        .features-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            color: var(--white);
        }

        .section-title em {
            font-style: italic;
            color: var(--green-100);
        }

        .section-desc {
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255,255,255,.6);
            max-width: 500px;
            margin-bottom: 40px;
        }

        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .feat-card {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 6px;
            padding: 24px;
            transition: all .2s;
        }

        .feat-card:hover {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.15);
        }

        .feat-card.wide {
            grid-column: span 2;
        }

        .feat-icon {
            width: 42px;
            height: 42px;
            border-radius: 6px;
            background: rgba(255,255,255,.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--green-100);
            margin-bottom: 14px;
        }

        .feat-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 8px;
        }

        .feat-desc {
            font-size: 13px;
            color: rgba(255,255,255,.6);
            line-height: 1.6;
        }

        /* ─── WHY SECTION ─────────────────────────── */
        .why {
            padding: 60px 40px;
            background: var(--white);
        }

        .why-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .section-title-light {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            color: var(--gray-800);
            margin-bottom: 16px;
        }

        .section-title-light em {
            color: var(--green-500);
            font-style: italic;
        }

        .why-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .why-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 12px;
            border-radius: 6px;
            transition: all .2s;
        }

        .why-item:hover {
            background: var(--gray-50);
        }

        .why-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: var(--green-50);
            color: var(--green-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .why-item-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 3px;
        }

        .why-item-desc {
            font-size: 13px;
            color: var(--gray-600);
            line-height: 1.5;
        }

        /* ─── CTA ─────────────────────────── */
        .cta {
            padding: 60px 40px;
            background: var(--white);
        }

        .cta-inner {
            max-width: 760px;
            margin: 0 auto;
            text-align: center;
        }

        .cta-box {
            background: var(--green-dark);
            border-radius: 8px;
            padding: 50px 40px;
            color: var(--white);
        }

        .cta-title {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.2;
            color: var(--white);
            margin-bottom: 12px;
        }

        .cta-title em {
            font-style: italic;
            color: var(--green-100);
        }

        .cta-desc {
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255,255,255,.6);
            margin-bottom: 30px;
        }

        .cta-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-cta-primary {
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 5px;
            border: none;
            background: var(--green-100);
            color: var(--green-dark);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
        }

        .btn-cta-primary:hover {
            background: #fff;
        }

        .btn-cta-ghost {
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 5px;
            border: 1px solid rgba(255,255,255,.2);
            background: transparent;
            color: var(--white);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
        }

        .btn-cta-ghost:hover {
            background: rgba(255,255,255,.1);
            border-color: rgba(255,255,255,.3);
        }

        /* ─── FOOTER ─────────────────────────── */
        footer {
            background: var(--green-dark);
            color: var(--white);
            padding: 50px 40px 20px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr repeat(3, 1fr);
            gap: 40px;
            margin-bottom: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .footer-brand { max-width: 280px; }

        .footer-brand-text {
            font-size: 13px;
            line-height: 1.6;
            color: rgba(255,255,255,.5);
        }

        .footer-col h4 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: rgba(255,255,255,.5);
            margin-bottom: 16px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-col a {
            font-size: 13px;
            color: rgba(255,255,255,.5);
            text-decoration: none;
            transition: color .2s;
        }

        .footer-col a:hover {
            color: var(--green-100);
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
            color: rgba(255,255,255,.3);
        }

        /* ─── RESPONSIVE ─────────────────────────── */
        @media (max-width: 991px) {
            .nav { padding: 0 24px; }
            .hero, .how-section, .why-inner, .cta-box { grid-template-columns: 1fr; gap: 40px; }
            .hero-visual { display: none; }
            .feat-grid { grid-template-columns: repeat(2, 1fr); }
            .feat-card.wide { grid-column: span 1; }
            .how-grid { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .nav { padding: 0 16px; height: 60px; }
            .nav-actions .btn-ghost { display: none; }
            .hero, .how-section, .cta { padding: 40px 20px; }
            .hero-title { font-size: 28px; }
            .how-grid, .feat-grid { grid-template-columns: 1fr; }
            .section-title { font-size: 24px; }
            .footer-top { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="nav">
        <a href="/" class="nav-logo">
            <div class="logo-mark">L</div>
            <span class="logo-text">Literacy<em>AI</em></span>
        </a>
        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-solid">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="btn-solid">
                    Daftar Gratis <i class="bi bi-arrow-right"></i>
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1 class="hero-title">
                Ukur, Pahami &<br>
                Tingkatkan <em>Literasi AI</em><br>
                Anda
            </h1>
            <p class="hero-desc">
                Literacy AI membantu mahasiswa dan tenaga pendidik mengukur kemampuan literasi kecerdasan buatan secara terstruktur — dengan asesmen ilmiah, modul pembelajaran adaptif, dan analisis hasil yang mendalam.
            </p>
            <div class="hero-cta">
                @guest
                    <a href="{{ route('register') }}" class="btn-primary">
                        Mulai Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary">
                        Sudah punya akun? <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        Ke Dashboard <i class="bi bi-arrow-right"></i>
                    </a>
                @endguest
            </div>
        </div>

        <div class="hero-visual">
            <div class="visual-header">
                <span class="visual-dot"></span>
                <span class="visual-dot"></span>
                <span class="visual-dot"></span>
                <span class="visual-label">Hasil Literasi AI</span>
            </div>

            <div class="visual-scores">
                <div class="visual-score">
                    <div class="visual-score-val">78%</div>
                    <div class="visual-score-label">Skor Total</div>
                </div>
                <div class="visual-score">
                    <div class="visual-score-val">Good</div>
                    <div class="visual-score-label">Predikat</div>
                </div>
                <div class="visual-score">
                    <div class="visual-score-val">4/6</div>
                    <div class="visual-score-label">Kategori Lulus</div>
                </div>
            </div>

            <div class="visual-bars">
                <div class="visual-bar">
                    <span class="visual-bar-name">AI Fundamentals</span>
                    <div class="visual-bar-track"><div class="visual-bar-fill" style="width:88%;"></div></div>
                    <span class="visual-bar-pct">88%</span>
                </div>
                <div class="visual-bar">
                    <span class="visual-bar-name">AI Ethics</span>
                    <div class="visual-bar-track"><div class="visual-bar-fill" style="width:42%;"></div></div>
                    <span class="visual-bar-pct">42%</span>
                </div>
                <div class="visual-bar">
                    <span class="visual-bar-name">Data Literacy</span>
                    <div class="visual-bar-track"><div class="visual-bar-fill" style="width:75%;"></div></div>
                    <span class="visual-bar-pct">75%</span>
                </div>
                <div class="visual-bar">
                    <span class="visual-bar-name">Prompt Eng.</span>
                    <div class="visual-bar-track"><div class="visual-bar-fill" style="width:91%;"></div></div>
                    <span class="visual-bar-pct">91%</span>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-section">
        <div class="how-grid">
            <div class="how-step">
                <div class="step-num">1</div>
                <div>
                    <p class="step-title">Ikuti Asesmen</p>
                    <p class="step-desc">Jawab pertanyaan Likert dan pilihan ganda yang dirancang untuk mengukur literasi AI secara komprehensif.</p>
                </div>
            </div>
            <div class="how-step">
                <div class="step-num">2</div>
                <div>
                    <p class="step-title">Lihat Hasil Analitik</p>
                    <p class="step-desc">Dapatkan laporan mendalam per kategori dengan predikat, skor, dan grafik radar literasi Anda.</p>
                </div>
            </div>
            <div class="how-step">
                <div class="step-num">3</div>
                <div>
                    <p class="step-title">Pelajari Modulnya</p>
                    <p class="step-desc">Sistem merekomendasikan modul pembelajaran tepat sasaran berdasarkan kategori yang perlu ditingkatkan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <div class="features-inner">
            <h2 class="section-title">
                Semua yang Dibutuhkan untuk<br>
                <em>Mengukur & Berkembang</em>
            </h2>
            <p class="section-desc">Dirancang khusus untuk lingkungan akademik — dari mahasiswa hingga dosen pengelola.</p>

            <div class="feat-grid">
                <div class="feat-card">
                    <div class="feat-icon"><i class="bi bi-patch-check-fill"></i></div>
                    <h3 class="feat-title">Asesmen Terstruktur</h3>
                    <p class="feat-desc">Kuesioner dua tahap: Likert scale dan pilihan ganda. Dirancang mengikuti instrumen pengukuran literasi digital yang valid.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h3 class="feat-title">Analitik Hasil Mendalam</h3>
                    <p class="feat-desc">Laporan lengkap dengan radar chart, skor per kategori, predikat, dan riwayat pengukuran historis.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon"><i class="bi bi-book-half"></i></div>
                    <h3 class="feat-title">Modul Pembelajaran</h3>
                    <p class="feat-desc">Sistem merekomendasikan modul berdasarkan skor kategori untuk pembelajaran yang lebih terarah.</p>
                </div>
                <div class="feat-card wide">
                    <div class="feat-icon"><i class="bi bi-person-video3"></i></div>
                    <h3 class="feat-title">Panel Manajemen untuk Dosen</h3>
                    <p class="feat-desc">Kelola bank soal, template jawaban, dan modul pembelajaran dengan mudah. Buat pertanyaan, atur bobot, dan monitor progres mahasiswa dalam satu platform.</p>
                </div>
                <div class="feat-card">
                    <div class="feat-icon"><i class="bi bi-translate"></i></div>
                    <h3 class="feat-title">Bilingual Lengkap</h3>
                    <p class="feat-desc">Antarmuka tersedia dalam Bahasa Indonesia dan English. Ganti bahasa kapan saja dari pengaturan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Section -->
    <section class="why">
        <div class="why-inner">
            <div>
                <h2 class="section-title-light">
                    Lebih dari Sekadar<br><em>Kuis Biasa</em>
                </h2>
                <p class="section-desc">Platform ini dibangun di atas kerangka ilmiah pengukuran literasi digital, bukan sekadar tes pengetahuan umum.</p>

                <div class="why-list">
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-clipboard2-data-fill"></i></div>
                        <div>
                            <p class="why-item-title">Instrumen Pengukuran Valid</p>
                            <p class="why-item-desc">Soal dan rubrik penilaian mengacu pada framework literasi AI yang terstruktur.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-arrow-repeat"></i></div>
                        <div>
                            <p class="why-item-title">Asesmen Berulang</p>
                            <p class="why-item-desc">Lakukan asesmen berkali-kali untuk memantau perkembangan literasi AI Anda dari waktu ke waktu.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-mortarboard-fill"></i></div>
                        <div>
                            <p class="why-item-title">Dirancang untuk Akademik</p>
                            <p class="why-item-desc">Cocok untuk perguruan tinggi, penelitian, maupun pelatihan literasi digital formal.</p>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-icon"><i class="bi bi-shield-check-fill"></i></div>
                        <div>
                            <p class="why-item-title">Aman & Terpercaya</p>
                            <p class="why-item-desc">Data asesmen tersimpan aman dengan akses dikontrol berdasarkan peran pengguna.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div style="background: var(--white); border: 1px solid var(--gray-200); border-radius: 6px; padding: 20px; margin-bottom: 16px;">
                    <p style="font-size:13px; font-weight:700; color:var(--gray-800); margin-bottom:14px;">Distribusi Skor Kategori</p>
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:12px; width:80px; color:var(--gray-600); font-weight:500;">AI Fundamentals</span>
                            <div style="flex:1; height:6px; background:var(--gray-100); border-radius:3px;"><div style="width:84%; height:100%; background:var(--green-500); border-radius:3px;"></div></div>
                            <span style="font-size:12px; font-weight:600; color:var(--gray-600); width:30px; text-align:right;">84%</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:12px; width:80px; color:var(--gray-600); font-weight:500;">Prompt Engineering</span>
                            <div style="flex:1; height:6px; background:var(--gray-100); border-radius:3px;"><div style="width:76%; height:100%; background:var(--green-500); border-radius:3px;"></div></div>
                            <span style="font-size:12px; font-weight:600; color:var(--gray-600); width:30px; text-align:right;">76%</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:12px; width:80px; color:var(--gray-600); font-weight:500;">AI Ethics</span>
                            <div style="flex:1; height:6px; background:var(--gray-100); border-radius:3px;"><div style="width:49%; height:100%; background:#f59e0b; border-radius:3px;"></div></div>
                            <span style="font-size:12px; font-weight:600; color:var(--gray-600); width:30px; text-align:right;">49%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="cta-inner">
            <div class="cta-box">
                <h2 class="cta-title">
                    Siap Mengetahui<br><em>Seberapa Jauh</em> Literasi<br>AI Anda?
                </h2>
                <p class="cta-desc">
                    Mulai asesmen literasi AI Anda sekarang — gratis, terstruktur, dan hasilnya langsung bisa dianalisis.
                </p>
                <div class="cta-actions">
                    @guest
                        <a href="{{ route('register') }}" class="btn-cta-primary">
                            Daftar & Mulai Asesmen <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn-cta-ghost">
                            Masuk <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-cta-primary">
                            Ke Dashboard <i class="bi bi-arrow-right"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <div style="font-weight:700; font-size:16px; margin-bottom:8px;">LiteracyAI</div>
                    <p class="footer-brand-text">Platform asesmen literasi kecerdasan buatan berbasis instrumen ilmiah untuk lingkungan akademik.</p>
                </div>
                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="{{ route('login') }}">Asesmen Literasi</a></li>
                        <li><a href="{{ route('login') }}">Modul Pembelajaran</a></li>
                        <li><a href="{{ route('login') }}">Laporan & Analitik</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Pengguna</h4>
                    <ul>
                        <li><a href="{{ route('register') }}">Daftar Mahasiswa</a></li>
                        <li><a href="{{ route('login') }}">Masuk Dosen</a></li>
                        <li><a href="{{ route('login') }}">Portal Admin</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Lainnya</h4>
                    <ul>
                        <li><a href="#">Tentang Platform</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Literacy AI. Semua hak dilindungi.</p>
                <p>Platform aktif & terus dikembangkan</p>
            </div>
        </div>
    </footer>

</body>
</html>