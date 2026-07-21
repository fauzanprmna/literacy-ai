@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Riwayat Asesmen')
@section('header', 'Riwayat Asesmen')

@push('head')
    <style>
        .history-board {
            display: grid;
            gap: 24px;
        }

        .user-carousel-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .carousel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .carousel-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .carousel-controls {
            display: flex;
            gap: 8px;
        }

        .carousel-btn {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            background: var(--white);
            color: var(--gray-600);
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: all .2s ease;
        }

        .carousel-btn:hover {
            background: var(--green-50);
            border-color: var(--green-600);
            color: var(--green-600);
        }

        .user-carousel {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: minmax(280px, 1fr);
            gap: 16px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 8px;
        }

        .user-carousel::-webkit-scrollbar {
            height: 8px;
        }

        .user-carousel::-webkit-scrollbar-thumb {
            background: rgba(36, 59, 48, .35);
            border-radius: 999px;
        }

        .user-card {
            scroll-snap-align: start;
            background: linear-gradient(135deg, var(--green-50) 0%, var(--green-100) 100%);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 20px;
            cursor: pointer;
            transition: all .2s ease;
            display: grid;
            gap: 12px;
        }

        .user-card:hover {
            border-color: var(--green-600);
            box-shadow: var(--shadow-md);
        }

        .user-card.active {
            border-color: var(--green-600);
            background: linear-gradient(135deg, var(--green-100) 0%, var(--green-200) 100%);
            box-shadow: 0 0 0 3px rgba(42, 143, 109, 0.1);
        }

        .user-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .user-info {
            display: grid;
            gap: 6px;
            font-size: 12px;
            color: var(--gray-600);
        }

        .user-info-item {
            display: flex;
            justify-content: space-between;
        }

        .user-stats-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: var(--green-50);
            border-radius: var(--radius-md);
            padding: 16px;
            display: grid;
            gap: 6px;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--gray-600);
            letter-spacing: .08em;
            font-weight: 700;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--green-700);
        }

        .attempts-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .attempts-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 20px;
        }

        .attempt-item {
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            padding: 20px;
            display: grid;
            gap: 16px;
            transition: all .2s ease;
            margin-bottom: 16px;
        }

        .attempt-item:hover {
            border-color: var(--green-600);
            box-shadow: var(--shadow-md);
        }

        .attempt-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
            align-items: start;
        }

        .attempt-meta {
            display: grid;
            gap: 12px;
        }

        .attempt-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            font-size: 14px;
        }

        .attempt-label {
            color: var(--gray-600);
            min-width: 100px;
            font-weight: 600;
        }

        .attempt-value {
            color: var(--gray-800);
            font-weight: 700;
        }

        .attempt-badge {
            display: inline-flex;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--white);
            background: var(--green-600);
        }

        .attempt-score {
            display: grid;
            gap: 6px;
            text-align: right;
        }

        .attempt-score-number {
            font-size: 36px;
            font-weight: 800;
            color: var(--green-700);
        }

        .attempt-score-label {
            font-size: 11px;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .attempt-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }

        .breakdown-item {
            background: var(--gray-50);
            border-radius: var(--radius-md);
            padding: 12px;
            text-align: center;
        }

        .breakdown-label {
            font-size: 11px;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .breakdown-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--green-700);
        }

        .attempt-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
        }

        .category-pill {
            background: var(--green-50);
            border-radius: var(--radius-sm);
            padding: 10px;
            text-align: center;
            border: 1px solid var(--gray-100);
        }

        .category-name {
            font-size: 10px;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .category-score {
            font-size: 16px;
            font-weight: 700;
            color: var(--green-700);
        }

        .attempt-action {
            display: flex;
            justify-content: flex-end;
        }

        .attempt-action a {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            background: var(--green-600);
            color: var(--white);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s ease;
        }

        .attempt-action a:hover {
            background: var(--green-700);
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--gray-800);
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 20px;
        }

        .empty-state a {
            display: inline-flex;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            background: var(--green-600);
            color: var(--white);
            text-decoration: none;
            font-weight: 700;
        }

        .user-carousel-single {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
        }

        .active-user-card {
            width: 100%;
            max-width: 500px;
            background: linear-gradient(135deg,
                    var(--green-50) 0%,
                    var(--green-100) 100%);
            border: 2px solid var(--green-200);
            border-radius: var(--radius-lg);
            padding: 24px;
            text-align: center;
        }

        .active-user-name {
            font-size: 22px;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 16px;
        }

        .active-user-info {
            display: grid;
            gap: 10px;
            color: var(--gray-600);
            font-size: 14px;
        }

        .active-user-info strong {
            color: var(--gray-800);
        }

        .carousel-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: var(--green-600);
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: .2s;
        }

        .carousel-btn:hover {
            transform: scale(1.05);
            background: var(--green-700);
        }

        .user-attempt-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 12px;
            padding: 8px 16px;
            border-radius: 999px;
            background: var(--green-600);
            color: white;
            font-size: 13px;
            font-weight: 700;
        }

        .delete-action {
            display: flex;
            justify-content: flex-end;
        }

        .delete-action a {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            background: var(--red-600);
            color: var(--white);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s ease;
        }

        .delete-btn {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            background: var(--red-600);
            color: var(--white);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s ease;
            cursor: pointer;
        }



        @media (max-width: 768px) {
            .attempt-header {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .attempt-score {
                text-align: left;
            }
        }
    </style>
@endpush

@section('content')
    <div class="history-board">

        {{-- ===== USER CAROUSEL (ADMIN ONLY) ===== --}}
        @if (Auth::user()->role === 'admin' && $usersWithAssessments->isNotEmpty())
            <div class="user-carousel-section">

                <div class="carousel-header">
                    <div class="carousel-title">
                        {{ __('messages.select_user') }}
                    </div>
                </div>

                <div class="user-carousel-single">

                    <button type="button" class="carousel-btn" id="carouselPrev">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <div class="active-user-card">

                        <div class="active-user-name">
                            {{ $selectedUser->name }}
                        </div>

                        <div class="active-user-info">
                            <div>
                                <strong>{{ __('messages.email') }}:</strong>
                                {{ $selectedUser->email }}
                            </div>

                            <div>
                                <strong>{{ __('messages.role') }}:</strong>
                                {{ ucfirst($selectedUser->role) }}
                            </div>
                        </div>

                        <div class="user-attempt-badge">
                            {{ $selectedUser->answers()->distinct('attempt_id')->count() }}
                            {{ __('messages.attempts') }}
                        </div>

                    </div>

                    <button type="button" class="carousel-btn" id="carouselNext">
                        <i class="bi bi-chevron-right"></i>
                    </button>

                </div>
            </div>
        @endif

        {{-- ===== USER STATS (ADMIN ONLY) ===== --}}
        @if (Auth::user()->role === 'admin' && $selectedUser && !empty($userStats))
            <div class="user-stats-section">
                <div style="margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--gray-800);">
                        {{ __('messages.statistics_for', ['name' => $selectedUser->name]) }}
                    </h3>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">{{ __('messages.total_attempts') }}</div>
                        <div class="stat-value">{{ $userStats['total_attempts'] ?? 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">{{ __('messages.average_score') }}</div>
                        <div class="stat-value">{{ $userStats['average_score'] ?? 0 }}%</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">{{ __('messages.highest_score') }}</div>
                        <div class="stat-value">{{ $userStats['highest_score'] ?? 0 }}%</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">{{ __('messages.lowest_score') }}</div>
                        <div class="stat-value">{{ $userStats['lowest_score'] ?? 0 }}%</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== ATTEMPTS LIST ===== --}}
        <div class="attempts-section">
            <h3 class="attempts-title">
                {{ Auth::user()->role === 'admin'
                    ? __('messages.assessment_history_admin', ['name' => $selectedUser?->name ?? 'User'])
                    : __('messages.assessment_history_user') }}
            </h3>

            @forelse ($attempts as $attempt)
                <article class="attempt-item">
                    <div class="attempt-header">
                        <div class="attempt-meta">
                            <div class="attempt-row">
                                <span class="attempt-label">{{ __('messages.date') }}:</span>
                                <span class="attempt-value">
                                    {{ $attempt['date']->locale(app()->getLocale())->translatedFormat('d F Y, H:i') }}
                                </span>
                            </div>
                            <div class="attempt-row">
                                <span class="attempt-label">{{ __('messages.duration') }}:</span>
                                <span class="attempt-value">{{ $attempt['duration'] ?? '-' }}</span>
                            </div>
                            <div class="attempt-row">
                                <span class="attempt-label">{{ __('messages.questions') }}:</span>
                                <span class="attempt-value">
                                    {{ $attempt['total_questions'] }} {{ __('messages.questions_count') }}
                                </span>
                            </div>
                            <div class="attempt-row">
                                <span class="attempt-label">{{ __('messages.status') }}:</span>
                                <span class="attempt-badge">
                                    {{ $attempt['total_questions'] > 0 ? __('messages.done') : __('messages.not_done') }}
                                </span>
                            </div>
                        </div>

                        <div class="attempt-score">
                            <div class="attempt-score-number">{{ $attempt['score'] }}</div>
                            <div class="attempt-score-label">{{ __('assessment.score_label') }}</div>
                            <span class="attempt-badge" style="justify-content: center;">
                                {{ $attempt['category'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Breakdown Likert vs MCQ --}}
                    <div class="attempt-breakdown">
                        <div class="breakdown-item">
                            <div class="breakdown-label">{{ __('assessment.likert_tab') }}</div>
                            <div class="breakdown-value">{{ $attempt['likert_count'] }}</div>
                        </div>
                        <div class="breakdown-item">
                            <div class="breakdown-label">{{ __('assessment.mcq_tab') }}</div>
                            <div class="breakdown-value">{{ $attempt['mcq_count'] }}</div>
                        </div>
                        <div class="breakdown-item">
                            <div class="breakdown-label">{{ __('messages.correct_answers') }}</div>
                            <div class="breakdown-value">{{ $attempt['correct_answers'] }}</div>
                        </div>
                    </div>

                    {{-- Category Scores --}}
                    @if (count($attempt['dimension_scores']) > 0)
                        <div>
                            <div style="font-size: 12px; color: var(--gray-600); margin-bottom: 10px; font-weight: 600;">
                                {{ __('messages.score_per_category') }}:
                            </div>
                            <div class="attempt-categories">
                                @foreach ($attempt['dimension_scores'] as $category => $score)
                                    <div class="category-pill">
                                        <div class="category-name">{{ Str::limit($category, 12) }}</div>
                                        <div class="category-score">{{ $score }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (Auth::user()->role == 'admin')
                        <div class="delete-action" style="margin-top: 12px;">
                            <form action="{{ route('assessments.delete', ['sessionKey' => $attempt['attempt_id'], 'userId' => $attempt['user_id']]) }}"
                                method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">
                                    <i class="bi bi-trash"></i>
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="attempt-action">
                        <a
                            href="{{ route('assessments.detail', ['sessionKey' => $attempt['attempt_id'], 'userId' => $attempt['user_id']]) }}">
                            <i class="bi bi-eye"></i>
                            {{ __('messages.view_detail') }}
                        </a>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <h3>{{ __('messages.no_history') }}</h3>
                    <p>
                        {{ Auth::user()->role === 'admin' ? __('messages.no_history_admin') : __('messages.no_history_user') }}
                    </p>
                    @if (Auth::user()->role !== 'admin')
                        <a href="{{ route('pengukuran.index') }}">
                            <i class="bi bi-play-fill"></i>
                            {{ __('messages.start_measurement') }}
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script>
            @if (Auth::user()->role === 'admin')

                const users = [
                    @foreach ($usersWithAssessments as $user)
                        {
                            id: {{ $user->id }},
                            url: "{{ route('assessments.history', ['user_id' => $user->id]) }}"
                        },
                    @endforeach
                ];

                const currentUserId = {{ $selectedUser->id }};

                let currentIndex = users.findIndex(user => user.id === currentUserId);

                document.getElementById('carouselPrev')?.addEventListener('click', function() {
                    const prevIndex = currentIndex === 0 ? users.length - 1 : currentIndex - 1;
                    window.location.href = users[prevIndex].url;
                });

                document.getElementById('carouselNext')?.addEventListener('click', function() {
                    const nextIndex = currentIndex === users.length - 1 ? 0 : currentIndex + 1;
                    window.location.href = users[nextIndex].url;
                });
            @endif
        </script>
    @endpush
@endsection
