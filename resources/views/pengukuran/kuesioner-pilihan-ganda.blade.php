@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('assessment.mc_title'))
@section('header', __('assessment.mc_header'))

@push('head')
<style>
    .quiz-wrap { max-width: 760px; margin: 0 auto; }

    /* Progress */
    .progress-section { margin-bottom: 20px; }
    .progress-top {
        display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;
    }
    .progress-label { font-size: 13px; font-weight: 600; color: var(--gray-800); }
    .progress-badge {
        background: var(--green-600); color: #fff;
        font-size: 11px; font-weight: 700;
        padding: 3px 12px; border-radius: 20px;
    }
    .progress-bar-outer { height: 8px; background: var(--gray-200); border-radius: 10px; overflow: hidden; }
    .progress-bar-inner {
        height: 100%; background: linear-gradient(90deg, var(--green-600), var(--green-400));
        border-radius: 10px; transition: width .4s ease;
    }

    /* Category header */
    .cat-header-card {
        background: linear-gradient(135deg, var(--green-800) 0%, var(--green-600) 100%);
        border-radius: var(--radius-lg);
        padding: 20px 24px; color: #fff; margin-bottom: 20px;
        display: flex; align-items: center; gap: 14px;
    }
    .cat-header-icon {
        width: 44px; height: 44px; border-radius: var(--radius-md);
        background: rgba(255,255,255,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
    }
    .cat-header-name { font-size: 17px; font-weight: 700; margin-bottom: 3px; }
    .cat-header-desc { font-size: 12px; opacity: .7; }

    /* Question card */
    .question-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: 16px;
        overflow: hidden;
        transition: box-shadow .15s, border-color .15s;
    }
    .question-card:hover { box-shadow: var(--shadow-md); }
    .question-card.answered { border-color: var(--green-300); }
    .question-card.answered .question-text { background: var(--green-50); }

    .question-text {
        padding: 16px 20px;
        font-size: 14px; font-weight: 600;
        color: var(--gray-800); line-height: 1.6;
        border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: flex-start; gap: 10px;
        transition: background .15s;
    }
    .question-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; border-radius: 50%;
        background: var(--green-600); color: #fff;
        font-size: 10px; font-weight: 700; flex-shrink: 0; margin-top: 1px;
    }

    .mc-options { padding: 14px 20px; display: flex; flex-direction: column; gap: 8px; }

    .mc-opt input[type=radio] { display: none; }
    .mc-opt label {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 16px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        cursor: pointer;
        font-size: 13px; color: var(--gray-700);
        transition: all .15s;
    }
    .mc-opt label:hover {
        border-color: var(--green-300);
        background: var(--green-50);
        color: var(--green-800);
    }
    /* Lingkaran pilihan + huruf */
    .mc-opt-circle {
        width: 28px; height: 28px; border-radius: 50%;
        border: 2px solid var(--gray-300);
        flex-shrink: 0; transition: all .15s;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 800; color: var(--gray-400);
    }
    .mc-opt input:checked + label {
        border-color: var(--green-600);
        background: var(--green-50);
        color: var(--green-800);
        font-weight: 600;
    }
    .mc-opt input:checked + label .mc-opt-circle {
        border-color: var(--green-600);
        background: var(--green-600);
        color: #fff;
    }

    /* Action bar */
    .form-actions {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 20px 0 4px;
        border-top: 1px solid var(--gray-100); margin-top: 8px;
    }
    .btn-back {
        padding: 10px 20px; font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm); border: 1px solid var(--gray-200);
        background: var(--white); color: var(--gray-600);
        cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
        transition: all .15s;
    }
    .btn-back:hover { background: var(--gray-100); color: var(--gray-800); }
    .btn-next {
        padding: 11px 28px; font-size: 13px; font-weight: 700;
        border-radius: var(--radius-sm); border: none;
        background: var(--green-700); color: #fff;
        cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
        transition: all .15s;
    }
    .btn-next:hover { background: var(--green-600); transform: translateY(-1px); }
    .btn-submit {
        padding: 12px 32px; font-size: 14px; font-weight: 700;
        border-radius: var(--radius-sm); border: none;
        background: var(--green-600); color: #fff;
        cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        transition: all .15s; box-shadow: 0 2px 8px rgba(26,92,64,.2);
    }
    .btn-submit:hover { background: var(--green-500); transform: translateY(-1px); }

    /* Unanswered alert */
    .alert-unanswered {
        display: none;
        background: #fef3cd; border: 1px solid #f6c23e;
        border-radius: var(--radius-md); padding: 10px 16px;
        font-size: 13px; color: #856404;
        margin-bottom: 12px;
        align-items: center; gap: 8px;
    }
    .alert-unanswered.show { display: flex; }
</style>
@endpush

