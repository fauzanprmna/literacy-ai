@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('messages.detail_question'))
@section('header', __('messages.detail_question'))

@push('head')
<style>

    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13px; font-weight: 600; color: var(--gray-600);
        text-decoration: none; padding: 8px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        background: var(--white); transition: all .15s; margin-bottom: 20px;
    }
    .back-link:hover { background: var(--gray-100); color: var(--gray-800); }

    .detail-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    /* Hero strip */
    .detail-hero {
        background: linear-gradient(135deg, var(--green-800) 0%, var(--green-700) 100%);
        padding: 22px 26px;
        display: flex; align-items: flex-start; gap: 14px;
        position: relative; overflow: hidden;
    }
    .detail-hero::after {
        content: ''; position: absolute; bottom: -30px; right: -30px;
        width: 120px; height: 120px; border-radius: 50%;
        background: rgba(255,255,255,.05);
    }
    .dh-icon {
        width: 42px; height: 42px; border-radius: var(--radius-md);
        background: rgba(255,255,255,.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: var(--g3); flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .dh-text { position: relative; z-index: 1; }
    .dh-question { font-size: 15px; font-weight: 600; color: #fff; line-height: 1.5; margin-bottom: 8px; }
    .dh-chips { display: flex; gap: 7px; flex-wrap: wrap; }
    .dh-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.15);
        border-radius: 20px; padding: 3px 10px;
        font-size: 11px; font-weight: 600; color: rgba(255,255,255,.85);
    }

    /* Sections */
    .detail-section {
        padding: 18px 24px;
        border-bottom: 1px solid var(--gray-100);
    }
    .detail-section:last-child { border-bottom: none; }

    .detail-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .detail-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }

    .detail-field { }
    .df-label {
        font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .08em;
        color: var(--gray-400); margin-bottom: 5px;
    }
    .df-value {
        font-size: 13px; font-weight: 500; color: var(--gray-800);
    }

    .badge-cat {
        background: var(--green-50); color: var(--green-700);
        font-size: 12px; font-weight: 600;
        padding: 4px 12px; border-radius: 20px;
        border: 1px solid var(--green-100);
        display: inline-block;
    }
    .badge-type {
        font-size: 11px; font-weight: 700;
        padding: 4px 12px; border-radius: 12px;
        display: inline-block;
    }
    .bt-likert { background: #cffafe; color: #155e75; }
    .bt-mc     { background: #ede9fe; color: #5b21b6; }
    .bt-text   { background: var(--gray-100); color: var(--gray-600); }

    .bobot-badge {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--green-50); color: var(--green-700);
        border: 2px solid var(--green-200);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 800;
    }

    /* Answers list */
    .answers-list { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }
    .answer-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        font-size: 13px; color: var(--gray-700);
        transition: border-color .12s;
    }
    .answer-item.correct {
        border-color: var(--green-300);
        background: var(--green-50);
        color: var(--green-800);
    }
    .answer-idx {
        width: 22px; height: 22px; border-radius: 50%;
        background: var(--gray-100); color: var(--gray-500);
        font-size: 10px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .answer-item.correct .answer-idx { background: var(--green-600); color: #fff; }
    .answer-bobot {
        margin-left: auto; font-size: 11px; font-weight: 700;
        color: var(--gray-400);
    }
    .answer-item.correct .answer-bobot { color: var(--green-600); }
    .correct-tag {
        font-size: 10px; font-weight: 700;
        background: var(--green-700); color: #fff;
        padding: 2px 7px; border-radius: 10px;
        flex-shrink: 0;
    }

    /* Actions */
    .detail-actions { display: flex; gap: 8px; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm); text-decoration: none;
        background: #fef3c7; color: #92400e; border: 1px solid #fde68a;
        transition: all .15s;
    }
    .btn-edit:hover { background: #fde68a; }
    .btn-del {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm); border: none; cursor: pointer;
        background: #fee2e2; color: #991b1b; transition: all .15s;
    }
    .btn-del:hover { background: #fecaca; }

    @media (max-width: 576px) {
        .detail-grid, .detail-grid-3 { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="detail-wrap">
    <a href="{{ route('question.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> {{ __('messages.back') }}
    </a>

    <div class="detail-card">
        <!-- Hero -->
        <div class="detail-hero">
            <div class="dh-icon"><i class="bi bi-question-circle-fill"></i></div>
            <div class="dh-text">
                <p class="dh-question">{{ $question->question }}</p>
                <div class="dh-chips">
                    @if ($question->category)
                        <span class="dh-chip"><i class="bi bi-tag"></i> {{ $question->category->name }}</span>
                    @endif
                    @php
                        $typeLabel = match($question->type ?? 'text') {
                            'likert' => 'Likert', 'multiple_choice' => 'Pilihan Ganda', default => 'Text'
                        };
                    @endphp
                    <span class="dh-chip"><i class="bi bi-list-check"></i> {{ $typeLabel }}</span>
                    <span class="dh-chip"><i class="bi bi-star"></i> Bobot: {{ $question->bobot }}</span>
                </div>
            </div>
        </div>

        <!-- Meta -->
        <div class="detail-section">
            <div class="detail-grid">
                <div class="detail-field">
                    <p class="df-label">Kategori</p>
                    @if ($question->category)
                        <span class="badge-cat">{{ $question->category->name }}</span>
                    @else
                        <span class="df-value">—</span>
                    @endif
                </div>
                <div class="detail-field">
                    <p class="df-label">Tipe Pertanyaan</p>
                    <span class="badge-type {{ match($question->type ?? 'text') { 'likert' => 'bt-likert', 'multiple_choice' => 'bt-mc', default => 'bt-text' } }}">
                        {{ $typeLabel }}
                    </span>
                </div>
                <div class="detail-field">
                    <p class="df-label">Bobot Nilai</p>
                    <span class="bobot-badge">{{ $question->bobot }}</span>
                </div>
                <div class="detail-field">
                    <p class="df-label">Template Jawaban</p>
                    <span class="df-value">{{ $question->answerTemplate->name ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- Header (if any) -->
        @if ($question->header ?? null)
            <div class="detail-section">
                <p class="df-label" style="margin-bottom:6px;">Header</p>
                <p style="font-size:13px;color:var(--gray-700);line-height:1.6;">{{ $question->header }}</p>
            </div>
        @endif

        <!-- Translations -->
        @if ($question->translations && $question->translations->count() > 0)
            <div class="detail-section">
                <p class="df-label" style="margin-bottom:12px;">Terjemahan</p>
                <div class="detail-grid">
                    @foreach ($question->translations as $t)
                        <div style="border:1px solid var(--gray-200);border-radius:var(--radius-md);padding:12px 14px;">
                            <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--green-600);margin-bottom:5px;">
                                {{ strtoupper($t->locale) === 'ID' ? '🇮🇩 Indonesia' : '🇬🇧 English' }}
                            </p>
                            <p style="font-size:13px;color:var(--gray-700);line-height:1.6;">{{ $t->question }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Answers -->
        @if ($question->answers && $question->answers->count() > 0)
            <div class="detail-section">
                <p class="df-label" style="margin-bottom:10px;">Pilihan Jawaban</p>
                <div class="answers-list">
                    @foreach ($question->answers as $i => $ans)
                        <div class="answer-item {{ $ans->bobot ? 'correct' : '' }}">
                            <span class="answer-idx">{{ chr(65 + $i) }}</span>
                            <span>{{ $ans->name }}</span>
                            @if ($ans->bobot)
                                <span class="correct-tag"><i class="bi bi-check"></i> Benar</span>
                            @endif
                            <span class="answer-bobot">Bobot: {{ $ans->bobot }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="detail-section">
            <div class="detail-actions">
                <a href="{{ route('question.edit', $question) }}" class="btn-edit">
                    <i class="bi bi-pencil"></i> {{ __('messages.edit') }}
                </a>
                <form action="{{ route('question.destroy', $question) }}" method="POST"
                    onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del">
                        <i class="bi bi-trash"></i> {{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection