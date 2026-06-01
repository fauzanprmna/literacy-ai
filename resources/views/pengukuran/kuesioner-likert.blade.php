@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Likert Assessment')
@section('header', 'Likert Assessment')

@push('head')
<style>
    .quiz-wrapper {
        max-width: 780px;
        margin: 0 auto;
    }

    /* ─── PROGRESS ─────────────────────────── */
    .progress-section {
        margin-bottom: 20px;
    }

    .progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .progress-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-800);
    }

    .progress-badge {
        background: var(--green-700);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 16px;
    }

    .progress-bar {
        height: 6px;
        background: var(--gray-200);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--green-700), var(--green-600));
        border-radius: 10px;
        transition: width .4s ease;
    }

    /* ─── CATEGORY HEADER ─────────────────────────── */
    .category-header {
        background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
        border-radius: 8px;
        padding: 18px 20px;
        color: #fff;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }

    .category-icon {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        background: rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .category-name {
        font-size: 16px;
        font-weight: 700;
    }

    /* ─── QUESTION CARD ─────────────────────────── */
    .question-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        margin-bottom: 14px;
        overflow: hidden;
        transition: all .2s;
    }

    .question-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .question-card.answered {
        border-color: var(--green-300);
        background: #fafbff;
    }

    .question-text {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .question-number {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--green-700);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .question-content {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-800);
        line-height: 1.5;
    }

    /* ─── LIKERT OPTIONS ─────────────────────────── */
    .likert-options {
        display: flex;
        padding: 14px 20px;
        gap: 6px;
    }

    .likert-option {
        flex: 1;
        position: relative;
    }

    .likert-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
        margin: 0;
        pointer-events: none;
    }

    .likert-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 10px 6px;
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        cursor: pointer;
        font-size: 10px;
        font-weight: 600;
        color: var(--gray-600);
        transition: all .15s;
        line-height: 1.2;
    }

    .likert-label:hover {
        border-color: var(--green-300);
        background: var(--green-50);
        color: var(--green-700);
    }

    .likert-number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        transition: all .15s;
    }

    .likert-option:nth-child(1) .likert-number { background: #fee2e2; color: #991b1b; }
    .likert-option:nth-child(2) .likert-number { background: #fef3c7; color: #92400e; }
    .likert-option:nth-child(3) .likert-number { background: var(--gray-100); color: var(--gray-600); }
    .likert-option:nth-child(4) .likert-number { background: #cffafe; color: #155e75; }
    .likert-option:nth-child(5) .likert-number { background: #d1fae5; color: #065f46; }

    .likert-option input:checked + .likert-label {
        border-color: var(--green-600);
        background: var(--green-50);
        color: var(--green-800);
        font-weight: 700;
    }

    .likert-option input:checked + .likert-label .likert-number {
        background: var(--green-700) !important;
        color: #fff !important;
    }

    /* ─── ACTION BAR ─────────────────────────── */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 12px;
        padding-top: 16px;
        border-top: 1px solid var(--gray-200);
    }

    .btn-back {
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid var(--gray-200);
        background: var(--white);
        color: var(--gray-600);
        cursor: pointer;
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
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all .2s;
    }

    .btn-next:hover {
        background: var(--green-600);
        transform: translateY(-1px);
    }

    .btn-finish {
        padding: 11px 24px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        background: var(--green-600);
        color: #fff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all .2s;
    }

    .btn-finish:hover {
        background: var(--green-500);
        transform: translateY(-1px);
    }

    @media (max-width: 640px) {
        .likert-options { flex-wrap: wrap; }
        .likert-label { font-size: 9px; padding: 8px 4px; }
        .likert-number { width: 22px; height: 22px; font-size: 10px; }
    }
</style>
@endpush

@section('content')
<div class="quiz-wrapper">

    <!-- Progress -->
    <div class="progress-section">
        <div class="progress-top">
            <span class="progress-label">Progress Asesmen</span>
            <span class="progress-badge">{{ $currentPage }} / {{ $totalPages }}</span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ ($currentPage / $totalPages) * 100 }}%;"></div>
        </div>
    </div>

    <!-- Category Header -->
    <div class="category-header">
        <div class="category-icon"><i class="bi bi-grid-3x3"></i></div>
        <div class="category-name">{{ $currentCategory->translation->name }}</div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('pengukuran.store.likert', ['page' => $currentPage]) }}" id="likertForm">
        @csrf

        @foreach ($currentCategory->questions->where('type', 'likert') as $question)
            @php
                $isChecked = isset($stored[$question->id]);
                $checkedValue = $stored[$question->id] ?? null;
                $answers = is_null($question->id_answer_template)
                    ? $question->answers
                    : $question->answerTemplate->defaultAnswers;
            @endphp
            <div class="question-card {{ $isChecked ? 'answered' : '' }}" id="qcard-{{ $question->id }}">
                <div class="question-text">
                    <span class="question-number">{{ $loop->iteration }}</span>
                    <div class="question-content">{{ $question->translation->question }}</div>
                </div>
                <div class="likert-options">
                    @foreach ($answers as $ans)
                        @php
                            $val = $question->id . ':' . $ans->id . ':' . $ans->bobot;
                            $checked = $isChecked && $checkedValue == $val;
                        @endphp
                        <div class="likert-option">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $val }}"
                                id="ans-{{ $ans->id }}-{{ $question->id }}" @checked($checked)
                                onchange="markAnswered({{ $question->id }})">
                            <label for="ans-{{ $ans->id }}-{{ $question->id }}" class="likert-label">
                                <span class="likert-number">{{ $ans->bobot }}</span>
                                <span>{{ $ans->translation->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="form-actions">
            @if ($currentPage > 1)
                <button type="submit" class="btn-back" name="action" value="back" formnovalidate>
                    <i class="bi bi-arrow-left"></i> Sebelumnya
                </button>
            @else
                <span></span>
            @endif

            @if ($currentPage < $totalPages)
                <button type="submit" class="btn-next" name="action" value="next">
                    Lanjutkan <i class="bi bi-arrow-right"></i>
                </button>
            @else
                <button type="submit" class="btn-finish" name="action" value="finish_likert">
                    <i class="bi bi-check-lg"></i> Selesaikan
                </button>
            @endif
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    function markAnswered(questionId) {
        document.getElementById('qcard-' + questionId)?.classList.add('answered');
    }

    document.getElementById('likertForm').addEventListener('submit', function(e) {
        const groups = {};
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            groups[radio.name] = groups[radio.name] || false;
            if (radio.checked) {
                groups[radio.name] = true;
            }
        });

        const invalid = Object.values(groups).some(v => !v);
        if (invalid) {
            e.preventDefault();
            alert('Semua pertanyaan harus dijawab terlebih dahulu.');
        }
    });
</script>
@endpush