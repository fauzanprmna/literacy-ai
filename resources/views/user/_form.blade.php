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

<!-- ── Section 1: User Information ── -->
<div class="form-section">
    <div class="form-section-header">
        <div class="form-section-icon"><i class="bi bi-person-fill"></i></div>
        <span class="form-section-title">Informasi User</span>
    </div>
    <div class="form-section-body">
        <div class="form-grid-2">
            <div class="field">
                <label for="name" class="field-label">Nama</label>
                <input id="name" name="name" type="text" class="form-input" required
                    placeholder="Nama lengkap user" value="{{ old('name', $user->name ?? '') }}">
                @error('name')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="nomor_induk" class="field-label">Nomor Induk (NIM/NIP)</label>
                <input id="nomor_induk" name="nomor_induk" type="text" class="form-input"
                    placeholder="Nomor identitas" value="{{ old('nomor_induk', $user->nomor_induk ?? '') }}">
                @error('nomor_induk')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="field">
            <label for="email" class="field-label">Email</label>
            <input id="email" name="email" type="email" class="form-input" required
                placeholder="user@example.com" value="{{ old('email', $user->email ?? '') }}">
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="password" class="field-label">Password</label>
            <input id="password" name="password" type="password" class="form-input"
                placeholder="{{ $user->id ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}">
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
            @if ($user->id)
                <p class="field-hint">Biarkan kosong untuk tidak mengubah password</p>
            @endif
        </div>

        <div class="field">
            <label for="role" class="field-label">Role</label>
            @if ($fixedRole ?? false)
                <select id="role" name="role" class="form-input" required disabled>
                    <option value="{{ $fixedRole }}" selected>{{ ucfirst($fixedRole) }}</option>
                </select>
                <input type="hidden" name="role" value="{{ $fixedRole }}">
            @else
                <select id="role" name="role" class="form-input" required>
                    <option value="">— Pilih Role —</option>
                    <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin
                    </option>
                    <option value="dosen" {{ old('role', $user->role ?? '') === 'dosen' ? 'selected' : '' }}>Dosen
                    </option>
                    <option value="mahasiswa" {{ old('role', $user->role ?? '') === 'mahasiswa' ? 'selected' : '' }}>
                        Mahasiswa</option>
                </select>
            @endif
            @error('role')
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
