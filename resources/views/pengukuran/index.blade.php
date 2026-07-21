@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Asesmen Literasi AI')
@section('header', 'Asesmen Literasi AI')

@push('head')
    <style>
        .intro-wrapper {
            max-width: 780px;
            margin: 0 auto;
        }

        .hero-card {
            background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
            border-radius: 12px;
            padding: 36px 40px;
            color: #fff;
            text-align: center;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        }

        .hero-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
        }

        .hero-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .hero-desc {
            font-size: 14px;
            opacity: .8;
            line-height: 1.6;
        }

        .info-chips {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .info-chip {
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 20px;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ─── SECTION CARD ─────────────────────────── */
        .section-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .section-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
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

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .section-body {
            padding: 20px;
        }

        /* ─── CATEGORIES GRID ─────────────────────────── */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .cat-box {
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            padding: 14px;
            transition: all .2s;
        }

        .cat-box:hover {
            border-color: var(--green-300);
            background: var(--green-50);
            box-shadow: 0 2px 8px rgba(26, 92, 64, .08);
        }

        .cat-box-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cat-number {
            width: 20px;
            height: 20px;
            background: var(--green-50);
            color: var(--green-600);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
        }

        .cat-box-desc {
            font-size: 11px;
            color: var(--gray-600);
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .cat-count {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--gray-50);
            border: 1px solid var(--gray-100);
            border-radius: 16px;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: 600;
            color: var(--gray-600);
        }

        /* ─── INSTRUCTIONS ─────────────────────────── */
        .instructions-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .instructions-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-100);
            font-size: 13px;
            color: var(--gray-700);
        }

        .instructions-list li:last-child {
            border-bottom: none;
        }

        .instructions-list i {
            color: var(--green-600);
            font-size: 14px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* ─── ACTION BAR ─────────────────────────── */
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 8px;
            padding-top: 12px;
            flex-wrap: wrap;
        }

        .action-bar-item {
            min-width: 180px;
        }

        .consent-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1 1 240px;
            min-width: 220px;
        }

        .consent-checkbox input {
            width: 18px;
            height: 18px;
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

        .btn-start {
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
            flex-shrink: 0;
            cursor: not-allowed;
            opacity: 0.65;
        }

        .btn-start:not(:disabled) {
            cursor: pointer;
            opacity: 1;
        }

        .btn-start:hover {
            background: var(--green-600);
            transform: translateY(-1px);
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

        @media (max-width: 768px) {
            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .action-bar-item,
            .btn-back,
            .consent-checkbox,
            .btn-start {
                width: 100%;
            }

            .consent-checkbox {
                justify-content: flex-start;
                gap: 8px;
            }

            .btn-start {
                justify-content: center;
            }

            .privacy-section {
                padding: 32px 18px;
            }

            .hero-card {
                padding: 24px 20px;
            }

            .hero-title {
                font-size: 20px;
            }

            .info-chips {
                justify-content: stretch;
            }
        }

        @media (max-width: 640px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }

            .privacy-section {
                padding: 24px 16px;
            }

            .privacy-content h3 {
                font-size: 18px;
            }

            .privacy-content p,
            .privacy-list {
                font-size: 12px;
            }

            .btn-start {
                padding: 12px 18px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="intro-wrapper">

        <!-- Hero Card -->
        <div class="hero-card">
            <div class="hero-icon"><i class="bi bi-mortarboard"></i></div>
            <h2 class="hero-title">{{ __('assessment.dashboard_start_assessment') }}</h2>
            <p class="hero-desc">{{ __('assessment.dashboard_measure_skills') }}</p>
            <div class="info-chips">
                <div class="info-chip"><i class="bi bi-question-circle"></i> {{ $totalQuestions }}
                    {{ __('assessment.questions') }}</div>
                <div class="info-chip"><i class="bi bi-grid-1x2"></i> {{ $totalCategories }}
                    {{ __('assessment.categories') }}</div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon"><i class="bi bi-grid"></i></div>
                <span class="section-title">{{ __('assessment.categories') }}</span>
            </div>
            <div class="section-body">
                <div class="categories-grid">
                    @forelse($categories as $i => $category)
                        <div class="cat-box">
                            <p class="cat-box-name">
                                <span class="cat-number">{{ $i + 1 }}</span>
                                {{ $category->translation->name ?? $category->name }}
                            </p>
                            <p class="cat-box-desc">
                                {{ $category->translation->description ?? __('assessment.dashboard_no_description') }}</p>
                            <span class="cat-count">
                                <i class="bi bi-question-circle"></i>
                                {{ $category->questions_count ?? 0 }} {{ __('assessment.questions') }}
                            </span>
                        </div>
                    @empty
                        <div
                            style="grid-column: 1/-1; text-align: center; color: var(--gray-600); font-size: 13px; padding: 20px 0;">
                            {{ __('assessment.dashboard_no_categories') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Instructions Section -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon"><i class="bi bi-info-circle"></i></div>
                <span class="section-title">{{ __('assessment.instructions') }}</span>
            </div>
            <div class="section-body">
                <ul class="instructions-list">
                    @foreach (__('assessment.instructions_text') as $instruction)
                        <li><i class="bi bi-check-circle"></i> <span>{{ $instruction }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Privacy Disclaimer -->
        <section class="privacy-section">
            <div class="privacy-inner">
                <div class="privacy-icon"><i class="bi bi-exclamation-circle"></i></div>

                <div class="privacy-content">
                    <h3><i class="bi bi-shield-lock"></i> {{ __('assessment.privacy_title') }}</h3>

                    <p>
                        <strong>{{ __('assessment.privacy_subheading') }}</strong>
                    </p>

                    <p>
                        {{ __('assessment.privacy_paragraph') }}
                    </p>

                    <ul class="privacy-list">
                        @foreach (__('assessment.privacy_bullets') as $bullet)
                            <li>{{ $bullet }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <!-- Action Bar -->
        <form method="POST" action="{{ route('pengukuran.start') }}">
            @csrf
            <div class="action-bar">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> {{ __('messages.back') }}
                </a>

                <label class="consent-checkbox">
                    <input type="checkbox" id="consent" name="consent" value="1" required />
                    <span style="font-size:13px; color:var(--gray-700);">{{ __('assessment.consent_label') }}</span>
                </label>

                <button type="submit" id="startBtn" class="btn-start" disabled>
                    <i class="bi bi-play-fill"></i> {{ __('assessment.start_assessment') }}
                </button>
            </div>
        </form>

        @push('scripts')
            <script>
                (function() {
                    const consent = document.getElementById('consent');
                    const startBtn = document.getElementById('startBtn');
                    if (consent && startBtn) {
                        consent.addEventListener('change', function() {
                            startBtn.disabled = !this.checked;
                        });
                    }
                })();
            </script>
        @endpush

    </div>
@endsection
