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
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-icon {
        width: 28px;
        height: 28px;
        border-radius: var(--radius-sm);
        background: var(--green-50);
        color: var(--green-600);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--gray-800);
    }

    .form-section-body {
        padding: 22px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .field {
        margin-bottom: 16px;
    }

    .field:last-child {
        margin-bottom: 0;
    }

    .field-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 6px;
    }

    .field-sublabel {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--green-600);
        display: block;
        margin-bottom: 4px;
    }

    .form-input {
        width: 100%;
        padding: 9px 12px;
        font-size: 13px;
        font-family: inherit;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        color: var(--gray-800);
        background: var(--white);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .form-input:focus {
        border-color: var(--green-400);
        box-shadow: 0 0 0 3px rgba(26, 92, 64, .08);
    }

    .form-input::placeholder {
        color: var(--gray-400);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 80px;
        line-height: 1.6;
    }

    select.form-input {
        cursor: pointer;
    }

    .field-error {
        font-size: 11px;
        color: #e74c3c;
        margin-top: 4px;
    }

    .field-hint {
        font-size: 11px;
        color: var(--gray-400);
        margin-top: 4px;
    }

    /* Submit */
    .form-footer {
        display: flex;
        justify-content: flex-end;
        padding-top: 4px;
    }

    .btn-submit {
        padding: 11px 28px;
        font-size: 13px;
        font-weight: 700;
        border-radius: var(--radius-sm);
        border: none;
        background: var(--green-700);
        color: #fff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all .15s;
    }

    .btn-submit:hover {
        background: var(--green-600);
        transform: translateY(-1px);
    }

    @media (max-width: 576px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ── Section 1: Category Information ── -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-tag-fill"></i></div>
        <span class="form-section-title">{{ __('messages.category') }}</span>
    </div>
    <div class="form-section-body">
        <div class="form-grid-2">
            <div>
                <span class="field-sublabel">🇮🇩 {{ __('messages.indonesia') }}</span>
                <div class="field">
                    <label for="name_id" class="field-label">Nama Kategori</label>
                    <input id="name_id" name="name_id" type="text" class="form-input" required
                        placeholder="Contoh: Pengetahuan Dasar"
                        value="{{ old('name_id', $category->translations->where('locale', 'id')->first()->name ?? ($category->name ?? '')) }}">
                    @error('name_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    <label for="deskripsi_id" class="field-label">Deskripsi</label>
                    <textarea id="deskripsi_id" name="deskripsi_id" class="form-input" placeholder="Jelaskan kategori ini...">{{ old('deskripsi_id', $category->translations->where('locale', 'id')->first()->deskripsi ?? ($category->deskripsi ?? '')) }}</textarea>
                    @error('deskripsi_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <span class="field-sublabel">🇬🇧 {{ __('messages.english') }}</span>
                <div class="field">
                    <label for="name_en" class="field-label">Category Name</label>
                    <input id="name_en" name="name_en" type="text" class="form-input"
                        placeholder="e.g. Basic Knowledge"
                        value="{{ old('name_en', $category->translations->where('locale', 'en')->first()->name ?? '') }}">
                    @error('name_en')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    <label for="deskripsi_en" class="field-label">Description</label>
                    <textarea id="deskripsi_en" name="deskripsi_en" class="form-input" placeholder="Describe this category...">{{ old('deskripsi_en', $category->translations->where('locale', 'en')->first()->deskripsi ?? '') }}</textarea>
                    @error('deskripsi_en')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <label for="bobot" class="field-label">{{ __('messages.bobot') }}</label>
            <input id="bobot" name="bobot" type="number" class="form-input" min="0" max="100"
                placeholder="0" value="{{ old('bobot', $category->bobot ?? '') }}">
            @error('bobot')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="form-footer">
    <button type="submit" class="btn-submit">
        <i class="bi bi-check-lg"></i> {{ $buttonText }}
    </button>
</div>
