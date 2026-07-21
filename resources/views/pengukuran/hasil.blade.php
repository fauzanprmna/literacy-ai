@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('assessment.measurement_results'))
@section('header', __('assessment.measurement_results'))

@push('head')
    <style>
        .tab-nav {
            display: flex;
            gap: 4px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
            padding: 4px;
            margin-bottom: 24px;
            width: fit-content;
        }

        .tab-btn {
            padding: 9px 22px;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            border: none;
            background: none;
            color: var(--gray-400);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all .18s;
        }

        .tab-btn.active {
            background: var(--white);
            color: var(--green-700);
            box-shadow: 0 1px 4px rgba(13, 43, 31, .10);
        }

        .tab-btn:hover:not(.active) {
            color: var(--gray-800);
        }

        /* Cards */
        .result-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .result-card-body {
            padding: 24px;
        }

        .result-card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 18px;
        }

        /* Score hero */
        .score-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .score-big {
            font-size: 56px;
            font-weight: 800;
            line-height: 1;
            color: var(--green-600);
            letter-spacing: -.03em;
        }

        .score-big span {
            font-size: 24px;
            font-weight: 600;
            opacity: .6;
        }

        .score-sub {
            font-size: 13px;
            color: var(--gray-400);
            margin-top: 5px;
        }

        .score-right {
            text-align: right;
        }

        .score-right h3 {
            font-size: 26px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .score-right p {
            font-size: 12px;
            color: var(--gray-400);
        }

        /* Instrument badge */
        .inst-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .inst-badge.excellent {
            background: #d1fae5;
            color: #065f46;
        }

        .inst-badge.very-good {
            background: #cffafe;
            color: #155e75;
        }

        .inst-badge.satisfiable {
            background: #fef3c7;
            color: #92400e;
        }

        .inst-badge.need-imp {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Category rows */
        .cat-item {
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 16px 18px;
            margin-bottom: 10px;
            transition: box-shadow .15s;
        }

        .cat-item:hover {
            box-shadow: var(--shadow-md);
        }

        .cat-item-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cat-item-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .status-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .sp-excellent {
            background: #d1fae5;
            color: #065f46;
        }

        .sp-very-good {
            background: #cffafe;
            color: #155e75;
        }

        .sp-satisfiable {
            background: #fef3c7;
            color: #92400e;
        }

        .sp-need-imp {
            background: #fee2e2;
            color: #991b1b;
        }

        .cat-bar-wrap {
            height: 7px;
            background: var(--gray-100);
            border-radius: 10px;
            overflow: hidden;
        }

        .cat-bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width .6s ease;
        }

        .cb-green {
            background: var(--green-500);
        }

        .cb-teal {
            background: #0d9488;
        }

        .cb-yellow {
            background: #f59e0b;
        }

        .cb-red {
            background: #e74c3c;
        }

        .cat-pct {
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-600);
            text-align: right;
            margin-top: 5px;
        }

        /* Split Score Display */
        .split-score-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .score-column {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-sm);
        }

        .score-column h3 {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--gray-100);
        }

        .score-column.persepsi h3 {
            border-bottom-color: #0d9488;
            color: #0d9488;
        }

        .score-column.actual h3 {
            border-bottom-color: var(--green-600);
            color: var(--green-600);
        }

        .score-display {
            text-align: center;
        }

        .score-number {
            font-size: 48px;
            font-weight: 800;
            color: var(--green-600);
        }

        .score-column.persepsi .score-number {
            color: #0d9488;
        }

        .score-label {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Category split comparison */
        .category-comparison {
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 16px 18px;
            margin-bottom: 10px;
        }

        .comp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .comp-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .comp-scores {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .comp-score {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 12px;
            background: var(--gray-50);
            border-radius: var(--radius-sm);
        }

        .comp-score-value {
            font-size: 16px;
            font-weight: 700;
        }

        .comp-score-label {
            font-size: 10px;
            color: var(--gray-500);
            margin-top: 2px;
        }

        .comp-score.persepsi .comp-score-value {
            color: #0d9488;
        }

        .comp-score.actual .comp-score-value {
            color: var(--green-600);
        }

        .comp-bars {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .comp-bar-item {
            flex: 1;
        }

        .comp-bar-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 4px;
        }

        .comp-bar-track {
            height: 6px;
            background: var(--gray-100);
            border-radius: 3px;
            overflow: hidden;
        }

        .comp-bar-persepsi {
            background: #0d9488;
        }

        .comp-bar-actual {
            background: var(--green-600);
        }

        /* Recommendation modules */
        .rec-section {
            margin-bottom: 20px;
        }

        .rec-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .rec-cat-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .rec-cat-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .rec-cat-desc {
            font-size: 12px;
            color: var(--gray-400);
            margin-top: 3px;
        }

        .rec-score {
            font-size: 22px;
            font-weight: 800;
            color: #e74c3c;
        }

        .rec-score small {
            font-size: 11px;
            color: var(--gray-400);
            display: block;
            font-weight: 500;
        }

        .modul-list {
            padding: 14px 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .modul-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            text-decoration: none;
            color: inherit;
            transition: all .16s;
        }

        .modul-item:hover {
            border-color: var(--green-300);
            background: var(--green-50);
            color: inherit;
            transform: translateX(3px);
        }

        .modul-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            background: var(--green-50);
            color: var(--green-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .modul-item:hover .modul-icon {
            background: var(--green-100);
        }

        .modul-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 3px;
        }

        .modul-desc {
            font-size: 11px;
            color: var(--gray-400);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .modul-tag {
            font-size: 10px;
            color: var(--green-600);
            margin-top: 4px;
        }

        .modul-arrow {
            margin-left: auto;
            color: var(--gray-400);
            flex-shrink: 0;
            align-self: center;
            font-size: 14px;
        }

        .modul-item:hover .modul-arrow {
            color: var(--green-600);
        }

        /* Empty congrats */
        .congrats-box {
            background: var(--green-50);
            border: 1px solid var(--green-100);
            border-radius: var(--radius-lg);
            padding: 48px;
            text-align: center;
        }

        .congrats-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--green-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--green-600);
            margin: 0 auto 16px;
        }

        .congrats-box h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--green-800);
            margin-bottom: 8px;
        }

        .congrats-box p {
            font-size: 14px;
            color: var(--green-700);
        }

        .hidden {
            display: none !important;
        }

        .scraping-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            margin-top: 20px;
            overflow: hidden;
        }

        .scraping-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-100);
        }

        .scraping-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .scraping-subtitle {
            font-size: 12px;
            color: var(--gray-400);
        }

        .resource-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--gray-100);
            text-decoration: none;
            color: inherit;
            transition: .15s;
        }

        .resource-item:hover {
            background: var(--green-50);
        }

        .resource-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--green-50);
            color: var(--green-600);
            font-size: 18px;
        }

        .resource-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .resource-desc {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        .resource-meta {
            margin-top: 6px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .resource-badge {
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 20px;
            background: var(--green-100);
            color: var(--green-700);
        }

        .rec-tab-nav {
            display: flex;
            gap: 4px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
            padding: 4px;
            margin-bottom: 20px;
            width: fit-content;
        }

        .rec-tab-btn {
            padding: 8px 18px;
            border: none;
            background: transparent;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-500);
            cursor: pointer;
            transition: .15s;
        }

        .rec-tab-btn.active {
            background: white;
            color: var(--green-700);
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
        }

        .rec-tab-content.hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .split-score-row {
                grid-template-columns: 1fr;
            }

            .comp-bars {
                flex-direction: column;
            }

            .score-big {
                font-size: 42px;
            }
        }
    </style>