@section('content')
<div class="quiz-wrap">

    {{-- Progress --}}
    <div class="progress-section">
        <div class="progress-top">
            <span class="progress-label">{{ __('assessment.mc_progress') }}</span>
            <span class="progress-badge">{{ $currentPage }} / {{ $totalPages }}</span>
        </div>
        <div class="progress-bar-outer">
            <div class="progress-bar-inner" style="width: {{ ($currentPage / $totalPages) * 100 }}%;"></div>
        </div>
    </div>

    {{-- Category Header --}}
    <div class="cat-header-card">
        <div class="cat-header-icon"><i class="bi bi-list-check"></i></div>
        <div>
            <p class="cat-header-name">{{ $currentCategory->translation->name ?? $currentCategory->name }}</p>
            @if ($currentCategory->translation->description ?? $currentCategory->deskripsi ?? null)
                <p class="cat-header-desc">{{ $currentCategory->translation->description ?? $currentCategory->deskripsi }}</p>
            @endif
        </div>
    </div>

    {{-- Unanswered alert --}}
    <div class="alert-unanswered" id="alertUnanswered">
        <i class="bi bi-exclamation-triangle-fill"></i>
        Semua pertanyaan harus dijawab sebelum melanjutkan.
    </div>

    {{-- Form --}}
    <form method="POST"
          action="{{ route('pengukuran.store.multiple_choice', ['page' => $currentPage]) }}"
          id="mcForm"
          novalidate>
        @csrf

        @foreach ($currentCategory->questions->where('type', 'multiple_choice') as $question)
            @php
                $isAnswered   = isset($stored[$question->id]);
                $checkedValue = $stored[$question->id] ?? null;

                /**
                 * MC selalu menggunakan jawaban yang melekat pada soal ($question->answers).
                 * Answer template hanya dipakai untuk soal Likert.
                 *
                 * Format value: "questionId:answerId:bobot"
                 *   • bobot = question->bobot  → jika is_correct = true
                 *   • bobot = 0               → jika is_correct = false
                 * end(explode(':', $value)) di controller mengambil bobot ini
                 * lalu menyimpannya sebagai user_answers.answer_bobot.
                 */
                $answers = $question->answers;
            @endphp

            <div class="question-card {{ $isAnswered ? 'answered' : '' }}" id="qcard-{{ $question->id }}">
                <div class="question-text">
                    <span class="question-num">{{ $loop->iteration }}</span>
                    <span>{{ $question->translation->question ?? $question->question }}</span>
                </div>

                <div class="mc-options">
                    @foreach ($answers as $ans)
                        @php
                            // {{-- Nilai yang dikirim: questionId:answerId:bobot --}}
                            // {{-- bobot sudah benar dari DB: question->bobot jika is_correct, 0 jika salah --}}
                            $val     = $question->id . ':' . $ans->id . ':' . 'multiple_choice' . ':' . $ans->bobot ;
                            $checked = $isAnswered && $checkedValue === $val;
                            $letter  = chr(65 + $loop->index); // A, B, C, D
                        @endphp
                        <div class="mc-opt">
                            <input type="radio"
                                   name="answers[{{ $question->id }}]"
                                   value="{{ $val }}"
                                   id="ans-{{ $ans->id }}-{{ $question->id }}"
                                   @checked($checked)
                                   onchange="markAnswered({{ $question->id }})">
                            <label for="ans-{{ $ans->id }}-{{ $question->id }}">
                                <span class="mc-opt-circle">{{ $letter }}</span>
                                {{ $ans->translation->name ?? $ans->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Action buttons --}}
        <div class="form-actions">
            @if ($currentPage > 1)
                <button type="submit" class="btn-back" name="action" value="back">
                    <i class="bi bi-arrow-left"></i> {{ __('assessment.back_button') }}
                </button>
            @else
                <span></span>
            @endif

            @if ($currentPage < $totalPages)
                <button type="button" class="btn-next" id="btnNext">
                    {{ __('assessment.next_button') }} <i class="bi bi-arrow-right"></i>
                </button>
                {{-- Hidden submit untuk next, di-trigger via JS setelah validasi --}}
                <button type="submit" name="action" value="next" id="btnNextSubmit" style="display:none;"></button>
            @else
                <button type="button" class="btn-submit" id="btnSubmit">
                    <i class="bi bi-check-lg"></i> {{ __('assessment.mc_submit') }}
                </button>
                <button type="submit" name="action" value="submit" id="btnSubmitSubmit" style="display:none;"></button>
            @endif
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    /** Tandai kartu soal sebagai sudah dijawab */
    function markAnswered(questionId) {
        const card = document.getElementById('qcard-' + questionId);
        if (card) card.classList.add('answered');
        checkAllAnswered(); // sembunyikan alert kalau sudah semua
    }

    /** Cek apakah semua pertanyaan sudah dijawab */
    function checkAllAnswered() {
        const groups = {};
        document.querySelectorAll('.mc-options input[type="radio"]').forEach(radio => {
            if (!groups[radio.name]) groups[radio.name] = false;
            if (radio.checked) groups[radio.name] = true;
        });
        const allAnswered = Object.values(groups).every(Boolean);
        document.getElementById('alertUnanswered')?.classList.toggle('show', !allAnswered);
        return allAnswered;
    }

    /** Validasi sebelum next / submit */
    function handleAction(targetBtnId) {
        if (!checkAllAnswered()) {
            document.getElementById('alertUnanswered')?.classList.add('show');
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        document.getElementById(targetBtnId)?.click();
    }

    document.getElementById('btnNext')  ?.addEventListener('click', () => handleAction('btnNextSubmit'));
    document.getElementById('btnSubmit')?.addEventListener('click', () => handleAction('btnSubmitSubmit'));
</script>
@endpush