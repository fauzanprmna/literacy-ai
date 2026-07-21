<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Assessment Detail Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"
        crossorigin="anonymous" />

    <style>
        .detail-board {
            display: block;
        }

        /* ── Header ── */
        .detail-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .detail-top {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 18px;
        }

        .detail-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 6px;
        }

        .detail-meta {
            display: grid;
            gap: 8px;
        }

        .detail-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray-600);
            font-size: 13px;
        }

        .detail-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .detail-actions a,
        .detail-actions button {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            border-radius: var(--radius-sm);
            padding: 10px 16px;
            border: 1px solid var(--gray-200);
            background: var(--white);
            color: var(--gray-800);
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease;
        }

        .detail-actions a:hover,
        .detail-actions button:hover {
            border-color: var(--green-600);
            background: var(--green-50);
        }

        .detail-actions .btn-primary {
            background: var(--green-600);
            color: var(--white);
            border-color: transparent;
        }

        .detail-actions .btn-primary:hover {
            background: var(--green-700);
        }

        /* ── Summary Cards ── */
        .detail-summary {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .detail-summary-grid {
            width: 100%;
        }

        .summary-card {
            background: var(--green-50);
            border-radius: var(--radius-md);
            padding: 18px;
            display: grid;
            gap: 6px;
        }

        .summary-card .summary-label {
            font-size: 12px;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
        }

        .summary-card .summary-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--green-700);
        }

        /* ── Dimension Slider ── */
        .detail-dimensions {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .slider-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .slider-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .slider-controls {
            display: flex;
            gap: 8px;
        }

        .slider-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            background: var(--white);
            color: var(--gray-600);
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: all .2s ease;
        }

        .slider-btn:hover {
            background: var(--green-50);
            border-color: var(--green-100);
            color: var(--green-700);
        }

        .dimension-slider {
            display: block;
        }

        .dimension-slider::-webkit-scrollbar {
            height: 8px;
        }

        .dimension-slider::-webkit-scrollbar-thumb {
            background: rgba(36, 59, 48, .35);
            border-radius: 999px;
        }

        .dimension-slide {
            scroll-snap-align: start;
        }

        .dimension-card {
            background: var(--green-50);
            border-radius: var(--radius-md);
            padding: 18px;
            border: 1px solid var(--gray-100);
        }

        .dimension-name {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .dimension-score {
            font-size: 22px;
            font-weight: 800;
            color: var(--green-700);
        }

        .progress-bar {
            margin-top: 14px;
            height: 10px;
            border-radius: 999px;
            background: var(--gray-200);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #0d2b1f 0%, #2a9468 100%);
            transition: width .6s cubic-bezier(.4, 0, .2, 1);
        }

        .progress-meta {
            margin-top: 10px;
            font-size: 13px;
            color: var(--gray-600);
        }

        /* ── Tabs ── */
        .detail-tabs-wrap {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .tab-nav {
            display: flex;
            border-bottom: 2px solid var(--gray-100);
            overflow-x: auto;
        }

        .tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 24px;
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-500);
            border: none;
            background: transparent;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            cursor: pointer;
            white-space: nowrap;
            transition: color .2s ease, border-color .2s ease;
        }

        .tab-btn:hover {
            color: var(--green-700);
        }

        .tab-btn.active {
            color: var(--green-700);
            border-bottom-color: var(--green-600);
        }

        .tab-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            background: var(--gray-100);
            color: var(--gray-600);
            transition: background .2s ease, color .2s ease;
        }

        .tab-btn.active .tab-badge {
            background: var(--green-100);
            color: var(--green-700);
        }

        .tab-panel {
            display: none;
            padding: 24px;
        }

        .tab-panel.active {
            display: block;
        }

        /* ── Category Scores inside tab ── */
        .cat-scores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 28px;
        }

        .cat-score-card {
            background: var(--green-50);
            border: 1px solid var(--gray-100);
            border-radius: var(--radius-md);
            padding: 16px;
        }

        .cat-score-name {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--gray-500);
            margin-bottom: 6px;
        }

        .cat-score-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--green-700);
        }

        .cat-score-sub {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        /* ── Question Groups ── */
        .question-group {
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 20px;
            margin-bottom: 16px;
        }

        .dimension-group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .dim-header-count {
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-500);
            background: var(--gray-100);
            padding: 4px 10px;
            border-radius: 999px;
        }

        .question-card {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .question-grid {
            display: block;
        }

        .question-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--gray-600);
        }

        .question-number {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--green-700);
        }

        .question-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
            line-height: 1.6;
        }

        .status-pill {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-correct {
            background: #dcfce7;
            color: #166534;
        }

        .status-wrong {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-likert {
            background: #d1fae5;
            color: #0f766e;
        }

        /* ── Answer display inside card ── */
        .answer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
        }

        .answer-card {
            padding: 12px 14px;
            border-radius: var(--radius-md);
            background: var(--white);
            border: 1px solid var(--gray-200);
        }

        .answer-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 6px;
            display: block;
        }

        .answer-value {
            font-size: 14px;
            color: var(--gray-800);
            line-height: 1.5;
        }

        /* Likert scale visual */
        .likert-scale {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .likert-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--gray-200);
            background: var(--white);
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--gray-400);
            transition: all .2s;
        }

        .likert-dot.selected {
            background: var(--green-600);
            border-color: var(--green-600);
            color: var(--white);
        }

        /* MCQ option badge */
        .mcq-user-answer {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            background: var(--white);
            border: 2px solid var(--gray-200);
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
        }

        .mcq-user-answer.is-correct {
            border-color: #16a34a;
            background: #dcfce7;
            color: #166534;
        }

        .mcq-user-answer.is-wrong {
            border-color: #dc2626;
            background: #fee2e2;
            color: #991b1b;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--gray-400);
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            display: block;
        }

        .empty-state p {
            font-size: 14px;
        }

        @media (max-width: 768px) {

            .detail-top,
            .detail-actions,
            .detail-summary-grid,
            .cat-scores-grid,
            .answer-grid {
                grid-template-columns: 1fr;
            }

            .tab-btn {
                padding: 12px 16px;
                font-size: 13px;
            }
        }
    </style>

