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
        box-shadow: 0 1px 4px rgba(13,43,31,.10);
    }
    .tab-btn:hover:not(.active) { color: var(--gray-800); }

    /* Cards */
    .result-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .result-card-body { padding: 24px; }
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
    .score-big span { font-size: 24px; font-weight: 600; opacity: .6; }
    .score-sub { font-size: 13px; color: var(--gray-400); margin-top: 5px; }
    .score-right { text-align: right; }
    .score-right h3 { font-size: 26px; font-weight: 700; color: var(--gray-800); }
    .score-right p { font-size: 12px; color: var(--gray-400); }

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
    .inst-badge.excellent { background: #d1fae5; color: #065f46; }
    .inst-badge.very-good  { background: #cffafe; color: #155e75; }
    .inst-badge.satisfiable { background: #fef3c7; color: #92400e; }
    .inst-badge.need-imp   { background: #fee2e2; color: #991b1b; }

    /* Category rows */
    .cat-item {
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 16px 18px;
        margin-bottom: 10px;
        transition: box-shadow .15s;
    }
    .cat-item:hover { box-shadow: var(--shadow-md); }
    .cat-item-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .cat-item-name { font-size: 14px; font-weight: 600; color: var(--gray-800); }

    .status-pill {
        font-size: 11px; font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .sp-excellent   { background: #d1fae5; color: #065f46; }
    .sp-very-good   { background: #cffafe; color: #155e75; }
    .sp-satisfiable { background: #fef3c7; color: #92400e; }
    .sp-need-imp    { background: #fee2e2; color: #991b1b; }

    .cat-bar-wrap { height: 7px; background: var(--gray-100); border-radius: 10px; overflow: hidden; }
    .cat-bar-fill { height: 100%; border-radius: 10px; transition: width .6s ease; }
    .cb-green  { background: var(--green-500); }
    .cb-teal   { background: #0d9488; }
    .cb-yellow { background: #f59e0b; }
    .cb-red    { background: #e74c3c; }
    .cat-pct   { font-size: 12px; font-weight: 600; color: var(--gray-600); text-align: right; margin-top: 5px; }

    /* Recommendation modules */
    .rec-section { margin-bottom: 20px; }
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
    .rec-cat-name { font-size: 15px; font-weight: 700; color: var(--gray-800); }
    .rec-cat-desc { font-size: 12px; color: var(--gray-400); margin-top: 3px; }
    .rec-score { font-size: 22px; font-weight: 800; color: #e74c3c; }
    .rec-score small { font-size: 11px; color: var(--gray-400); display: block; font-weight: 500; }

    .modul-list { padding: 14px 18px; display: flex; flex-direction: column; gap: 8px; }
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
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        background: var(--green-50);
        color: var(--green-600);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .modul-item:hover .modul-icon { background: var(--green-100); }
    .modul-name { font-size: 13px; font-weight: 600; color: var(--gray-800); margin-bottom: 3px; }
    .modul-desc { font-size: 11px; color: var(--gray-400); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .modul-tag  { font-size: 10px; color: var(--green-600); margin-top: 4px; }
    .modul-arrow { margin-left: auto; color: var(--gray-400); flex-shrink: 0; align-self: center; font-size: 14px; }
    .modul-item:hover .modul-arrow { color: var(--green-600); }

    /* Empty congrats */
    .congrats-box {
        background: var(--green-50);
        border: 1px solid var(--green-100);
        border-radius: var(--radius-lg);
        padding: 48px;
        text-align: center;
    }
    .congrats-icon {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: var(--green-100);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; color: var(--green-600);
        margin: 0 auto 16px;
    }
    .congrats-box h3 { font-size: 18px; font-weight: 700; color: var(--green-800); margin-bottom: 8px; }
    .congrats-box p  { font-size: 14px; color: var(--green-700); }

    .hidden { display: none !important; }
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

        <!-- Radar Chart -->
        <div class="result-card">
            <div class="result-card-body">
                <p class="result-card-title">{{ __('assessment.literacy_understanding_analysis') }}</p>
                <div id="radarChart" style="height: 420px;"></div>
            </div>
        </div>

        <!-- Score Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="result-card mb-0">
                    <div class="result-card-body">
                        <p class="result-card-title">{{ __('assessment.overall_score') }}</p>
                        <div class="score-hero">
                            <div>
                                <div class="score-big">{{ $overallScore }}<span>%</span></div>
                                <p class="score-sub">{{ __('assessment.from_all_categories') }}</p>
                            </div>
                            <div class="score-right">
                                <h3>{{ $instrumentScore }}</h3>
                                <p>{{ __('assessment.rating') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="result-card mb-0">
                    <div class="result-card-body">
                        <p class="result-card-title">{{ __('assessment.instrument_score') }}</p>
                        @php
                            $badgeClass = match($instrumentScore) {
                                __('assessment.excellent')  => 'excellent',
                                __('assessment.very_good')  => 'very-good',
                                __('assessment.satisfiable')=> 'satisfiable',
                                default                      => 'need-imp',
                            };
                        @endphp
                        <span class="inst-badge {{ $badgeClass }}">
                            <i class="bi bi-award-fill me-2"></i> {{ $instrumentScore }}
                        </span>
                        <p style="font-size:13px;color:var(--gray-600);margin-top:8px;">
                            @if ($instrumentScore === __('assessment.excellent')) {{ __('assessment.understanding_excellent') }}
                            @elseif ($instrumentScore === __('assessment.very_good')) {{ __('assessment.understanding_very_good') }}
                            @elseif ($instrumentScore === __('assessment.satisfiable')) {{ __('assessment.understanding_satisfiable') }}
                            @else {{ __('assessment.understanding_need_improvement') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Detail -->
        <div class="result-card">
            <div class="result-card-body">
                <p class="result-card-title">{{ __('assessment.score_details_per_category') }}</p>
                @foreach ($categoryNames as $catId => $name)
                    @php
                        $percent = $categoryPercents[$catId] ?? 0;
                        $status  = $categoryStatus[$catId] ?? 'Need Improvement';
                        $spClass = match($status) {
                            __('assessment.excellent')  => 'sp-excellent',
                            __('assessment.very_good')  => 'sp-very-good',
                            __('assessment.satisfiable')=> 'sp-satisfiable',
                            default                      => 'sp-need-imp',
                        };
                        $cbClass = match($status) {
                            __('assessment.excellent')  => 'cb-green',
                            __('assessment.very_good')  => 'cb-teal',
                            __('assessment.satisfiable')=> 'cb-yellow',
                            default      => 'cb-red',
                        };
                    @endphp
                    <div class="cat-item">
                        <div class="cat-item-top">
                            <span class="cat-item-name">{{ $name }}</span>
                            <span class="status-pill {{ $spClass }}">{{ $status }}</span>
                        </div>
                        <div class="cat-bar-wrap">
                            <div class="cat-bar-fill {{ $cbClass }}" style="width: {{ $percent }}%;"></div>
                        </div>
                        <div class="cat-pct">{{ number_format($percent, 1) }}%</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB: Rekomendasi -->
    <div id="content-rekomendasi" class="tab-content hidden">
        @forelse($recommendedCategories as $catId => $data)
            <div class="rec-header rec-section">
                <div class="rec-cat-header">
                    <div>
                        <p class="rec-cat-name">{{ $data['category']->name }}</p>
                        <p class="rec-cat-desc">{{ $data['category']->deskripsi ?? 'No description' }}</p>
                    </div>
                    <div style="text-align:right;">
                        <small class="rec-score"><small>Your Score</small>{{ number_format($data['percent'], 1) }}%</small>
                    </div>
                </div>
                <div class="modul-list">
                    @forelse($data['moduls'] as $modul)
                        <a href="{{ route('modul.show', $modul) }}" class="modul-item">
                            <div class="modul-icon">
                                @if ($modul->kategoriModul)
                                    <i class="bi bi-{{ ['book' => 'book', 'video' => 'play-circle', 'file' => 'file-earmark', 'link' => 'link-45deg'][$modul->kategoriModul->name] ?? 'bookmark' }}"></i>
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
                                    <p class="modul-tag"><i class="bi bi-tag"></i> {{ $modul->kategoriModul->name }}</p>
                                @endif
                            </div>
                            <i class="bi bi-chevron-right modul-arrow"></i>
                        </a>
                    @empty
                        <div style="padding:12px;font-size:12px;color:var(--gray-400);background:var(--gray-50);border-radius:var(--radius-sm);">
                            <i class="bi bi-info-circle me-1"></i> {{ __('assessment.no_recommendations') }}
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="congrats-box">
                <div class="congrats-icon"><i class="bi bi-check-circle-fill"></i></div>
                <h3>{{ __('assessment.congratulations') }}</h3>
                <p>{{ __('assessment.all_categories_reached_target') }}</p>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3"></script>
<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById('content-' + tabName).classList.remove('hidden');
        document.getElementById('tab-' + tabName).classList.add('active');
    }

    const categoryNames   = {!! json_encode(array_values($categoryNames)) !!};
    const categoryPercents = {!! json_encode(array_values($categoryPercents)) !!};

    document.addEventListener('DOMContentLoaded', function () {
        if (!categoryNames.length) return;
        const chart = new ApexCharts(document.querySelector('#radarChart'), {
            chart: { type: 'radar', height: 420, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
            series: [{ name: 'Score', data: categoryPercents }],
            labels: categoryNames,
            colors: ['#1a5c40'],
            fill: { opacity: 0.18 },
            stroke: { show: true, width: 2, colors: ['#1a5c40'] },
            markers: { size: 4, colors: ['#1a5c40'], strokeColors: '#fff', strokeWidth: 2 },
            yaxis: { min: 0, max: 100, tickAmount: 5, labels: { formatter: v => v + '%', style: { fontSize: '11px', colors: '#8fa89d' } } },
            xaxis: { labels: { style: { fontSize: '12px', fontWeight: 600, colors: '#243b30' } } },
            plotOptions: {
                radar: {
                    size: 150,
                    polygons: {
                        strokeColors: '#dce5e0',
                        fill: { colors: ['#f8faf9', '#ffffff'] }
                    }
                }
            },
            tooltip: { y: { formatter: v => v + '%' } }
        });
        chart.render();
    });
</script>
@endpush