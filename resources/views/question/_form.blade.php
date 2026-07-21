{{--
    Partial: resources/views/question/form.blade.php
    Digunakan oleh create.blade.php dan edit.blade.php
    Requires: $question (model or empty object), $buttonText (string)
--}}

<style>
    .form-section {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .form-section-header {
        padding: 14px 22px;
        border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; gap: 10px;
    }
    .form-section-icon {
        width: 28px; height: 28px; border-radius: var(--radius-sm);
        background: var(--green-50); color: var(--green-600);
        display: flex; align-items: center; justify-content: center; font-size: 13px;
    }
    .form-section-title { font-size: 14px; font-weight: 700; color: var(--gray-800); }
    .form-section-body { padding: 22px; }

    .form-grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }

    .field { margin-bottom: 16px; }
    .field:last-child { margin-bottom: 0; }
    .field-label {
        display: block; font-size: 12px; font-weight: 600;
        color: var(--gray-700); margin-bottom: 6px;
    }
    .field-sublabel {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--green-600);
        display: block; margin-bottom: 4px;
    }
    .form-input {
        width: 100%; padding: 9px 12px; font-size: 13px; font-family: inherit;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        color: var(--gray-800); background: var(--white); outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-input:focus {
        border-color: var(--green-400);
        box-shadow: 0 0 0 3px rgba(26,92,64,.08);
    }
    .form-input::placeholder { color: var(--gray-400); }
    textarea.form-input { resize: vertical; min-height: 80px; line-height: 1.6; }
    select.form-input { cursor: pointer; }
    .field-error { font-size: 11px; color: #e74c3c; margin-top: 4px; }
    .field-hint  { font-size: 11px; color: var(--gray-400); margin-top: 4px; }

    /* Type selector */
    .type-selector { display: flex; gap: 8px; flex-wrap: wrap; }
    .type-opt { flex: 1; min-width: 100px; }
    .type-opt input[type=radio] { display: none; }
    .type-opt label {
        display: flex; flex-direction: column; align-items: center; gap: 5px;
        padding: 12px 10px;
        border: 2px solid var(--gray-200); border-radius: var(--radius-md);
        cursor: pointer; font-size: 12px; font-weight: 600;
        color: var(--gray-600); text-align: center; transition: all .15s;
    }
    .type-opt label i { font-size: 18px; }
    .type-opt label:hover { border-color: var(--green-300); background: var(--green-50); color: var(--green-700); }
    .type-opt input:checked + label {
        border-color: var(--green-600); background: var(--green-50); color: var(--green-700);
    }
    .type-opt input:checked + label i { color: var(--green-600); }

    /* MC answers */
    .content-container { display: flex; flex-direction: column; gap: 10px; margin-top: 4px; }
    .content-item {
        border: 1px solid var(--gray-200); border-radius: var(--radius-md);
        background: var(--gray-50); overflow: hidden; transition: border-color .15s;
    }
    .content-item-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 9px 14px; border-bottom: 1px solid var(--gray-200); background: var(--white);
    }
    .content-type-label {
        font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 12px;
    }
    .ctl-mc { background: #ede9fe; color: #5b21b6; }
    .btn-remove-content {
        background: none; border: none; cursor: pointer;
        color: var(--gray-400); font-size: 15px; padding: 2px;
        transition: color .12s; line-height: 1;
    }
    .btn-remove-content:hover { color: #e74c3c; }
    .content-item-body { padding: 14px; }

    .mc-answer-row {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-md);
        background: var(--gray-50); transition: border-color .12s;
    }
    .mc-answer-num {
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--gray-200); color: var(--gray-600);
        font-size: 11px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 8px;
    }
    .mc-inputs { flex: 1; display: flex; flex-direction: column; gap: 6px; }
    .mc-inputs input { font-size: 12px; padding: 7px 10px; }
    .mc-correct-wrap {
        display: flex; flex-direction: column; align-items: center; gap: 3px;
        flex-shrink: 0; padding-top: 6px;
    }
    .mc-correct-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--gray-400); }
    .correct-check { width: 16px; height: 16px; cursor: pointer; accent-color: var(--green-600); }

    /* Collapsible sections */
    .collapsible { display: none; }
    .collapsible.show { display: block; }

    /* Submit */
    .form-footer { display: flex; justify-content: flex-end; padding-top: 4px; }
    .btn-submit {
        padding: 11px 28px; font-size: 13px; font-weight: 700;
        border-radius: var(--radius-sm); border: none;
        background: var(--green-700); color: #fff; cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px; transition: all .15s;
    }
    .btn-submit:hover { background: var(--green-600); transform: translateY(-1px); }

    @media (max-width: 576px) { .form-grid-2 { grid-template-columns: 1fr; } .type-opt { min-width: 80px; } }
