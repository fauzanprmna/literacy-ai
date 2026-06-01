

@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Info Likert Scale')
@section('header', 'Penjelasan Likert Scale')

@push('head')
<style>
    .info-wrapper {
        max-width: 780px;
        margin: 0 auto;
    }

    .step-header {
        background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
        border-radius: 12px;
        padding: 28px 32px;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .step-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .step-text h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .step-text p {
        font-size: 13px;
        opacity: .8;
    }

    .info-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .info-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .step-number {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--green-700);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-card-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--gray-800);
    }

    .info-card-body {
        padding: 18px 20px;
    }

    /* ─── SCORING TABLE ─────────────────────────── */
    .score-table {
        width: 100%;
        border-collapse: collapse;
    }

    .score-table th {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--gray-600);
        padding: 0 12px 10px;
        text-align: left;
    }

    .score-table td {
        padding: 10px 12px;
        border-top: 1px solid var(--gray-100);
        font-size: 13px;
    }

    .score-table tr:first-child td {
        border-top: none;
    }

    .score-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 700;
    }

    .sn1 { background: #fee2e2; color: #991b1b; }
    .sn2 { background: #fef3c7; color: #92400e; }
    .sn3 { background: var(--gray-100); color: var(--gray-600); }
    .sn4 { background: #cffafe; color: #155e75; }
    .sn5 { background: #d1fae5; color: #065f46; }

    .score-weight {
        font-weight: 700;
        color: var(--gray-800);
    }

    /* ─── RULES LIST ─────────────────────────── */
    .rules-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .rules-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--gray-100);
        font-size: 13px;
        color: var(--gray-700);
    }

    .rules-list li:last-child {
        border-bottom: none;
    }

    .rules-list i {
        color: var(--green-600);
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ─── DIMENSIONS ─────────────────────────── */
    .dimensions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .dimension-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: var(--gray-800);
    }

    .dimension-badge {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--green-700);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ─── ACTION BAR ─────────────────────────── */
    .action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 12px;
        padding-top: 12px;
    }

    .btn-back {
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid var(--gray-200);
        background: var(--white);
        color: var(--gray-600);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all .2s;
    }

    .btn-back:hover {
        background: var(--gray-100);
        color: var(--gray-800);
    }

    .btn-next {
        padding: 11px 24px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        background: var(--green-700);
        color: #fff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all .2s;
    }

    .btn-next:hover {
        background: var(--green-600);
        transform: translateY(-1px);
    }

    @media (max-width: 640px) {
        .step-header { flex-direction: column; text-align: center; gap: 12px; }
        .dimensions-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="info-wrapper">

    <!-- Hero Header -->
    <div class="step-header">
        <div class="step-icon"><i class="bi bi-sliders"></i></div>
        <div class="step-text">
            <h2>{{ __('assessment.likert_header') }}</h2>
            <p>{{ __('assessment.likert_instructions') }}</p>
        </div>
    </div>

    <!-- Step 1: Scoring Guide -->
    <div class="info-card">
        <div class="info-card-header">
            <span class="step-number">1</span>
            <span class="info-card-title">{{ __('assessment.likert_scoring_guide') }}</span>
        </div>
        <div class="info-card-body">
            <table class="score-table">
                <thead>
                    <tr>
                        <th>{{ __('assessment.likert_score') }}</th>
                        <th>{{ __('assessment.likert_description') }}</th>
                        <th>{{ __('assessment.likert_point_value') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="score-num sn1">1</span></td>
                        <td>{{ __('assessment.likert_strongly_disagree') }}</td>
                        <td><span class="score-weight">1 {{ __('assessment.value') }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="score-num sn2">2</span></td>
                        <td>{{ __('assessment.likert_disagree') }}</td>
                        <td><span class="score-weight">2 {{ __('assessment.value') }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="score-num sn3">3</span></td>
                        <td>{{ __('assessment.likert_neutral') }}</td>
                        <td><span class="score-weight">3 {{ __('assessment.value') }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="score-num sn4">4</span></td>
                        <td>{{ __('assessment.likert_agree') }}</td>
                        <td><span class="score-weight">4 {{ __('assessment.value') }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="score-num sn5">5</span></td>
                        <td>{{ __('assessment.likert_strongly_agree') }}</td>
                        <td><span class="score-weight">5 {{ __('assessment.value') }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 2: Rules -->
    <div class="info-card">
        <div class="info-card-header">
            <span class="step-number">2</span>
            <span class="info-card-title">{{ __('assessment.likert_rules_guidelines') }}</span>
        </div>
        <div class="info-card-body">
            <ul class="rules-list">
                <li><i class="bi bi-check-circle"></i> <span>{{ __('assessment.likert_answer_all') }}</span></li>
                <li><i class="bi bi-check-circle"></i> <span>{{ __('assessment.likert_be_honest') }}</span></li>
                <li><i class="bi bi-check-circle"></i> <span>{{ __('assessment.likert_take_time') }}</span></li>
                <li><i class="bi bi-check-circle"></i> <span>{{ __('assessment.likert_one_answer') }}</span></li>
                <li><i class="bi bi-check-circle"></i> <span>{{ __('assessment.likert_no_going_back') }}</span></li>
            </ul>
        </div>
    </div>

    <!-- Step 3: Dimensions -->
    <div class="info-card">
        <div class="info-card-header">
            <span class="step-number">3</span>
            <span class="info-card-title">{{ __('assessment.likert_dimensions') }}</span>
        </div>
        <div class="info-card-body">
            <p style="font-size: 13px; color: var(--gray-600); margin-bottom: 14px;">
                {{ __('assessment.likert_dimensions_desc') }}
            </p>
            <div class="dimensions-grid">
                @foreach ($categories as $index)
                    <div class="dimension-item">
                        <span class="dimension-badge">{{ $loop->iteration }}</span>
                        {{ $index->translation->name ?? $index->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <a href="{{ route('pengukuran.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back') }}
        </a>
        <a href="{{ route('pengukuran.kuesioner.likert') }}" class="btn-next">
            {{ __('assessment.likert_start') }} <i class="bi bi-arrow-right"></i>
        </a>
    </div>

</div>
@endsection