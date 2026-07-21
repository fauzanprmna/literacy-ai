@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@push('head')
    <style>
        /* ─── WELCOME CARD ─────────────────────────── */
        .welcome-card {
            background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
            border-radius: 12px;
            padding: 28px 32px;
            color: #fff;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        }

        .welcome-left h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .welcome-date {
            font-size: 13px;
            opacity: .7;
        }

        .welcome-right {
            text-align: right;
        }

        .score-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            opacity: .7;
            margin-bottom: 6px;
        }

        .score-value {
            font-size: 42px;
            font-weight: 700;
            line-height: 1;
        }

        .score-rating {
            font-size: 14px;
            margin-top: 6px;
            opacity: .8;
        }

        /* ─── STAT CARDS ─────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
            transition: all .2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            transform: translateY(-2px);
        }

        .stat-card-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat-icon.green {
            background: var(--green-50);
            color: var(--green-600);
        }

        .stat-icon.blue {
            background: #e8f2ff;
            color: #1a5bbf;
        }

        .stat-icon.amber {
            background: #fef3e2;
            color: #c07c00;
        }

        .stat-icon.teal {
            background: #e0f7f4;
            color: #0d766c;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* ─── CARDS ─────────────────────────── */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: var(--green-50);
            color: var(--green-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .card-header-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .card-body {
            padding: 20px;
        }

        /* ─── ACTION ROW ─────────────────────────── */
        .action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .action-info p {
            font-size: 13px;
            color: var(--gray-700);
            margin: 0 0 4px;
        }

        .action-meta {
            font-size: 12px;
            color: var(--gray-600);
        }

        .btn-primary {
            background: var(--green-700);
            color: #fff;
            border: none;
            padding: 11px 24px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-primary:hover {
            background: var(--green-600);
            transform: translateY(-1px);
        }

        /* ─── IMPROVEMENT ITEMS ─────────────────────────── */
        .improve-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .improve-item {
            border: 1px solid #fde8e8;
            border-radius: 6px;
            padding: 14px;
            background: #fffafa;
        }

        .improve-item-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .improve-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .progress-bar {
            height: 6px;
            background: var(--gray-100);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #e74c3c;
            border-radius: 10px;
        }

        .improve-target {
            font-size: 11px;
            color: var(--gray-600);
            margin-top: 6px;
        }

        /* ─── RESULTS METRICS ─────────────────────────── */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .metric-box {
            background: var(--gray-50);
            border: 1px solid var(--gray-100);
            border-radius: 6px;
            padding: 14px;
            text-align: center;
        }

        .metric-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 4px;
        }

        .metric-label {
            font-size: 11px;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* ─── CATEGORY LIST ─────────────────────────── */
        .categories-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 14px;
        }

        .category-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px 20px;
        }

        .category-row {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .category-row-top {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .category-name {
            font-weight: 500;
            color: var(--gray-700);
        }

        .category-pct {
            font-weight: 700;
            color: var(--gray-800);
        }

        .category-bar {
            height: 6px;
            background: var(--gray-100);
            border-radius: 10px;
            overflow: hidden;
        }

        .category-fill {
            height: 100%;
            border-radius: 10px;
            transition: width .4s ease;
        }

        .category-fill.good {
            background: var(--green-500);
        }

        .category-fill.warn {
            background: #f59e0b;
        }

        .category-fill.danger {
            background: #e74c3c;
        }

        /* ─── EMPTY STATE ─────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--green-50);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--green-600);
            margin: 0 auto 16px;
        }

        .empty-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 6px;
        }

        .empty-desc {
            font-size: 13px;
            color: var(--gray-600);
            margin-bottom: 16px;
        }

        /* ─── RESPONSIVE ─────────────────────── */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .metrics-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .category-list {
                grid-template-columns: 1fr;
            }

            .improve-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .welcome-card {
                flex-direction: column;
                text-align: center;
            }

            .welcome-right {
                margin-top: 12px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .action-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')

    <!-- Welcome Card -->
    <div class="welcome-card">
        <div class="welcome-left">
            <h2>{{ __('assessment.dashboard_welcome', ['name' => Auth::user()->name]) }}</h2>
            <p class="welcome-date">{{ now()->translatedFormat('l, j F Y') }}</p>
        </div>
        <div class="welcome-right">
            <p class="score-label">{{ __('assessment.dashboard_literacy_level') }}</p>
            <div class="score-value">{{ $overallScore ?? 0 }}<span style="font-size: 18px; opacity: .7;">%</span></div>
            <p class="score-rating">
                @if ($overallScore >= 80)
                    ⭐⭐⭐⭐⭐
                @elseif($overallScore >= 60)
                    ⭐⭐⭐⭐
                @elseif($overallScore >= 40)
                    ⭐⭐⭐
                @elseif($overallScore >= 20)
                    ⭐⭐
                @else
                    ⭐
                @endif
            </p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon green"><i class="bi bi-clipboard-check"></i></div>
            </div>
            <div class="stat-value">{{ $totalTestCount ?? 0 }}</div>
            <div class="stat-label">{{ __('assessment.dashboard_test_count') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon teal"><i class="bi bi-bar-chart"></i></div>
            </div>
            <div class="stat-value">{{ $overallScore ?? 0 }}%</div>
            <div class="stat-label">{{ __('assessment.dashboard_overall_score') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon amber"><i class="bi bi-question-circle"></i></div>
            </div>
            <div class="stat-value">{{ $totalQuestions ?? 0 }}</div>
            <div class="stat-label">{{ __('assessment.dashboard_total_questions') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-top">
                <div class="stat-icon blue"><i class="bi bi-trophy"></i></div>
            </div>
            <div class="stat-value">{{ $totalBobotObtained ?? 0 }}</div>
            <div class="stat-label">{{ __('assessment.dashboard_total_weight') }}</div>
        </div>
    </div>

    <!-- Start Assessment -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-icon"><i class="bi bi-play-circle"></i></div>
            <div class="card-header-title">{{ __('assessment.dashboard_start_assessment') }}</div>
        </div>
        <div class="card-body">
            <div class="action-row">
                <div class="action-info">
                    <p>{{ __('assessment.dashboard_measure_skills') }}</p>
                    <span class="action-meta">{{ __('assessment.dashboard_duration') }} · {{ $totalQuestions ?? 0 }}
                        {{ __('assessment.dashboard_total_questions') }}</span>
                </div>
                <a href="{{ route('pengukuran.index') }}" class="btn-primary">
                    <i class="bi bi-play-fill"></i> {{ __('assessment.dashboard_start_now') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Categories for Improvement -->
    @if (count($categoriesForImprovement) > 0)
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="card-header-title">{{ __('assessment.dashboard_categories_improvement') }}</div>
            </div>
            <div class="card-body">
                <p style="font-size: 13px; color: var(--gray-600); margin-bottom: 16px;">
                    {{ __('assessment.dashboard_improvement_text') }}
                </p>
                <div class="improve-grid">
                    @foreach ($categoriesForImprovement as $category)
                        <div class="improve-item">
                            <div class="improve-item-top">
                                <span class="improve-name">{{ $category['name'] }}</span>
                                <span class="badge-danger">{{ $category['score'] }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $category['score'] }}%;"></div>
                            </div>
                            <p class="improve-target">{{ __('assessment.dashboard_target') }}: 80%</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Spider Chart -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-icon"><i class="bi bi-pie-chart-fill"></i></div>
            <div class="card-header-title">{{ __('assessment.dashboard_spider_chart') }}</div>
        </div>
        <div class="card-body">
            <div id="spider-chart" style="min-height: 340px;"></div>
        </div>
    </div>



    <!-- Latest Results -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-icon"><i class="bi bi-graph-up"></i></div>
            <div class="card-header-title">{{ __('assessment.dashboard_latest_results') }}</div>
        </div>
        <div class="card-body">
            @if ($totalQuestions > 0)
                <div class="metrics-grid">
                    <div class="metric-box">
                        <div class="metric-value" style="color: var(--green-600);">{{ $overallScore }}%</div>
                        <div class="metric-label">{{ __('assessment.dashboard_overall_score') }}</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-value">{{ $instrumentScore }}</div>
                        <div class="metric-label">{{ __('assessment.dashboard_instrument_score') }}</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-value" style="color: #0d766c;">
                            {{ $totalBobotObtained }}/{{ $totalMaxPossible }}</div>
                        <div class="metric-label">{{ __('assessment.dashboard_total_weight') }}</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-value" style="font-size: 14px;">
                            {{ $lastTestDate ? $lastTestDate->translatedFormat('d M Y') : '—' }}
                        </div>
                        <div class="metric-label">{{ __('assessment.dashboard_test_date') }}</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-value" style="font-size: 14px;">
                            {{ $lastTestDate ? $lastTestDate->diffForHumans() : '—' }}
                        </div>
                        <div class="metric-label">{{ __('assessment.dashboard_last_taken') }}</div>
                    </div>
                </div>

                <p class="categories-title">{{ __('assessment.dashboard_score_per_category') }}</p>
                <div class="category-list">
                    @forelse($categoryNames as $catId => $catName)
                        @php
                            $pct = round($categoryPercents[$catId] ?? 0);
                            $fillClass = $pct >= 81 ? 'good' : ($pct > 65 ? 'warn' : 'danger');
                            $pctColor = $pct >= 81 ? 'var(--green-600)' : ($pct > 65 ? '#c07c00' : '#e74c3c');
                        @endphp
                        <div class="category-row">
                            <div class="category-row-top">
                                <span class="category-name">{{ $catName }}</span>
                                <span class="category-pct"
                                    style="color: {{ $pctColor }}">{{ $pct }}%</span>
                            </div>
                            <div class="category-bar">
                                <div class="category-fill {{ $fillClass }}" style="width: {{ $pct }}%;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            style="grid-column: 1/-1; text-align: center; color: var(--gray-600); font-size: 13px; padding: 16px 0;">
                            {{ __('assessment.dashboard_no_data') }}
                        </div>
                    @endforelse
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-graph-up"></i></div>
                    <h5 class="empty-title">{{ __('assessment.dashboard_start_assessment') }}</h5>
                    <p class="empty-desc">{{ __('assessment.dashboard_measure_skills') }}</p>
                    <a href="{{ route('pengukuran.index') }}" class="btn-primary">
                        <i class="bi bi-play-fill"></i> {{ __('assessment.dashboard_start_now') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categories = @json(array_values($categoryNames));
            const scores = @json(array_map(function ($catId) use ($categoryPercents) {
                    return round($categoryPercents[$catId] ?? 0);
                }, array_keys($categoryNames)));

            if (categories.length && scores.length) {
                const options = {
                    chart: {
                        type: 'radar',
                        height: 480,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true
                        }
                    },
                    series: [{
                        name: 'Skor (%)',
                        data: scores
                    }],
                    xaxis: {
                        categories: categories,
                        min: 0,
                        max: 100,
                        tickAmount: 5,
                        labels: {
                            formatter: v => v + '%',
                            style: {
                                fontSize: '11px',
                                colors: '#8fa89d'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        tickAmount: 5,
                        labels: {
                            formatter: v => v + '%',
                            style: {
                                fontSize: '11px',
                                colors: '#8fa89d'
                            }
                        }
                    },
                    markers: {
                        size: 4
                    },
                    fill: {
                        opacity: 0.35
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['#1a5c40']
                    },
                    dataLabels: {
                        enabled: false
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value + '%';
                            }
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector('#spider-chart'), options);
                chart.render();
            }
        });
    </script>
@endpush