</style>

<!-- ── Section 1: Pengaturan Soal ── -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-sliders"></i></div>
        <span class="form-section-title">Pengaturan Soal</span>
    </div>
    <div class="form-section-body">

        <div class="form-grid-2" style="margin-bottom:16px;">
            <div class="field">
                <label for="id_kategori" class="field-label">{{ __('messages.category') }}</label>
                <select id="id_kategori" name="id_kategori" class="form-input" required>
                    <option value="">— {{ __('messages.category') }}</option>
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ old('id_kategori', $question->id_kategori ?? null) == $category->id ? 'selected' : '' }}>
                            {{ $category->translation->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori') <p class="field-error">{{ $message }}</p> @enderror
            </div>
            <div class="field">
                <label for="bobot" class="field-label">{{ __('messages.weight_value') }}</label>
                <input type="number" id="bobot" name="bobot" min="1" class="form-input"
                    value="{{ old('bobot', $question->bobot ?? '') }}" placeholder="Contoh: 5">
                @error('bobot') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="field">
            <label class="field-label">{{ __('messages.question_type') }}</label>
            @php $typeOld = old('type', $question->type ?? 'likert'); @endphp
            <div class="type-selector">
                <div class="type-opt">
                    <input type="radio" name="type" value="likert" id="type_likert" {{ $typeOld == 'likert' ? 'checked' : '' }}>
                    <label for="type_likert"><i class="bi bi-sliders2-vertical"></i> Likert</label>
                </div>
                <div class="type-opt">
                    <input type="radio" name="type" value="multiple_choice" id="type_mc" {{ $typeOld == 'multiple_choice' ? 'checked' : '' }}>
                    <label for="type_mc"><i class="bi bi-list-check"></i> Pilihan Ganda</label>
                </div>
            </div>
            @error('type') <p class="field-error">{{ $message }}</p> @enderror
        </div>

    </div>
</div>

<!-- ── Section 2: Teks Pertanyaan ── -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-translate"></i></div>
        <span class="form-section-title">Teks Pertanyaan</span>
    </div>
    <div class="form-section-body">
        <div class="form-grid-2">
            <div>
                <span class="field-sublabel">🇮🇩 {{ __('messages.indonesia') }}</span>
                <div class="field">
                    <label for="question_id" class="field-label">{{ __('messages.question') }}</label>
                    <textarea id="question_id" name="question_id" class="form-input" rows="3">{{ old('question_id', $question->translations->where('locale','id')->first()->question ?? ($question->question ?? '')) }}</textarea>
                    @error('question_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="header_id" class="field-label">{{ __('messages.header_optional') }}</label>
                    <input id="header_id" name="header_id" type="text" class="form-input"
                        value="{{ old('header_id', $question->translations->where('locale','id')->first()->header ?? '') }}"
                        placeholder="Header opsional...">
                </div>
            </div>
            <div>
                <span class="field-sublabel">🇬🇧 {{ __('messages.english') }}</span>
                <div class="field">
                    <label for="question_en" class="field-label">{{ __('messages.question') }}</label>
                    <textarea id="question_en" name="question_en" class="form-input" rows="3">{{ old('question_en', $question->translations->where('locale','en')->first()->question ?? '') }}</textarea>
                    @error('question_en') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="header_en" class="field-label">{{ __('messages.header_optional') }}</label>
                    <input id="header_en" name="header_en" type="text" class="form-input"
                        value="{{ old('header_en', $question->translations->where('locale','en')->first()->header ?? '') }}"
                        placeholder="Optional header...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Section 3: Template Jawaban (Likert only) ── -->
<div class="form-section collapsible" id="likert_section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
        <span class="form-section-title">{{ __('messages.answer_template_optional') }}</span>
    </div>
    <div class="form-section-body">
        <div class="field">
            <label for="id_answer_template" class="field-label">Pilih Template Jawaban</label>
            <select id="id_answer_template" name="id_answer_template" class="form-input">
                <option value="">— {{ __('messages.answer_template_optional') }}</option>
                @foreach (\App\Models\AnswerTemplate::all() as $template)
                    <option value="{{ $template->id }}"
                        {{ old('id_answer_template', $question->id_answer_template ?? null) == $template->id ? 'selected' : '' }}>
                        {{ $template->translation->name }}
                    </option>
                @endforeach
            </select>
            <p class="field-hint">Template akan digunakan sebagai pilihan jawaban untuk soal Likert ini.</p>
            @error('id_answer_template') <p class="field-error">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<!-- ── Section 4: Pilihan Ganda (MC only) ── -->
<div class="form-section collapsible" id="mc_section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-list-check"></i></div>
        <span class="form-section-title">Pilihan Jawaban (4 opsi)</span>
    </div>
    <div class="form-section-body">
        @php
            $mcOldId         = old('mc_answers_id', []);
            $mcOldEn         = old('mc_answers_en', []);
            $mcCorrectOld    = old('mc_correct', []);
            $existingAnswers = isset($question) ? $question->answers->toArray() : [];
        @endphp
        <div class="content-container">
            @for ($i = 0; $i < 4; $i++)
                @php
                    $existingId = $existingAnswers[$i]['translations'][1]['name'] ?? ($existingAnswers[$i]['name'] ?? '');
                    $existingEn = $existingAnswers[$i]['translations'][0]['name'] ?? '';
                    $isCorrect  = in_array((string)$i, $mcCorrectOld) || (!empty($existingAnswers[$i]['bobot'] ?? null) && $existingAnswers[$i]['bobot']);
                @endphp
                <div class="mc-answer-row">
                    <div class="mc-answer-num">{{ chr(65 + $i) }}</div>
                    <div class="mc-inputs">
                        <input type="text" name="mc_answers_id[]" class="form-input"
                            placeholder="Jawaban {{ chr(65 + $i) }} (Indonesia)"
                            value="{{ $mcOldId[$i] ?? ($existingId ?? '') }}">
                        <input type="text" name="mc_answers_en[]" class="form-input"
                            placeholder="Answer {{ chr(65 + $i) }} (English)"
                            value="{{ $mcOldEn[$i] ?? ($existingEn ?? '') }}">
                    </div>
                    <div class="mc-correct-wrap">
                        <span class="mc-correct-label">Benar</span>
                        <input type="checkbox" name="mc_correct[]" value="{{ $i }}"
                            class="correct-check" {{ $isCorrect ? 'checked' : '' }}>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

<!-- ── Submit ── -->
<div class="form-footer">
    <button type="submit" class="btn-submit">
        <i class="bi bi-check-lg"></i> {{ $buttonText }}
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeRadios    = document.querySelectorAll('input[name="type"]');
        const likertSection = document.getElementById('likert_section');
        const mcSection     = document.getElementById('mc_section');

        function toggleSections() {
            const val = document.querySelector('input[name="type"]:checked')?.value;
            likertSection.classList.toggle('show', val === 'likert');
            mcSection.classList.toggle('show',    val === 'multiple_choice');
        }

        typeRadios.forEach(r => r.addEventListener('change', toggleSections));
        toggleSections();
    });
</script>
@endpush