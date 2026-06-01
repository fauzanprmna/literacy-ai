{{--
    Partial: resources/views/answer-template/form.blade.php
    Digunakan oleh create.blade.php dan edit.blade.php
    Requires: $template (model or empty object), $buttonText (string)
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
        letter-spacing: .06em; color: var(--green-600); display: block; margin-bottom: 4px;
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
    .field-error { font-size: 11px; color: #e74c3c; margin-top: 4px; }
    .field-hint  { font-size: 11px; color: var(--gray-400); margin-top: 4px; }

    /* Answer items */
    .content-container { display: flex; flex-direction: column; gap: 10px; }

    .content-item {
        border: 1px solid var(--gray-200); border-radius: var(--radius-md);
        background: var(--gray-50); overflow: hidden; transition: border-color .15s;
    }
    .content-item:focus-within { border-color: var(--green-300); }

    .content-item-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 9px 14px; border-bottom: 1px solid var(--gray-200); background: var(--white);
    }
    .content-item-label {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 700; color: var(--gray-600);
    }
    .item-num {
        width: 22px; height: 22px; border-radius: 50%;
        background: var(--green-700); color: #fff;
        font-size: 10px; font-weight: 800;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .btn-remove-content {
        background: none; border: none; cursor: pointer;
        color: var(--gray-400); font-size: 15px; padding: 2px;
        transition: color .12s; line-height: 1;
    }
    .btn-remove-content:hover { color: #e74c3c; }

    .content-item-body {
        padding: 14px;
        display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: end;
    }
    .bobot-input { max-width: 100px; }

    /* Add answer button */
    .add-content-bar { margin-top: 12px; }
    .btn-type {
        padding: 8px 16px; font-size: 12px; font-weight: 600;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        background: var(--white); cursor: pointer; color: var(--gray-700);
        transition: all .14s; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-type:hover { border-color: var(--green-400); background: var(--green-50); color: var(--green-700); }

    /* Submit */
    .form-footer { display: flex; justify-content: flex-end; padding-top: 4px; }
    .btn-submit {
        padding: 11px 28px; font-size: 13px; font-weight: 700;
        border-radius: var(--radius-sm); border: none;
        background: var(--green-700); color: #fff; cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px; transition: all .15s;
    }
    .btn-submit:hover { background: var(--green-600); transform: translateY(-1px); }

    @media (max-width: 576px) {
        .form-grid-2 { grid-template-columns: 1fr; }
        .content-item-body { grid-template-columns: 1fr; }
        .bobot-input { max-width: 100%; }
    }
</style>

<!-- ── Section 1: Info Template ── -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-info-circle-fill"></i></div>
        <span class="form-section-title">Info Template</span>
    </div>
    <div class="form-section-body">

        <div class="form-grid-2">
            <div>
                <span class="field-sublabel">🇮🇩 {{ __('messages.indonesia') }}</span>
                <div class="field">
                    <label for="name_id" class="field-label">Nama Template</label>
                    <input id="name_id" name="name_id" type="text" class="form-input" required
                        placeholder="Contoh: Skala Likert 1-5"
                        value="{{ old('name_id', $template->translations->where('locale','id')->first()->name ?? ($template->name ?? '')) }}">
                    @error('name_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <span class="field-sublabel">🇬🇧 {{ __('messages.english') }}</span>
                <div class="field">
                    <label for="name_en" class="field-label">Template Name</label>
                    <input id="name_en" name="name_en" type="text" class="form-input"
                        placeholder="e.g. Likert Scale 1-5"
                        value="{{ old('name_en', $template->translations->where('locale','en')->first()->name ?? '') }}">
                    @error('name_en') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ── Section 2: Pilihan Jawaban ── -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-list-check"></i></div>
        <span class="form-section-title">Pilihan Jawaban</span>
    </div>
    <div class="form-section-body">

        <p class="field-hint" style="margin-bottom:14px;">
            Tentukan pilihan jawaban dan bobot nilainya. Bobot digunakan untuk menghitung skor asesmen.
        </p>

        <div class="content-container" id="answersContainer">
            @php
                $existingAnswers = $template->defaultAnswers ?? collect([]);
                $oldAnswersId    = old('answers_id', []);
                $oldAnswersEn    = old('answers_en', []);
                $oldBobots       = old('bobots', []);
            @endphp

            @if ($existingAnswers->count() > 0)
                @foreach ($existingAnswers as $i => $ans)
                    <div class="content-item" data-index="{{ $i }}">
                        <div class="content-item-header">
                            <div class="content-item-label">
                                <span class="item-num">{{ $i + 1 }}</span>
                                Jawaban {{ $i + 1 }}
                            </div>
                            <button type="button" class="btn-remove-content remove-answer" title="Hapus">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="content-item-body">
                            <div class="field" style="margin:0;">
                                <span class="field-sublabel">🇮🇩 Indonesia</span>
                                <input type="text" name="answers_id[]" class="form-input"
                                    placeholder="Teks jawaban (ID)"
                                    value="{{ $oldAnswersId[$i] ?? ($ans->translations->where('locale','id')->first()->name ?? $ans->name ?? '') }}">
                            </div>
                            <div class="field" style="margin:0;">
                                <span class="field-sublabel">🇬🇧 English</span>
                                <input type="text" name="answers_en[]" class="form-input"
                                    placeholder="Answer text (EN)"
                                    value="{{ $oldAnswersEn[$i] ?? ($ans->translations->where('locale','en')->first()->name ?? '') }}">
                            </div>
                            <div class="field bobot-input" style="margin:0;">
                                <span class="field-sublabel">Bobot</span>
                                <input type="number" name="bobots[]" class="form-input"
                                    min="0" placeholder="1"
                                    value="{{ $oldBobots[$i] ?? ($ans->bobot ?? '') }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            @elseif (count($oldAnswersId) > 0)
                @foreach ($oldAnswersId as $i => $val)
                    <div class="content-item" data-index="{{ $i }}">
                        <div class="content-item-header">
                            <div class="content-item-label">
                                <span class="item-num">{{ $i + 1 }}</span>
                                Jawaban {{ $i + 1 }}
                            </div>
                            <button type="button" class="btn-remove-content remove-answer" title="Hapus">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="content-item-body">
                            <div class="field" style="margin:0;">
                                <span class="field-sublabel">🇮🇩 Indonesia</span>
                                <input type="text" name="answers_id[]" class="form-input"
                                    placeholder="Teks jawaban (ID)" value="{{ $val }}">
                            </div>
                            <div class="field" style="margin:0;">
                                <span class="field-sublabel">🇬🇧 English</span>
                                <input type="text" name="answers_en[]" class="form-input"
                                    placeholder="Answer text (EN)" value="{{ $oldAnswersEn[$i] ?? '' }}">
                            </div>
                            <div class="field bobot-input" style="margin:0;">
                                <span class="field-sublabel">Bobot</span>
                                <input type="number" name="bobots[]" class="form-input"
                                    min="0" placeholder="1" value="{{ $oldBobots[$i] ?? '' }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Add answer -->
        <div class="add-content-bar">
            <button type="button" class="btn-type" id="addAnswerBtn">
                <i class="bi bi-plus-lg"></i> Tambah Pilihan Jawaban
            </button>
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
        const container = document.getElementById('answersContainer');
        const addBtn    = document.getElementById('addAnswerBtn');

        function getCount() {
            return container.querySelectorAll('.content-item').length;
        }

        function renumberItems() {
            container.querySelectorAll('.content-item').forEach((item, i) => {
                item.querySelector('.item-num').textContent = i + 1;
                item.querySelector('.content-item-label').childNodes[1].textContent = ' Jawaban ' + (i + 1);
            });
        }

        function addAnswer() {
            const idx = getCount();
            const div = document.createElement('div');
            div.className = 'content-item';
            div.dataset.index = idx;
            div.innerHTML = `
                <div class="content-item-header">
                    <div class="content-item-label">
                        <span class="item-num">${idx + 1}</span>
                        Jawaban ${idx + 1}
                    </div>
                    <button type="button" class="btn-remove-content remove-answer" title="Hapus">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="content-item-body">
                    <div class="field" style="margin:0;">
                        <span class="field-sublabel">🇮🇩 Indonesia</span>
                        <input type="text" name="answers_id[]" class="form-input" placeholder="Teks jawaban (ID)">
                    </div>
                    <div class="field" style="margin:0;">
                        <span class="field-sublabel">🇬🇧 English</span>
                        <input type="text" name="answers_en[]" class="form-input" placeholder="Answer text (EN)">
                    </div>
                    <div class="field bobot-input" style="margin:0;">
                        <span class="field-sublabel">Bobot</span>
                        <input type="number" name="bobots[]" class="form-input" min="0" placeholder="1">
                    </div>
                </div>
            `;
            div.querySelector('.remove-answer').addEventListener('click', function () {
                div.remove();
                renumberItems();
            });
            container.appendChild(div);
        }

        // Attach remove to existing items
        container.querySelectorAll('.remove-answer').forEach(btn => {
            btn.addEventListener('click', function () {
                this.closest('.content-item').remove();
                renumberItems();
            });
        });

        addBtn.addEventListener('click', addAnswer);

        // Add 5 default items if empty (new form)
        if (getCount() === 0) {
            for (let i = 0; i < 5; i++) addAnswer();
        }
    });
</script>
@endpush