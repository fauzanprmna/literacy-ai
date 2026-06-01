<style>
    /* ─── FORM STYLES ─────────────────────────── */
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
        display: block;
        font-size: 12px; font-weight: 600;
        color: var(--gray-700); margin-bottom: 6px;
    }
    .field-sublabel {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--green-600);
        display: block; margin-bottom: 4px;
    }

    .form-input {
        width: 100%; padding: 9px 12px;
        font-size: 13px; font-family: inherit;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        color: var(--gray-800);
        background: var(--white);
        transition: border-color .15s, box-shadow .15s;
        outline: none;
    }
    .form-input:focus {
        border-color: var(--green-400);
        box-shadow: 0 0 0 3px rgba(26,92,64,.08);
    }
    .form-input::placeholder { color: var(--gray-400); }
    select.form-input { cursor: pointer; }

    .field-error { font-size: 11px; color: #e74c3c; margin-top: 4px; }

    /* Content cards */
    .content-container { display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; }

    .content-item {
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        background: var(--gray-50);
        overflow: hidden;
        position: relative;
        transition: border-color .15s;
    }
    .content-item.answered { border-color: var(--green-200); }

    .content-item-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 14px;
        border-bottom: 1px solid var(--gray-200);
        background: var(--white);
    }
    .content-type-label {
        font-size: 11px; font-weight: 700;
        padding: 3px 10px; border-radius: 12px;
    }
    .ctl-text { background: var(--green-50); color: var(--green-700); }
    .ctl-file { background: #e0f7f4; color: #0d766c; }
    .ctl-link { background: #ede9fe; color: #5b21b6; }

    .btn-remove-content {
        background: none; border: none; cursor: pointer;
        color: var(--gray-400); font-size: 16px; padding: 2px;
        transition: color .12s; line-height: 1;
    }
    .btn-remove-content:hover { color: #e74c3c; }

    .content-item-body { padding: 14px; }

    /* Preview for existing content */
    .existing-preview {
        font-size: 12px; color: var(--gray-600);
        background: var(--white);
        border: 1px solid var(--gray-100);
        border-radius: var(--radius-sm);
        padding: 8px 10px;
        max-height: 80px; overflow-y: auto;
    }
    .existing-file { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--gray-700); }
    .existing-link a { font-size: 12px; color: var(--green-700); word-break: break-all; }

    /* Add content toolbar */
    .add-content-bar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 14px;
    }
    .type-picker { display: flex; gap: 6px; flex-wrap: wrap; }
    .btn-type {
        padding: 7px 14px; font-size: 12px; font-weight: 600;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        background: var(--white); cursor: pointer; color: var(--gray-700);
        transition: all .14s; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-type:hover { border-color: var(--green-400); background: var(--green-50); color: var(--green-700); }

    /* Submit */
    .form-footer { display: flex; justify-content: flex-end; padding-top: 4px; }
    .btn-submit {
        padding: 11px 28px; font-size: 13px; font-weight: 700;
        border-radius: var(--radius-sm); border: none;
        background: var(--green-700); color: #fff; cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all .15s;
    }
    .btn-submit:hover { background: var(--green-600); transform: translateY(-1px); }

    /* Quill overrides */
    .ql-toolbar { border-color: var(--gray-200) !important; border-radius: var(--radius-sm) var(--radius-sm) 0 0 !important; background: var(--gray-50) !important; }
    .ql-container { border-color: var(--gray-200) !important; border-radius: 0 0 var(--radius-sm) var(--radius-sm) !important; font-family: 'Plus Jakarta Sans', sans-serif !important; font-size: 13px !important; }
    .ql-editor { min-height: 200px; }

    .field-hint { font-size: 10px; color: var(--gray-400); margin-top: 4px; }

    @media (max-width: 576px) { .form-grid-2 { grid-template-columns: 1fr; } }
</style>

<div id="translationData" style="display:none;">
    <div id="contentTypeText">{{ __('messages.content_type_text') }}</div>
    <div id="contentTypeFile">{{ __('messages.content_type_file') }}</div>
    <div id="contentTypeLink">{{ __('messages.content_type_link') }}</div>
    <div id="contentLinkPlaceholder">{{ __('messages.content_link_placeholder') }}</div>
    <div id="supportedFormats">{{ __('messages.supported_formats') }}</div>
    <div id="enterVideoLink">{{ __('messages.enter_video_link') }}</div>
</div>

<!-- Section 1: Basic Info -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-info-circle-fill"></i></div>
        <span class="form-section-title">{{ __('messages.module_info') }}</span>
    </div>
    <div class="form-section-body">

        <div class="form-grid-2">
            <!-- ID -->
            <div>
                <span class="field-sublabel">🇮🇩 {{ __('messages.indonesia') }}</span>
                <div class="field">
                    <label for="name_id" class="field-label">{{ __('messages.module_name') }}</label>
                    <input id="name_id" name="name_id" type="text" class="form-input"
                        value="{{ old('name_id', $modul->translations->where('locale','id')->first()->name ?? ($modul->name ?? '')) }}"
                        required>
                    @error('name_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
            <!-- EN -->
            <div>
                <span class="field-sublabel">🇬🇧 {{ __('messages.english') }}</span>
                <div class="field">
                    <label for="name_en" class="field-label">{{ __('messages.module_name') }}</label>
                    <input id="name_en" name="name_en" type="text" class="form-input"
                        value="{{ old('name_en', $modul->translations->where('locale','en')->first()->name ?? '') }}">
                    @error('name_en') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="form" style="margin-top:4px;">
            <div class="field">
                <label for="id_kategori" class="field-label">{{ __('messages.category') }}</label>
                <select id="id_kategori" name="id_kategori" class="form-input" required>
                    <option value="">{{ __('messages.choose') }}</option>
                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('id_kategori', $modul->id_kategori ?? null) == $category->id)>
                            {{ $category->translation->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

    </div>
</div>

<!-- Section 2: Contents -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-journal-richtext"></i></div>
        <span class="form-section-title">{{ __('messages.module_content') }}</span>
    </div>
    <div class="form-section-body">

        <!-- Add type buttons -->
        <div class="add-content-bar">
            <div class="type-picker" id="typePicker">
                <button type="button" class="btn-type" data-type="text" id="addTextBtn">
                    <i class="bi bi-card-text"></i> <span id="contentTypeTextLabel">{{ __('messages.content_type_text') }}</span>
                </button>
                <button type="button" class="btn-type" data-type="file" id="addFileBtn">
                    <i class="bi bi-file-earmark-arrow-up"></i> <span id="contentTypeFileLabel">{{ __('messages.content_type_file') }}</span>
                </button>
                <button type="button" class="btn-type" data-type="link" id="addLinkBtn">
                    <i class="bi bi-link-45deg"></i> <span id="contentTypeLinkLabel">{{ __('messages.content_type_link') }}</span>
                </button>
            </div>
        </div>

        <!-- Existing contents -->
        <div class="content-container" id="contentsContainer">
            @forelse($modul->contents ?? [] as $content)
                <div class="content-item" data-content-id="{{ $content->id }}">
                    <div class="content-item-header">
                        @if ($content->type === 'text')
                            <span class="content-type-label ctl-text">📝 Text</span>
                        @elseif ($content->type === 'file')
                            <span class="content-type-label ctl-file">📁 File</span>
                        @elseif ($content->type === 'link')
                            <span class="content-type-label ctl-link">🔗 Link</span>
                        @endif
                        <button type="button" class="btn-remove-content delete-existing-content"
                            data-content-id="{{ $content->id }}" title="Delete">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="content-item-body">
                        @if ($content->type === 'text')
                            <div class="existing-preview">{!! Str::limit(strip_tags($content->content), 200) !!}</div>
                        @elseif ($content->type === 'file')
                            <p class="existing-file"><i class="bi bi-file-earmark"></i> {{ basename($content->file_path) }}</p>
                        @elseif ($content->type === 'link')
                            <p class="existing-link"><a href="{{ $content->url }}" target="_blank">{{ $content->url }}</a></p>
                        @endif
                        <input type="hidden" name="existing_contents[]" value="{{ $content->id }}">
                    </div>
                </div>
            @empty
            @endforelse
        </div>

        <!-- New contents injected by JS -->
        <div id="newContentsContainer" class="content-container"></div>

    </div>
</div>

<!-- Submit -->
<div class="form-footer">
    <button type="submit" class="btn-submit">
        <i class="bi bi-check-lg"></i> {{ $buttonText }}
    </button>
</div>

<!-- Templates -->
<template id="textContentTemplate">
    <div class="content-item" data-type="text">
        <div class="content-item-header">
            <span class="content-type-label ctl-text">📝 Text</span>
            <button type="button" class="btn-remove-content remove-content"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="content-item-body">
            <div class="quill-editor" style="height:220px;"></div>
            <textarea name="new_content_text[]" style="display:none;" class="quill-content"></textarea>
        </div>
    </div>
</template>

<template id="fileContentTemplate">
    <div class="content-item" data-type="file">
        <div class="content-item-header">
            <span class="content-type-label ctl-file">📁 File</span>
            <button type="button" class="btn-remove-content remove-content"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="content-item-body">
            <input type="file" name="new_content_file[]" class="form-input" accept="*/*">
            <p class="field-hint" id="sfLabel">{{ __('messages.supported_formats') }}</p>
        </div>
    </div>
</template>

<template id="linkContentTemplate">
    <div class="content-item" data-type="link">
        <div class="content-item-header">
            <span class="content-type-label ctl-link">🔗 Link / Video</span>
            <button type="button" class="btn-remove-content remove-content"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="content-item-body">
            <input type="url" name="new_content_link[]" class="form-input"
                placeholder="{{ __('messages.content_link_placeholder') }}">
            <p class="field-hint">{{ __('messages.enter_video_link') }}</p>
        </div>
    </div>
</template>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.js"></script>
<script>
    const quillEditors = [];

    document.addEventListener('DOMContentLoaded', function () {
        const newContentsContainer = document.getElementById('newContentsContainer');

        function addContent(type) {
            const template = document.getElementById(type + 'ContentTemplate');
            const clone = template.content.cloneNode(true);
            const item = clone.querySelector('.content-item');

            clone.querySelector('.remove-content').addEventListener('click', function () {
                item.remove();
            });

            newContentsContainer.appendChild(clone);

            if (type === 'text') {
                setTimeout(() => {
                    const quillDiv = item.querySelector('.quill-editor');
                    const quillTA = item.querySelector('.quill-content');
                    const quill = new Quill(quillDiv, {
                        theme: 'snow',
                        placeholder: 'Enter text content...',
                        modules: {
                            toolbar: [
                                ['bold','italic','underline','strike'],
                                ['blockquote','code-block'],
                                [{'list':'ordered'},{'list':'bullet'}],
                                [{'header':1},{'header':2}],
                                ['link','image','video'],
                                ['clean']
                            ]
                        }
                    });
                    quillEditors.push({ instance: quill, textarea: quillTA });
                    quill.on('text-change', () => { quillTA.value = quill.root.innerHTML; });
                }, 0);
            }
        }

        ['text','file','link'].forEach(type => {
            document.getElementById('add' + type.charAt(0).toUpperCase() + type.slice(1) + 'Btn')
                ?.addEventListener('click', () => addContent(type));
        });

        document.querySelectorAll('.delete-existing-content').forEach(btn => {
            btn.addEventListener('click', function () {
                if (confirm('Are you sure you want to delete this content?')) {
                    const contentId = this.dataset.contentId;
                    const container = document.querySelector(`[data-content-id="${contentId}"]`);
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_contents[]';
                    deleteInput.value = contentId;
                    document.querySelector('form').appendChild(deleteInput);
                    container.style.display = 'none';
                }
            });
        });

        document.querySelector('form')?.addEventListener('submit', function () {
            quillEditors.forEach(e => { e.textarea.value = e.instance.root.innerHTML; });
        });
    });
</script>