</head>

<body>

    <div class="header">
        <h1>Assessment Report</h1>
        <p>Generated on {{ $exportDate }}</p>
    </div>
    <div class="detail-board">

        {{-- ── Header ── --}}
        <div class="detail-header">
            <div class="detail-top">
                <div>
                    <h2 class="detail-title">{{ __('assessment.assessment_result') }}</h2>
                    <div class="detail-meta">
                        <span class="detail-meta-item">
                            <i class="bi bi-person"></i>
                            {{ $sessionUser->name ?? '-' }}
                        </span>
                        <span class="detail-meta-item">
                            <i class="bi bi-calendar3"></i>
                            {{ $sessionDate->locale(app()->getLocale())->translatedFormat('d F Y, H:i') }} WIB
                        </span>
                        <span class="detail-meta-item">
                            <i class="bi bi-clock"></i>
                            {{ $duration ?? '-' }}
                        </span>
                        <span class="detail-meta-item">
                            <i class="bi bi-check2-circle"></i>
                            {{ $totalQuestions > 0 ? __('assessment.completed') : __('assessment.incomplete') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Summary ── --}}
        <div class="detail-summary">
            <div class="detail-summary-grid">
                <div class="summary-card">
                    <div class="summary-label">{{ __('assessment.total_score') }}</div>
                    <div class="summary-value">{{ $overallScore }}%</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">{{ __('messages.category') }}</div>
                    <div class="summary-value" style="font-size: 20px; padding-top: 6px;">{{ $instrumentScore }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">{{ __('assessment.total_questions') }}</div>
                    <div class="summary-value">{{ $totalQuestions }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">{{ __('assessment.likert_mcq_label') }}</div>
                    <div class="summary-value" style="font-size: 22px;">
                        {{ $likertResponses->count() }} / {{ $mcqResponses->count() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Dimension Slider ── --}}
        <div class="detail-dimensions">
            <div class="slider-header">
                <div class="slider-title">{{ __('assessment.score_per_dimension') }}</div>
                <div class="slider-controls">
                    <button type="button" class="slider-btn" id="sliderPrev" aria-label="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button type="button" class="slider-btn" id="sliderNext" aria-label="Next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="dimension-slider" id="dimensionSlider">
                @foreach ($responsesByDimension as $dimension => $data)
                    <div class="dimension-slide">
                        <div class="dimension-card">
                            <div class="dimension-name">{{ $dimension }}</div>
                            <div class="dimension-score">{{ $data['score'] }}%</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $data['score'] }}%;"></div>
                            </div>
                            <div class="progress-meta">
                                {{ __('assessment.correct') }} {{ $data['correct'] }}
                                {{ __('assessment.from') }} {{ $data['total'] }}
                                {{ __('assessment.questions') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <script>
        // ── Dimension Slider ──
        const dimensionSlider = document.getElementById('dimensionSlider');
        document.getElementById('sliderPrev')?.addEventListener('click', () => {
            dimensionSlider?.scrollBy({
                left: -280,
                behavior: 'smooth'
            });
        });
        document.getElementById('sliderNext')?.addEventListener('click', () => {
            dimensionSlider?.scrollBy({
                left: 280,
                behavior: 'smooth'
            });
        });

        // ── Tabs ──
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.dataset.tab;

                // Update buttons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');

                // Update panels
                document.querySelectorAll('.tab-panel').forEach(panel => {
                    panel.classList.remove('active');
                });
                document.getElementById('tab-' + target)?.classList.add('active');
            });
        });
    </script>
</body>

</html>
