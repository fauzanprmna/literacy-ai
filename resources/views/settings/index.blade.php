@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('settings.settings'))
@section('header', __('settings.settings'))

@push('head')
<style>
    .settings-wrap {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 20px;
        align-items: start;
    }

    /* ─── SIDEBAR NAV ─────────────────────────── */
    .settings-nav {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        position: sticky;
        top: calc(var(--topbar-h) + 16px);
    }
    .settings-nav-header {
        padding: 14px 16px;
        border-bottom: 1px solid var(--gray-100);
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .08em;
        color: var(--gray-400);
    }
    .settings-nav-list { padding: 6px; }
    .settings-nav-btn {
        display: flex; align-items: center; gap: 9px;
        width: 100%; padding: 9px 12px;
        border: none; background: none; cursor: pointer;
        border-radius: var(--radius-sm);
        font-size: 13px; font-weight: 500;
        color: var(--gray-600);
        text-align: left;
        transition: all .15s;
    }
    .settings-nav-btn i { font-size: 15px; flex-shrink: 0; }
    .settings-nav-btn:hover { background: var(--gray-50); color: var(--gray-800); }
    .settings-nav-btn.active {
        background: var(--green-50);
        color: var(--green-700);
        font-weight: 700;
        box-shadow: inset 3px 0 0 var(--green-500);
    }
    .settings-nav-btn.active i { color: var(--green-600); }

    /* ─── CONTENT PANEL ─────────────────────────── */
    .settings-panel { display: none; }
    .settings-panel.active { display: block; }

    .settings-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 16px;
    }
    .settings-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; gap: 10px;
    }
    .settings-card-icon {
        width: 32px; height: 32px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
    }
    .sci-green { background: var(--green-50); color: var(--green-600); }
    .sci-blue  { background: #e8f2ff; color: #1a5bbf; }
    .sci-red   { background: #fee2e2; color: #991b1b; }
    .settings-card-title { font-size: 15px; font-weight: 700; color: var(--gray-800); }
    .settings-card-body { padding: 22px; }
    .settings-card-desc { font-size: 13px; color: var(--gray-400); margin-bottom: 20px; }

    /* ─── LANGUAGE OPTIONS ─────────────────────────── */
    .lang-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }

    .lang-option { position: relative; }
    .lang-option input[type=radio] { display: none; }
    .lang-option label {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 18px;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all .18s;
    }
    .lang-option label:hover {
        border-color: var(--green-300);
        background: var(--green-50);
    }
    .lang-option input:checked + label {
        border-color: var(--green-500);
        background: var(--green-50);
    }
    .lang-option-left { display: flex; align-items: center; gap: 12px; }
    .lang-flag {
        width: 38px; height: 38px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; background: var(--gray-100);
    }
    .lang-name { font-size: 14px; font-weight: 700; color: var(--gray-800); margin-bottom: 2px; }
    .lang-sub  { font-size: 11px; color: var(--gray-400); }
    .lang-check {
        width: 22px; height: 22px; border-radius: 50%;
        border: 2px solid var(--gray-300);
        display: flex; align-items: center; justify-content: center;
        transition: all .15s; flex-shrink: 0;
    }
    .lang-option input:checked + label .lang-check {
        background: var(--green-600); border-color: var(--green-600);
        color: #fff; font-size: 11px;
    }

    /* Preview box */
    .preview-box {
        background: var(--green-50);
        border: 1px solid var(--green-100);
        border-left: 3px solid var(--green-400);
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        font-size: 13px; color: var(--green-800);
        display: flex; align-items: center; gap: 9px;
        margin-bottom: 20px;
    }
    .preview-box i { color: var(--green-500); flex-shrink: 0; }

    /* ─── PROFILE FIELDS ─────────────────────────── */
    .profile-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .profile-field { }
    .profile-label {
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .07em;
        color: var(--gray-400); margin-bottom: 5px;
    }
    .profile-value {
        font-size: 13px; font-weight: 500; color: var(--gray-800);
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        padding: 9px 13px;
    }
    .profile-managed {
        font-size: 12px; color: var(--gray-400);
        display: flex; align-items: center; gap: 6px;
        margin-top: 16px;
    }

    /* ─── ACCOUNT LIST ─────────────────────────── */
    .account-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 0;
        border-bottom: 1px solid var(--gray-100);
        gap: 12px;
    }
    .account-item:last-child { border-bottom: none; }
    .account-item-info h6 { font-size: 13px; font-weight: 700; color: var(--gray-800); margin-bottom: 3px; }
    .account-item-info p  { font-size: 12px; color: var(--gray-400); }
    .btn-soon {
        padding: 7px 14px; font-size: 11px; font-weight: 700;
        border-radius: 20px;
        border: 1px solid var(--gray-200);
        background: var(--white); color: var(--gray-400);
        cursor: not-allowed;
        display: inline-flex; align-items: center; gap: 5px;
    }

    .coming-soon-banner {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 12px 16px;
        font-size: 12px; color: var(--gray-400);
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 16px;
    }
    .coming-soon-banner i { color: var(--gray-300); font-size: 15px; }

    /* ─── FORM ACTIONS ─────────────────────────── */
    .form-actions { display: flex; gap: 8px; align-items: center; }
    .btn-save {
        padding: 10px 22px; font-size: 13px; font-weight: 700;
        border-radius: var(--radius-sm); border: none;
        background: var(--green-700); color: #fff; cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all .15s;
    }
    .btn-save:hover { background: var(--green-600); transform: translateY(-1px); }
    .btn-cancel {
        padding: 10px 18px; font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm); border: 1px solid var(--gray-200);
        background: var(--white); color: var(--gray-600);
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        transition: all .15s;
    }
    .btn-cancel:hover { background: var(--gray-100); color: var(--gray-800); }

    /* ─── SUCCESS ALERT ─────────────────────────── */
    .alert-success-bar {
        background: var(--green-50);
        border: 1px solid var(--green-100);
        border-left: 3px solid var(--green-500);
        border-radius: var(--radius-sm);
        padding: 12px 16px; font-size: 13px; color: var(--green-800);
        display: flex; align-items: center; justify-content: space-between;
        gap: 10px; margin-bottom: 20px;
    }
    .alert-success-bar .left { display: flex; align-items: center; gap: 8px; }
    .alert-dismiss { background: none; border: none; cursor: pointer; color: var(--green-600); font-size: 16px; padding: 0; line-height: 1; }

    @media (max-width: 991px) {
        .settings-wrap { grid-template-columns: 1fr; }
        .settings-nav { position: static; }
        .settings-nav-list { display: flex; gap: 4px; padding: 8px; overflow-x: auto; }
        .settings-nav-btn { white-space: nowrap; }
        .profile-grid { grid-template-columns: 1fr; }
        .lang-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert-success-bar" id="successAlert">
            <div class="left">
                <i class="bi bi-check-circle-fill" style="color:var(--green-500);"></i>
                {{ $message }}
            </div>
            <button class="alert-dismiss" onclick="document.getElementById('successAlert').remove()">
                <i class="bi bi-x"></i>
            </button>
        </div>
    @endif

    <div class="settings-wrap">

        <!-- ── Sidebar Nav ── -->
        <div class="settings-nav">
            <div class="settings-nav-header">{{ __('settings.settings_menu') }}</div>
            <div class="settings-nav-list">
                <button type="button" class="settings-nav-btn active" data-target="language-settings">
                    <i class="bi bi-translate"></i> {{ __('settings.language') }}
                </button>
                <button type="button" class="settings-nav-btn" data-target="profile-settings">
                    <i class="bi bi-person-fill"></i> {{ __('settings.profile') }}
                </button>
                <button type="button" class="settings-nav-btn" data-target="account-settings">
                    <i class="bi bi-shield-lock-fill"></i> {{ __('settings.account') }}
                </button>
            </div>
        </div>

        <!-- ── Panels ── -->
        <div>

            <!-- Language Settings -->
            <div id="language-settings" class="settings-panel active">
                <div class="settings-card">
                    <div class="settings-card-header">
                        <div class="settings-card-icon sci-green"><i class="bi bi-translate"></i></div>
                        <span class="settings-card-title">{{ __('settings.language_preferences') }}</span>
                    </div>
                    <div class="settings-card-body">
                        <p class="settings-card-desc">{{ __('settings.select_language') }}</p>

                        <form action="{{ route('settings.updateLanguage') }}" method="POST">
                            @csrf

                            <div class="lang-grid">
                                @foreach ($availableLanguages as $code => $name)
                                    <div class="lang-option">
                                        <input type="radio" name="language" value="{{ $code }}"
                                            id="lang_{{ $code }}"
                                            @checked($currentLanguage === $code)
                                            onchange="updatePreview('{{ $code }}')">
                                        <label for="lang_{{ $code }}">
                                            <div class="lang-option-left">
                                                <div class="lang-flag">
                                                    {{ $code === 'en' ? '🇺🇸' : '🇮🇩' }}
                                                </div>
                                                <div>
                                                    <p class="lang-name">{{ $name }}</p>
                                                    <p class="lang-sub">{{ $code === 'en' ? 'English (US)' : 'Bahasa Indonesia' }}</p>
                                                </div>
                                            </div>
                                            <div class="lang-check">
                                                @if ($currentLanguage === $code)
                                                    <i class="bi bi-check"></i>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="preview-box" id="langPreview">
                                <i class="bi bi-eye"></i>
                                <span id="langPreviewText">
                                    @if ($currentLanguage === 'en')
                                        Your interface will display in <strong>English</strong>
                                    @else
                                        Antarmuka Anda akan ditampilkan dalam <strong>Bahasa Indonesia</strong>
                                    @endif
                                </span>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <i class="bi bi-check-lg"></i> {{ __('settings.save_changes') }}
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn-cancel">
                                    <i class="bi bi-x"></i> {{ __('common.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Settings -->
            <div id="profile-settings" class="settings-panel">
                <div class="settings-card">
                    <div class="settings-card-header">
                        <div class="settings-card-icon sci-blue"><i class="bi bi-person-fill"></i></div>
                        <span class="settings-card-title">{{ __('settings.profile_information') }}</span>
                    </div>
                    <div class="settings-card-body">
                        <div class="profile-grid">
                            <div class="profile-field">
                                <p class="profile-label">{{ __('settings.full_name') }}</p>
                                <div class="profile-value">{{ $user->name }}</div>
                            </div>
                            <div class="profile-field">
                                <p class="profile-label">{{ __('settings.email') }}</p>
                                <div class="profile-value">{{ $user->email }}</div>
                            </div>
                            <div class="profile-field">
                                <p class="profile-label">{{ __('settings.roll_number') }}</p>
                                <div class="profile-value">{{ $user->nomor_induk ?? '—' }}</div>
                            </div>
                            <div class="profile-field">
                                <p class="profile-label">{{ __('settings.role') }}</p>
                                <div class="profile-value">
                                    <span style="display:inline-flex;align-items:center;gap:6px;">
                                        <span style="width:8px;height:8px;border-radius:50%;background:var(--green-500);display:inline-block;"></span>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="profile-managed">
                            <i class="bi bi-info-circle"></i>
                            {{ __('settings.profile_managed') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div id="account-settings" class="settings-panel">
                <div class="settings-card">
                    <div class="settings-card-header">
                        <div class="settings-card-icon sci-red"><i class="bi bi-shield-lock-fill"></i></div>
                        <span class="settings-card-title">{{ __('settings.account_settings') }}</span>
                    </div>
                    <div class="settings-card-body">
                        <div class="coming-soon-banner">
                            <i class="bi bi-clock"></i>
                            Account and security options are coming soon.
                        </div>
                        <div class="account-item">
                            <div class="account-item-info">
                                <h6>{{ __('settings.change_password') }}</h6>
                                <p>{{ __('settings.update_password') }}</p>
                            </div>
                            <button class="btn-soon" disabled>
                                <i class="bi bi-lock"></i> {{ __('settings.coming_soon') }}
                            </button>
                        </div>
                        <div class="account-item">
                            <div class="account-item-info">
                                <h6>{{ __('settings.two_factor_auth') }}</h6>
                                <p>{{ __('settings.add_security_layer') }}</p>
                            </div>
                            <button class="btn-soon" disabled>
                                <i class="bi bi-shield"></i> {{ __('settings.coming_soon') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Tab navigation
    document.querySelectorAll('.settings-nav-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.settings-nav-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.dataset.target).classList.add('active');
        });
    });

    // Language preview
    function updatePreview(code) {
        const text = document.getElementById('langPreviewText');
        text.innerHTML = code === 'en'
            ? 'Your interface will display in <strong>English</strong>'
            : 'Antarmuka Anda akan ditampilkan dalam <strong>Bahasa Indonesia</strong>';

        // Update check icons
        document.querySelectorAll('.lang-check').forEach(c => c.innerHTML = '');
        document.querySelector(`#lang_${code} + label .lang-check`).innerHTML = '<i class="bi bi-check"></i>';
    }
</script>
@endpush