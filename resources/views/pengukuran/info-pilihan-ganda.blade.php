
@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('assessment.mc_title'))
@section('header', __('assessment.mc_header'))

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

    .alert-success-green {
        background: var(--green-50);
        border: 1px solid var(--green-100);
        border-left: 3px solid var(--green-500);
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-800);
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 20px;
    }

    .alert-success-green i {
        color: var(--green-600);
        font-size: 16px;
        flex-shrink: 0;
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

    /* Example Question */
    .mc-example {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 18px;
    }

    .mc-example-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--green-600);
        margin-bottom: 10px;
    }

    .mc-question {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 14px;
    }

    .mc-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 6px;
        margin-bottom: 6px;
        font-size: 13px;
        color: var(--gray-700);
    }

    .mc-option.correct {
        background: var(--green-50);
        border: 1px solid var(--green-200);
        color: var(--green-800);
        font-weight: 600;
    }

    .mc-radio {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid var(--gray-300);
        flex-shrink: 0;
    }

    .mc-option.correct .mc-radio {
        border-color: var(--green-600);
        background: var(--green-600);
        box-shadow: inset 0 0 0 3px var(--green-50);
    }

    /* Dimensions */
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

    .tip-box {
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        color: #92400e;
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 16px;
    }

    .tip-box i {
        color: #f59e0b;
        font-size: 15px;
        margin-top: 1px;
    }

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
        .step-header {
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }

        .dimensions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="info-wrapper">

    <div class="step-header">
        <div class="step-icon">
            <i class="bi bi-list-check"></i>
        </div>
        <div class="step-text">
            <h2>{{ __('assessment.mc_header') }}</h2>
            <p>{{ __('assessment.mc_part') }}</p>
        </div>
    </div>

    <div class="alert-success-green">
        <i class="bi bi-check-circle-fill"></i>
        <span>
            <strong>{{ __('assessment.mc_completed_likert') }}</strong>
        </span>
    </div>

    <div class="info-card">
        <div class="info-card-header">
            <span class="step-number">1</span>
            <span class="info-card-title">{{ __('assessment.mc_rules_guidelines') }}</span>
        </div>

        <div class="info-card-body">
            <ul class="rules-list">
                <li><i class="bi bi-check-circle"></i> {{ __('assessment.mc_single_choice') }}</li>
                <li><i class="bi bi-check-circle"></i> {{ __('assessment.mc_read_carefully') }}</li>
                <li><i class="bi bi-check-circle"></i> {{ __('assessment.mc_answer_all') }}</li>
                <li><i class="bi bi-check-circle"></i> {{ __('assessment.mc_take_time') }}</li>
                <li><i class="bi bi-check-circle"></i> {{ __('assessment.mc_no_modifications') }}</li>
            </ul>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header">
            <span class="step-number">2</span>
            <span class="info-card-title">{{ __('assessment.mc_question_format') }}</span>
        </div>

        <div class="info-card-body">
            <div class="mc-example">
                <div class="mc-example-label">
                    {{ __('assessment.mc_example') }}
                </div>

                <div class="mc-question">
                    What is the primary advantage of AI in business?
                </div>

                <div class="mc-option">
                    <div class="mc-radio"></div>
                    Increased manual labor
                </div>

                <div class="mc-option correct">
                    <div class="mc-radio"></div>
                    Improved efficiency and automation
                </div>

                <div class="mc-option">
                    <div class="mc-radio"></div>
                    Higher operational costs
                </div>

                <div class="mc-option">
                    <div class="mc-radio"></div>
                    Reduced decision-making capacity
                </div>
            </div>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header">
            <span class="step-number">3</span>
            <span class="info-card-title">{{ __('assessment.mc_dimensions') }}</span>
        </div>

        <div class="info-card-body">
            <p style="font-size:13px;color:var(--gray-600);margin-bottom:14px;">
                {{ __('assessment.mc_dimensions_desc') }}
            </p>

            <div class="dimensions-grid">
                @foreach ($categories as $index)
                    <div class="dimension-item">
                        <span class="dimension-badge">
                            {{ $loop->iteration }}
                        </span>
                        {{ $index->translation->name ?? $index->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="tip-box">
        <i class="bi bi-lightbulb-fill"></i>
        <span>
            <strong>{{ __('assessment.info') }}:</strong>
            {{ __('assessment.mc_tip') }}
        </span>
    </div>

    <div class="action-bar">
        <a href="{{ route('pengukuran.kuesioner.likert', ['page' => 1]) }}"
           class="btn-back">
            <i class="bi bi-arrow-left"></i>
            {{ __('assessment.mc_back_to_likert') }}
        </a>

        <a href="{{ route('pengukuran.kuesioner.multiple_choice') }}"
           class="btn-next">
            {{ __('assessment.mc_start') }}
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

</div>
@endsection