@endpush

@section('content')

    <!-- Tab Nav -->
    <div class="tab-nav">
        <button type="button" onclick="switchTab('hasil')" id="tab-hasil" class="tab-btn active">
            <i class="bi bi-graph-up-arrow"></i> {{ __('assessment.results') }}
        </button>
        <button type="button" onclick="switchTab('rekomendasi')" id="tab-rekomendasi" class="tab-btn">
            <i class="bi bi-book-half"></i> {{ __('assessment.module_recommendations') }}
        </button>
    </div>

    <!-- TAB: Hasil -->
    <div id="content-hasil" class="tab-content">

        <!-- SPLIT SCORE: PERSEPSI vs AKTUAL -->
        <div class="split-score-row">
            <!-- Persepsi (Likert) -->
            <div class="score-column persepsi">
                <h3>Hasil Persepsi (Skala Likert)</h3>
                <div class="score-display">
                    <div class="score-number">{{ $overallLikertScore }}<span style="font-size: 24px; opacity: 0.6;">%</span></div>
                    <div class="score-label">Pemahaman & Persepsi Anda</div>
                    <p style="font-size: 12px; color: var(--gray-500); margin-top: 8px;">
                        Skor berdasarkan respons personal Anda terhadap pernyataan literasi AI
                    </p>
                </div>
            </div>

            <!-- Aktual Kompetensi (MC) -->
            <div class="score-column actual">
                <h3>Hasil Aktual Kompetensi (Pilihan Ganda)</h3>
                <div class="score-display">
                    <div class="score-number">{{ $overallMcScore }}<span style="font-size: 24px; opacity: 0.6;">%</span></div>
                    <div class="score-label">Kompetensi Nyata Anda</div>
                    <p style="font-size: 12px; color: var(--gray-500); margin-top: 8px;">
                        Skor berdasarkan jawaban benar pada kasus-kasus praktik
                    </p>
                </div>
            </div>
        </div>

        <!-- Overall Rating -->
        <div class="result-card">
            <div class="result-card-body">
                <p class="result-card-title">{{ __('assessment.instrument_score') }}</p>
                @php
                    $badgeClass = match ($instrumentScore) {
                        __('assessment.excellent') => 'excellent',
                        __('assessment.very_good') => 'very-good',
                        __('assessment.satisfiable') => 'satisfiable',
                        default => 'need-imp',
                    };
                @endphp
                <span class="inst-badge {{ $badgeClass }}">
                    <i class="bi bi-award-fill me-2"></i> {{ $instrumentScore }}
                </span>
                <p style="font-size:13px;color:var(--gray-600);margin-top:8px;">
                    Rating Anda berdasarkan <strong>Hasil Aktual Kompetensi (Pilihan Ganda)</strong>
                    @if ($instrumentScore === __('assessment.excellent'))
                        , Pemahaman Anda tentang literasi AI sangat luar biasa!
                    @elseif ($instrumentScore === __('assessment.very_good'))
                        , Anda memiliki pemahaman yang sangat baik tentang literasi AI
                    @elseif ($instrumentScore === __('assessment.satisfiable'))
                        , Anda memiliki pemahaman yang cukup, namun masih perlu dikembangkan
                    @else
                        , Anda perlu meningkatkan pemahaman tentang literasi AI melalui pembelajaran lebih lanjut
                    @endif
                </p>
            </div>
        </div>

        <!-- Category Comparison: Persepsi vs Aktual -->
        <div class="result-card">
            <div class="result-card-body">
                <p class="result-card-title">📈 Perbandingan Persepsi vs Aktual Kompetensi per Kategori</p>
                
                @foreach ($categoryNames as $catId => $name)
                    @php
                        $likertPct = $categoryLikertPercents[$catId] ?? 0;
                        $mcPct = $categoryMcPercents[$catId] ?? 0;
                        $diff = $mcPct - $likertPct;
                        $status = $categoryStatus[$catId] ?? 'Perlu Ditingkatkan';
                    @endphp
                    <div class="category-comparison">
                        <div class="comp-header">
                            <span class="comp-name">{{ $name }}</span>
                            <div class="comp-scores">
                                <div class="comp-score persepsi">
                                    <span class="comp-score-value">{{ number_format($likertPct, 1) }}%</span>
                                    <span class="comp-score-label">Persepsi</span>
                                </div>
                                <div class="comp-score actual">
                                    <span class="comp-score-value">{{ number_format($mcPct, 1) }}%</span>
                                    <span class="comp-score-label">Aktual</span>
                                </div>
                            </div>
                        </div>
                        <div class="comp-bars">
                            <div class="comp-bar-item">
                                <div class="comp-bar-label">Persepsi (Likert)</div>
                                <div class="comp-bar-track">
                                    <div class="comp-bar-persepsi" style="width: {{ $likertPct }}%;"></div>
                                </div>
                            </div>
                            <div class="comp-bar-item">
                                <div class="comp-bar-label">Aktual (Pilihan Ganda)</div>
                                <div class="comp-bar-track">
                                    <div class="comp-bar-actual" style="width: {{ $mcPct }}%;"></div>
                                </div>
                            </div>
                        </div>
                        <p style="font-size: 11px; color: var(--gray-500); margin-top: 8px;">
                            @if ($diff < -10)
                                <span style="color: #f59e0b;">⚠️ Gap: Persepsi lebih tinggi {{ abs($diff) }}% dari aktual</span>
                            @elseif ($diff > 10)
                                <span style="color: var(--green-600);">✓ Aktual lebih tinggi {{ abs($diff) }}% dari persepsi (positif!)</span>
                            @else
                                <span style="color: #0d9488;">≈ Persepsi & Aktual cukup selaras</span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB: Rekomendasi -->
    <div id="content-rekomendasi" class="tab-content hidden">
        <div class="rec-tab-nav">
            <button id="rec-tab-modul" class="rec-tab-btn active" onclick="switchRecommendationTab('modul')">
                <i class="bi bi-book-half"></i>
                {{ __('messages.modules') }}
            </button>

            <button id="rec-tab-resource" class="rec-tab-btn" onclick="switchRecommendationTab('resource')">
                <i class="bi bi-lightbulb"></i>
                {{ __('assessment.learning_resources') }}
            </button>
        </div>

        <div id="rec-content-modul" class="rec-tab-content">

            @if (count($recommendedCategories ?? []) > 0)
                <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #856404;">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Hasil Aktual Kompetensi di bawah 70%</strong> — Modul berikut direkomendasikan untuk meningkatkan kompetensi Anda:
                </div>

                @forelse($recommendedCategories as $catId => $data)
                    <div class="rec-header rec-section">
                        <div class="rec-cat-header">
                            <div>
                                <p class="rec-cat-name">{{ $data['category']->name }}</p>
                                <p class="rec-cat-desc">{{ $data['category']->description ?? 'No description' }}</p>
                            </div>
                            <div style="text-align:right;">
                                <small class="rec-score">
                                    <small>Aktual Kompetensi</small>
                                    {{ number_format($data['actual_percent'], 1) }}%
                                </small>
                                <small style="display: block; font-size: 10px; color: var(--gray-500); margin-top: 4px;">
                                    (Persepsi: {{ number_format($data['percept_percent'], 1) }}%)
                                </small>
                            </div>
                        </div>
                        <div class="modul-list">
                            @forelse($data['moduls'] as $modul)
                                <a href="{{ route('modul.showContent', $modul) }}" class="modul-item">
                                    <div class="modul-icon">
                                        @if ($modul->kategoriModul)
                                            <i
                                                class="bi bi-{{ ['book' => 'book', 'video' => 'play-circle', 'file' => 'file-earmark', 'link' => 'link-45deg'][$modul->kategoriModul->name] ?? 'bookmark' }}"></i>
                                        @else
                                            <i class="bi bi-file-earmark-text"></i>
                                        @endif
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <p class="modul-name">{{ $modul->name }}</p>
                                        @if ($modul->isi)
                                            <p class="modul-desc">{{ $modul->isi }}</p>
                                        @endif
                                        @if ($modul->kategoriModul)
                                            <p class="modul-tag"><i class="bi bi-tag"></i> {{ $modul->kategoriModul->name }}
                                            </p>
                                        @endif
                                    </div>
                                    <i class="bi bi-chevron-right modul-arrow"></i>
                                </a>
                            @empty
                                <div
                                    style="padding:12px;font-size:12px;color:var(--gray-400);background:var(--gray-50);border-radius:var(--radius-sm);">
                                    <i class="bi bi-info-circle me-1"></i> {{ __('assessment.no_recommendations') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                @endforelse
            @else
                <div class="congrats-box">
                    <div class="congrats-icon"><i class="bi bi-check-circle-fill"></i></div>
                    <h3>🎉 Selamat!</h3>
                    <p>Semua kategori kompetensi Anda sudah mencapai target 70%+. Tidak ada modul yang perlu direkomendasi.</p>
                </div>
            @endif
        </div>

        <div id="rec-content-resource" class="rec-tab-content hidden">

            @if (isset($recommendedContents) && $recommendedContents->count())

                <div class="rec-header rec-section">

                    <div class="rec-cat-header">
                        <div>
                            <p class="rec-cat-name">
                                {{ __('assessment.learning_resources') }}
                            </p>

                            <p class="rec-cat-desc">
                                Sumber belajar eksternal yang relevan dengan kategori yang perlu ditingkatkan
                            </p>
                        </div>
                    </div>

                    <div class="modul-list">

                        @foreach ($recommendedContents as $content)
                            <a href="{{ $content->url }}" target="_blank" class="modul-item">

                                <div class="modul-icon">

                                    @if ($content->source === 'youtube')
                                        <i class="bi bi-play-circle"></i>
                                    @elseif($content->source === 'journal')
                                        <i class="bi bi-journal-text"></i>
                                    @else
                                        <i class="bi bi-file-earmark"></i>
                                    @endif

                                </div>

                                <div style="flex:1;min-width:0;">

                                    <p class="modul-name">
                                        {{ $content->title }}
                                    </p>

                                    <p class="modul-desc">
                                        {{ \Illuminate\Support\Str::limit($content->description, 180) }}
                                    </p>

                                    <p class="modul-tag">
                                        <i class="bi bi-tag"></i>

                                        {{ $content->classification?->dimension }}
                                        •
                                        {{ round(($content->classification?->confidence ?? 0) * 100) }}%
                                        •
                                        {{ ucfirst($content->source) }}
                                    </p>

                                </div>

                                <i class="bi bi-box-arrow-up-right modul-arrow"></i>

                            </a>
                        @endforeach

                    </div>

                </div>
            @else
                <div class="congrats-box">

                    <div class="congrats-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <h3>{{ __('assessment.no_learning_resources') }}</h3>

                    <p>
                        {{ __('assessment.learning_resources_not_available') }}
                    </p>

                </div>

            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('content-' + tabName).classList.remove('hidden');
            document.getElementById('tab-' + tabName).classList.add('active');
        }

        function switchRecommendationTab(tab) {
            document
                .querySelectorAll('.rec-tab-content')
                .forEach(el => el.classList.add('hidden'));

            document
                .querySelectorAll('.rec-tab-btn')
                .forEach(el => el.classList.remove('active'));

            document
                .getElementById('rec-content-' + tab)
                .classList.remove('hidden');

            document
                .getElementById('rec-tab-' + tab)
                .classList.add('active');
        }
    </script>
@endpush