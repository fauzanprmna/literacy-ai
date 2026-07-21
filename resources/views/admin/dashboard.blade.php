@extends('template.template-admin')

@section('title', __('dashboard.title'))
@section('header', __('dashboard.title'))

@push('head')
    <style>
        /* ── Welcome ── */
        .welcome-card {
            background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
            border-radius: 12px;
            padding: 28px 32px;
            color: #fff;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }
        .welcome-left h2 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
        .welcome-date    { font-size: 13px; opacity: .7; }
        .welcome-right   { text-align: right; }
        .score-label     { font-size: 11px; text-transform: uppercase; letter-spacing: .08em; opacity: .7; margin-bottom: 6px; }
        .score-value     { font-size: 42px; font-weight: 700; line-height: 1; }

        /* ── Stat cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
            transition: all .2s;
            text-align: center;
        }
        .stat-card:hover { border-color: var(--green-600); box-shadow: 0 4px 12px rgba(0,0,0,.08); }
        .stat-card .stat-value { font-size: 28px; font-weight: 700; color: var(--gray-800); margin: 10px 0; }
        .stat-card .stat-label { font-size: 12px; color: var(--gray-600); line-height: 1.4; }
        .stat-card.accent { border-color: var(--green-600); background: linear-gradient(135deg,rgba(42,143,109,.05) 0%,rgba(26,92,64,.05) 100%); }
        .stat-card.accent .stat-value { color: var(--green-700); }

        /* ── Card ── */
        .card { background: var(--white); border: 1px solid var(--gray-200); border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 20px; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--gray-200); background: var(--gray-50); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .card-header h4 { margin: 0; font-size: 16px; font-weight: 700; color: var(--gray-800); }
        .card-body { padding: 20px; }

        /* ── Split result tabs ── */
        .result-tabs-wrap { background: var(--white); border: 1px solid var(--gray-200); border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 20px; overflow: hidden; }
        .result-tab-nav { display: flex; border-bottom: 2px solid var(--gray-100); }
        .result-tab-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-500);
            border: none;
            background: transparent;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            cursor: pointer;
            transition: color .2s, border-color .2s;
        }
        .result-tab-btn:hover { color: var(--green-700); }
        .result-tab-btn.active { color: var(--green-700); border-bottom-color: var(--green-600); }
        .result-tab-btn .tab-icon { font-size: 16px; }
        .result-tab-btn .tab-score {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 12px;
            background: var(--gray-100);
            color: var(--gray-600);
            transition: background .2s, color .2s;
        }
        .result-tab-btn.active .tab-score { background: var(--green-100); color: var(--green-700); }
        .result-tab-panel { display: none; padding: 20px; }
        .result-tab-panel.active { display: block; }

        /* ── Summary stats inside tab ── */
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        .summary-stat { background: var(--gray-50); border-radius: 6px; padding: 14px; text-align: center; }
        .summary-stat-label { font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
        .summary-stat-value { font-size: 22px; font-weight: 700; color: var(--gray-800); }

        /* ── Metric cards ── */
        .metric-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
        .metric-card { border-radius: 8px; padding: 18px; text-align: center; }
        .metric-card.high   { background: linear-gradient(135deg,#d1fae5 0%,#a7f3d0 100%); }
        .metric-card.medium { background: linear-gradient(135deg,#fef3c7 0%,#fde68a 100%); }
        .metric-card.low    { background: linear-gradient(135deg,#fee2e2 0%,#fecaca 100%); }
        .metric-label { font-size: 12px; color: var(--gray-600); margin-bottom: 8px; text-transform: uppercase; letter-spacing: .05em; }
        .metric-value { font-size: 28px; font-weight: 700; color: var(--gray-800); }
        .metric-info  { font-size: 12px; color: var(--gray-600); margin-top: 4px; }

        /* ── Charts inside tab ── */
        .tab-analytics-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
        .chart-container { position: relative; height: 280px; }

        /* ── Category grid ── */
        .category-grid { display: grid; grid-template-columns: repeat(auto-fit,minmax(160px,1fr)); gap: 12px; }
        .category-item { background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 6px; padding: 14px; text-align: center; }
        .category-name  { font-size: 11px; color: var(--gray-600); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; font-weight: 600; }
        .category-score { font-size: 22px; font-weight: 700; color: var(--green-700); }
        .category-stats { font-size: 11px; color: var(--gray-600); margin-top: 4px; }
        .progress-bar-container { margin-top: 8px; }
        .progress-bar   { width: 100%; height: 6px; background: var(--gray-200); border-radius: 3px; overflow: hidden; }
        .progress-fill  { height: 100%; background: linear-gradient(90deg,var(--green-600),var(--green-700)); transition: width .3s ease; }

        /* ── Table ── */
        .table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table thead { background: var(--gray-50); }
        .table th { padding: 12px; text-align: left; font-weight: 700; color: var(--gray-700); border-bottom: 2px solid var(--gray-200); }
        .table td { padding: 12px; border-bottom: 1px solid var(--gray-200); vertical-align: middle; }
        .table tbody tr:hover { background: var(--gray-50); }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
        .badge-success { background: rgba(16,185,129,.1); color: #10b981; }
        .badge-warning { background: rgba(245,158,11,.1); color: #f59e0b; }
        .badge-danger  { background: rgba(239,68,68,.1); color: #ef4444; }
        .badge-blue    { background: rgba(59,130,246,.1); color: #3b82f6; }
        .badge-purple  { background: rgba(139,92,246,.1); color: #8b5cf6; }
        .score-bar { display: flex; align-items: center; gap: 6px; }
        .score-bar-fill { flex: 1; height: 6px; background: var(--gray-200); border-radius: 3px; overflow: hidden; }
        .score-bar-value { font-size: 12px; font-weight: 700; color: var(--gray-700); min-width: 35px; text-align: right; }

        /* ── Quick links ── */
        .btn-primary { background: var(--green-700); color: #fff; border: none; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-block; transition: all .2s; }
        .btn-primary:hover { background: var(--green-600); }

        /* ── Section label ── */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        .label-likert  { background: #d1fae5; color: #0f766e; }
        .label-mcq     { background: #dbeafe; color: #1e40af; }
        .label-overall { background: var(--green-100); color: var(--green-700); }

        @media (max-width: 1200px) {
            .stats-grid           { grid-template-columns: repeat(3,1fr); }
            .metric-cards         { grid-template-columns: 1fr; }
            .tab-analytics-grid   { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .stats-grid     { grid-template-columns: repeat(2,1fr); }
            .summary-stats  { grid-template-columns: repeat(2,1fr); }
            .welcome-card   { flex-direction: column; align-items: flex-start; gap: 16px; }
            .welcome-right  { text-align: left; }
            .result-tab-nav { flex-direction: column; }
        }
    </style>
@endpush

@section('content')

    {{-- Welcome --}}
    <div class="welcome-card">
        <div class="welcome-left">
            <h2>{{ __('assessment.dashboard_welcome', ['name' => Auth::user()->name]) }}</h2>
            <p class="welcome-date">{{ now()->translatedFormat('l, j F Y') }}</p>
        </div>
        <div class="welcome-right">
            <p class="score-label">{{ __('dashboard.system_summary') }}</p>
            <div class="score-value">{{ number_format($userCount + $modulCount + ($totalAssessments ?? 0)) }}</div>
            <p style="opacity:.8; font-size:13px;">{{ __('dashboard.total_system_data') }}</p>
        </div>
    </div>

    {{-- Main Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $userCount ?? 0 }}</div>
            <div class="stat-label">{{ __('dashboard.total_users') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $modulCount ?? 0 }}</div>
            <div class="stat-label">{{ __('dashboard.total_modules') }}</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-value">{{ $mahasiswaAssessed ?? 0 }}</div>
            <div class="stat-label">{{ __('dashboard.students_assessed') }}</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-value">{{ $dosenAssessed ?? 0 }}</div>
            <div class="stat-label">{{ __('dashboard.lecturers_assessed') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $totalAssessments ?? 0 }}</div>
            <div class="stat-label">{{ __('dashboard.total_answers') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $uniqueUsers ?? 0 }}</div>
            <div class="stat-label">{{ __('dashboard.active_users') }}</div>
        </div>
    </div>

    {{-- ============================================================
         SPLIT RESULT: 2 TABS — PERSEPSI & KOMPETENSI AKTUAL
    ============================================================ --}}
    <div class="result-tabs-wrap">
        <div class="result-tab-nav" role="tablist">
            <button class="result-tab-btn active" data-rtab="persepsi" role="tab" aria-selected="true">
                <i class="bi bi-sliders tab-icon"></i>
                {{ __('dashboard.tab_persepsi') }}
                <span class="tab-score">{{ __('dashboard.avg') }} {{ $likertAvg }}%</span>
            </button>
            <button class="result-tab-btn" data-rtab="kompetensi" role="tab" aria-selected="false">
                <i class="bi bi-ui-radios tab-icon"></i>
                {{ __('dashboard.tab_kompetensi') }}
                <span class="tab-score">{{ __('dashboard.avg') }} {{ $mcqAvg }}%</span>
            </button>
        </div>

        {{-- ===== TAB: PERSEPSI (LIKERT) ===== --}}
        <div class="result-tab-panel active" id="rtab-persepsi">

            {{-- Summary --}}
            <div class="summary-stats">
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.average_score') }}</div>
                    <div class="summary-stat-value">{{ $likertAvg }}%</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.highest_score') }}</div>
                    <div class="summary-stat-value">{{ $likertHighest }}%</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.lowest_score') }}</div>
                    <div class="summary-stat-value">{{ $likertLowest }}%</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.total_respondents') }}</div>
                    <div class="summary-stat-value">{{ $uniqueUsers }}</div>
                </div>
            </div>

            {{-- Score distribution + donut --}}
            <div class="tab-analytics-grid" style="margin-bottom: 20px;">
                <div class="card" style="margin-bottom:0;">
                    <div class="card-header">
                        <h4>{{ __('dashboard.score_distribution') }}</h4>
                        <span class="section-label label-likert">{{ __('dashboard.tab_persepsi') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="likertDistChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-bottom:0;">
                    <div class="card-header">
                        <h4>{{ __('dashboard.user_score_category') }}</h4>
                        <span class="section-label label-likert">{{ __('dashboard.tab_persepsi') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="likertCatChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- High/Medium/Low --}}
            <div class="metric-cards">
                <div class="metric-card high">
                    <div class="metric-label">{{ __('dashboard.high_score_label') }}</div>
                    <div class="metric-value">{{ $likertHighCount ?? 0 }}</div>
                    <div class="metric-info">{{ $likertHighPercentage ?? 0 }}{{ __('dashboard.percent_of_total') }}</div>
                </div>
                <div class="metric-card medium">
                    <div class="metric-label">{{ __('dashboard.medium_score_label') }}</div>
                    <div class="metric-value">{{ $likertMediumCount ?? 0 }}</div>
                    <div class="metric-info">{{ $likertMediumPercentage ?? 0 }}{{ __('dashboard.percent_of_total') }}</div>
                </div>
                <div class="metric-card low">
                    <div class="metric-label">{{ __('dashboard.low_score_label') }}</div>
                    <div class="metric-value">{{ $likertLowCount ?? 0 }}</div>
                    <div class="metric-info">{{ $likertLowPercentage ?? 0 }}{{ __('dashboard.percent_of_total') }}</div>
                </div>
            </div>

            {{-- Per-category --}}
            <div class="card" style="margin-bottom:0;">
                <div class="card-header">
                    <h4>{{ __('dashboard.detail_per_category') }}</h4>
                    <span class="section-label label-likert">{{ __('dashboard.tab_persepsi') }}</span>
                </div>
                <div class="card-body">
                    <div class="category-grid">
                        @php $categories = \App\Models\Category::all(); @endphp
                        @forelse($categories as $cat)
                            <div class="category-item">
                                <div class="category-name">{{ $cat->translation->name ?? $cat->name }}</div>
                                <div class="category-score">{{ $categoryLikertScores[$cat->name] ?? 0 }}%</div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $categoryLikertScores[$cat->name] ?? 0 }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p style="color: var(--gray-600); grid-column:1/-1; text-align:center; padding:20px;">
                                {{ __('dashboard.no_category') }}
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TAB: KOMPETENSI AKTUAL (MCQ) ===== --}}
        <div class="result-tab-panel" id="rtab-kompetensi">

            {{-- Summary --}}
            <div class="summary-stats">
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.average_score') }}</div>
                    <div class="summary-stat-value">{{ $mcqAvg }}%</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.highest_score') }}</div>
                    <div class="summary-stat-value">{{ $mcqHighest }}%</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.lowest_score') }}</div>
                    <div class="summary-stat-value">{{ $mcqLowest }}%</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-label">{{ __('dashboard.total_respondents') }}</div>
                    <div class="summary-stat-value">{{ $uniqueUsers }}</div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="tab-analytics-grid" style="margin-bottom: 20px;">
                <div class="card" style="margin-bottom:0;">
                    <div class="card-header">
                        <h4>{{ __('dashboard.score_distribution') }}</h4>
                        <span class="section-label label-mcq">{{ __('dashboard.tab_kompetensi') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="mcqDistChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-bottom:0;">
                    <div class="card-header">
                        <h4>{{ __('dashboard.user_score_category') }}</h4>
                        <span class="section-label label-mcq">{{ __('dashboard.tab_kompetensi') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="mcqCatChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- High/Medium/Low --}}
            <div class="metric-cards">
                <div class="metric-card high">
                    <div class="metric-label">{{ __('dashboard.high_score_label') }}</div>
                    <div class="metric-value">{{ $mcqHighCount ?? 0 }}</div>
                    <div class="metric-info">{{ $mcqHighPercentage ?? 0 }}{{ __('dashboard.percent_of_total') }}</div>
                </div>
                <div class="metric-card medium">
                    <div class="metric-label">{{ __('dashboard.medium_score_label') }}</div>
                    <div class="metric-value">{{ $mcqMediumCount ?? 0 }}</div>
                    <div class="metric-info">{{ $mcqMediumPercentage ?? 0 }}{{ __('dashboard.percent_of_total') }}</div>
                </div>
                <div class="metric-card low">
                    <div class="metric-label">{{ __('dashboard.low_score_label') }}</div>
                    <div class="metric-value">{{ $mcqLowCount ?? 0 }}</div>
                    <div class="metric-info">{{ $mcqLowPercentage ?? 0 }}{{ __('dashboard.percent_of_total') }}</div>
                </div>
            </div>

            {{-- Per-category --}}
            <div class="card" style="margin-bottom:0;">
                <div class="card-header">
                    <h4>{{ __('dashboard.detail_per_category') }}</h4>
                    <span class="section-label label-mcq">{{ __('dashboard.tab_kompetensi') }}</span>
                </div>
                <div class="card-body">
                    <div class="category-grid">
                        @forelse($categories as $cat)
                            <div class="category-item">
                                <div class="category-name">{{ $cat->translation->name ?? $cat->name }}</div>
                                <div class="category-score">{{ $categoryMcqScores[$cat->name] ?? 0 }}%</div>
                                <div class="category-stats">
                                    {{ __('dashboard.correct_from_total', [
                                        'correct' => $categoryDetails[$cat->name]['correct'] ?? 0,
                                        'total'   => $categoryDetails[$cat->name]['total'] ?? 0,
                                    ]) }}
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $categoryMcqScores[$cat->name] ?? 0 }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p style="color: var(--gray-600); grid-column:1/-1; text-align:center; padding:20px;">
                                {{ __('dashboard.no_category') }}
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Assessments --}}
    <div class="card">
        <div class="card-header">
            <h4>{{ __('dashboard.recent_assessments') }}</h4>
        </div>
        <div class="card-body">
            @if(count($recentAssessments ?? []) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('dashboard.table_user') }}</th>
                            <th>{{ __('dashboard.table_date') }}</th>
                            <th>
                                <span class="section-label label-likert" style="font-size:10px;">
                                    {{ __('dashboard.tab_persepsi') }}
                                </span>
                            </th>
                            <th>
                                <span class="section-label label-mcq" style="font-size:10px;">
                                    {{ __('dashboard.tab_kompetensi') }}
                                </span>
                            </th>
                            <th>{{ __('dashboard.table_total') }}</th>
                            <th>{{ __('dashboard.table_overall') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAssessments as $assessment)
                            @php
                                $overall   = $assessment['overall_score'] ?? 0;
                                $catLabel  = $overall >= 85 ? __('assessment.excellent') : ($overall >= 70 ? __('assessment.very_good') : __('assessment.need_improvement'));
                                $badgeCls  = $overall >= 85 ? 'badge-success' : ($overall >= 70 ? 'badge-warning' : 'badge-danger');
                            @endphp
                            <tr>
                                <td><strong>{{ $assessment['user_name'] ?? '-' }}</strong></td>
                                <td><small>{{ $assessment['date'] ?? '-' }}</small></td>
                                <td>
                                    <div style="display:grid; gap:4px;">
                                        <span class="badge badge-blue">
                                            {{ $assessment['likert_correct'] ?? 0 }}/{{ $assessment['likert_total'] ?? 0 }}
                                        </span>
                                        <small style="color:var(--gray-600);">{{ $assessment['likert_score'] ?? 0 }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:grid; gap:4px;">
                                        <span class="badge badge-success">
                                            {{ $assessment['mcq_correct'] ?? 0 }}/{{ $assessment['mcq_total'] ?? 0 }}
                                        </span>
                                        <small style="color:var(--gray-600);">{{ $assessment['mcq_score'] ?? 0 }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-purple">{{ $assessment['total_questions'] ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="score-bar">
                                        <div class="score-bar-fill">
                                            <div class="progress-fill" style="width: {{ $overall }}%;"></div>
                                        </div>
                                        <div class="score-bar-value">{{ $overall }}%</div>
                                    </div>
                                    <span class="badge {{ $badgeCls }}" style="margin-top:4px;">{{ $catLabel }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align:center; color:var(--gray-600); padding:20px;">
                    {{ __('dashboard.no_assessment_data') }}
                </p>
            @endif
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="card">
        <div class="card-body">
            <h4 style="margin-top:0; margin-bottom:12px;">{{ __('dashboard.quick_links') }}</h4>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="{{ route('user.create') }}"           class="btn-primary">{{ __('dashboard.add_user') }}</a>
                <a href="{{ route('modul.create') }}"          class="btn-primary">{{ __('dashboard.add_module') }}</a>
                <a href="{{ route('answer-template.index') }}" class="btn-primary">{{ __('dashboard.answer_template') }}</a>
                <a href="{{ route('question.index') }}"        class="btn-primary">{{ __('dashboard.question') }}</a>
                <a href="{{ route('category.index') }}"        class="btn-primary">{{ __('dashboard.category') }}</a>
                <a href="{{ route('pengukuran.hasil') }}"      class="btn-primary">{{ __('dashboard.view_all_results') }}</a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ── Tab switching ──
    document.querySelectorAll('.result-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.rtab;
            document.querySelectorAll('.result-tab-btn').forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            document.querySelectorAll('.result-tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('rtab-' + target)?.classList.add('active');
        });
    });

    // ── Shared colours ──
    const barColors = [
        'rgba(239,68,68,.8)', 'rgba(245,158,11,.8)',
        'rgba(251,191,36,.8)', 'rgba(34,197,94,.8)', 'rgba(16,185,129,.8)'
    ];
    const barBorders = [
        'rgba(239,68,68,1)', 'rgba(245,158,11,1)',
        'rgba(251,191,36,1)', 'rgba(34,197,94,1)', 'rgba(16,185,129,1)'
    ];
    const donutColors  = ['rgba(16,185,129,.8)', 'rgba(245,158,11,.8)', 'rgba(239,68,68,.8)'];
    const donutBorders = ['rgba(16,185,129,1)',   'rgba(245,158,11,1)',  'rgba(239,68,68,1)'];
    const chartLabels  = {
        high:   '{{ __("dashboard.high_score_label") }}',
        medium: '{{ __("dashboard.medium_score_label") }}',
        low:    '{{ __("dashboard.low_score_label") }}',
        users:  '{{ __("dashboard.total_users") }}',
    };

    function makeBarChart(id, data) {
        const ctx = document.getElementById(id)?.getContext('2d');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['0-20','21-40','41-60','61-80','81-100'],
                datasets: [{ label: chartLabels.users, data, backgroundColor: barColors, borderColor: barBorders, borderWidth: 1, borderRadius: 4 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color:'rgba(0,0,0,.05)' } }, x: { grid: { display:false } } } }
        });
    }

    function makeDonutChart(id, data) {
        const ctx = document.getElementById(id)?.getContext('2d');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [chartLabels.high, chartLabels.medium, chartLabels.low],
                datasets: [{ data, backgroundColor: donutColors, borderColor: donutBorders, borderWidth: 2 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position:'bottom', labels: { padding:15, font: { size:12 } } } } }
        });
    }

    // Likert charts
    makeBarChart('likertDistChart', [
        {{ $likertScoreRanges['0-20']   ?? 0 }},
        {{ $likertScoreRanges['21-40']  ?? 0 }},
        {{ $likertScoreRanges['41-60']  ?? 0 }},
        {{ $likertScoreRanges['61-80']  ?? 0 }},
        {{ $likertScoreRanges['81-100'] ?? 0 }}
    ]);
    makeDonutChart('likertCatChart', [
        {{ $likertHighCount ?? 0 }},
        {{ $likertMediumCount ?? 0 }},
        {{ $likertLowCount ?? 0 }}
    ]);

    // MCQ charts
    makeBarChart('mcqDistChart', [
        {{ $mcqScoreRanges['0-20']   ?? 0 }},
        {{ $mcqScoreRanges['21-40']  ?? 0 }},
        {{ $mcqScoreRanges['41-60']  ?? 0 }},
        {{ $mcqScoreRanges['61-80']  ?? 0 }},
        {{ $mcqScoreRanges['81-100'] ?? 0 }}
    ]);
    makeDonutChart('mcqCatChart', [
        {{ $mcqHighCount ?? 0 }},
        {{ $mcqMediumCount ?? 0 }},
        {{ $mcqLowCount ?? 0 }}
    ]);
</script>
@endpush