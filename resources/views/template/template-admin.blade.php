<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Literacy AI Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" crossorigin="anonymous" />
    <style>

        :root {
            --green-dark: #0d2b1f;
            --green-900: #0d2b1f;
            --green-800: #14402e;
            --green-700: #1a5c40;
            --green-600: #1a5c40;
            --green-500: #2a9468;
            --green-100: #d4f0e4;
            --green-50: #edf9f4;
            --white: #ffffff;
            --gray-50: #f8faf9;
            --gray-100: #f0f4f2;
            --gray-200: #dce5e0;
            --gray-400: #8fa89d;
            --gray-600: #4a6358;
            --gray-800: #243b30;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,.08);
            --sidebar-w: 260px;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --topbar-h: 64px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--green-dark);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s ease;
        }

        .sidebar-logo {
            padding: 0 24px;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            flex-shrink: 0;
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            background: var(--green-600);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
            color: #fff;
            font-size: 18px;
        }

        .sidebar-logo-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: .02em;
        }

        .sidebar-logo-text span {
            color: var(--green-100);
        }

        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 16px 0 24px;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 0;
        }

        .nav-header {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
            padding: 18px 24px 8px;
        }

        .nav-item {
            list-style: none;
            padding: 2px 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 5px;
            color: rgba(255, 255, 255, .65);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all .2s;
        }

        .nav-link i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, .08);
            color: var(--white);
        }

        .nav-link.active {
            background: var(--green-600);
            color: var(--white);
            font-weight: 600;
        }

        .nav-link.active i {
            color: var(--green-100);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background .2s;
        }

        .sidebar-user:hover {
            background: rgba(255, 255, 255, .08);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--green-500);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--white);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, .4);
        }

        /* ─── TOPBAR ─────────────────────────── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-600);
            font-size: 20px;
            padding: 6px;
        }

        .topbar-breadcrumb {
            font-size: 14px;
            color: var(--gray-600);
        }

        .topbar-breadcrumb strong {
            color: var(--gray-800);
            font-weight: 700;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 5px;
            border: 1px solid var(--gray-200);
            background: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: all .2s;
        }

        .topbar-btn:hover {
            background: var(--green-50);
            border-color: var(--green-100);
            color: var(--green-600);
        }

        .lang-pill {
            display: flex;
            align-items: center;
            gap: 2px;
            background: var(--gray-100);
            border-radius: 20px;
            padding: 3px;
        }

        .lang-pill a {
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 16px;
            text-decoration: none;
            color: var(--gray-600);
            transition: all .2s;
        }

        .lang-pill a.active {
            background: var(--green-dark);
            color: var(--white);
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--green-600);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: 2px solid var(--green-100);
        }

        .topbar-user-wrap {
            position: relative;
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            box-shadow: var(--shadow-md);
            min-width: 220px;
            padding: 8px;
            display: none;
            z-index: 200;
        }

        .topbar-user-wrap:focus-within .user-dropdown,
        .topbar-user-wrap.open .user-dropdown {
            display: block;
        }

        .dropdown-name {
            padding: 8px 10px 12px;
            border-bottom: 1px solid var(--gray-100);
            margin-bottom: 6px;
        }

        .dropdown-name p {
            font-weight: 600;
            font-size: 13px;
            color: var(--gray-800);
        }

        .dropdown-name small {
            color: var(--gray-600);
            font-size: 11px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 10px;
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-800);
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            transition: background .2s;
        }

        .dropdown-item:hover {
            background: var(--gray-100);
        }

        .dropdown-item.danger {
            color: #dc2626;
        }

        .dropdown-item.danger:hover {
            background: #fef2f2;
        }

        /* ─── MAIN ─────────────────────────── */
        .main {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-header {
            padding: 24px 28px 0;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .page-content {
            padding: 20px 28px 40px;
            flex: 1;
        }

        footer.app-footer {
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: 14px 28px;
            font-size: 12px;
            color: var(--gray-600);
            margin-left: 0;
        }

        /* ─── RESPONSIVE ─────────────────────── */
        @media (max-width: 991px) {
            :root {
                --sidebar-w: 0px;
            }

            .sidebar {
                transform: translateX(-260px);
                width: 260px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .topbar-toggle {
                display: flex;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .4);
                z-index: 90;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 0 16px;
            }

            .page-header {
                padding: 16px;
            }

            .page-title {
                font-size: 18px;
            }

            .page-content {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <span class="sidebar-logo-text">Literacy<span>AI</span></span>
        </div>

        <div class="sidebar-scroll">
            <ul style="list-style:none;">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>

                <li class="nav-header">{{ __('messages.main_features') }}</li>
                <li class="nav-item">
                    <a href="{{ route('pengukuran.index') }}" class="nav-link {{ request()->routeIs('pengukuran.*') ? 'active' : '' }}">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>{{ __('messages.ai_literacy_assessment') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('modul.index') }}" class="nav-link {{ request()->routeIs('modul.*') ? 'active' : '' }}">
                        <i class="bi bi-book-half"></i>
                        <span>{{ __('messages.learning_modules') }}</span>
                    </a>
                </li>

                <li class="nav-header">CONTENT MANAGEMENT</li>
                <li class="nav-item">
                    <a href="{{ route('answer-template.index') }}" class="nav-link {{ request()->routeIs('answer-template.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>{{ __('messages.answer_templates') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>{{ __('messages.categories') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('question.index') }}" class="nav-link {{ request()->routeIs('question.*') ? 'active' : '' }}">
                        <i class="bi bi-question-circle-fill"></i>
                        <span>{{ __('messages.manage_questions') }}</span>
                    </a>
                </li>

                <li class="nav-header">{{ __('messages.manage_users') }}</li>
                <li class="nav-item">
                    <a href="{{ route('user.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('user.mahasiswa.*') ? 'active' : '' }}">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>{{ __('messages.mahasiswa') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.dosen.index') }}" class="nav-link {{ request()->routeIs('user.dosen.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>{{ __('messages.dosen') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <nav class="topbar">
        <button class="topbar-toggle" id="sidebar-toggle" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>

        <div class="topbar-breadcrumb">
            <strong>@yield('header', 'Dashboard')</strong>
        </div>

        <div class="topbar-right">
            <div class="lang-pill">
                <a href="{{ route('locale.set', ['locale' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('locale.set', ['locale' => 'id']) }}" class="{{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
            </div>

            <a href="{{ route('settings.index') }}" class="topbar-btn" title="{{ __('messages.settings') }}">
                <i class="bi bi-gear"></i>
            </a>

            <div class="topbar-user-wrap" id="userWrap">
                <div class="topbar-avatar" onclick="document.getElementById('userWrap').classList.toggle('open')">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="user-dropdown">
                    <div class="dropdown-name">
                        <p>{{ Auth::user()->name }}</p>
                        <small>{{ ucfirst(Auth::user()->role) }} — Literacy AI</small>
                    </div>
                    <a href="{{ route('settings.index') }}" class="dropdown-item">
                        <i class="bi bi-gear"></i> {{ __('messages.settings') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger">
                            <i class="bi bi-box-arrow-right"></i> {{ __('messages.sign_out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="main">
        <div class="page-header">
            <h1 class="page-title">@yield('header', 'Dashboard')</h1>
        </div>
        <div class="page-content">
            @yield('content')
        </div>
    </main>

    <footer class="app-footer" style="margin-left: var(--sidebar-w);">
        &copy; {{ date('Y') }} Literacy AI — Admin Panel.
    </footer>

    @stack('scripts')
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const userWrap = document.getElementById('userWrap');

        toggleBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });

        document.addEventListener('click', (e) => {
            if (!userWrap.contains(e.target)) userWrap.classList.remove('open');
        });
    </script>
</body>

</html>