<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Literacy AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50">
    <div class="flex h-screen bg-slate-50">
        <!-- Sidebar -->
        <aside class="w-64 border-r border-slate-200 bg-white shadow-sm">
            <div class="flex h-16 items-center border-b border-slate-200 px-6">
                <h1 class="text-xl font-bold text-blue-600">Literacy AI</h1>
            </div>

            <nav class="flex flex-col space-y-1 px-4 py-6">
                <!-- Main Navigation -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'hover:bg-slate-50' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-8-2l4-2"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Primary Actions -->
                <div class="my-4 pt-4 border-t border-slate-200">
                    <p class="px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Fitur Utama</p>

                    <a href="{{ route('pengukuran.index') }}"
                        class="mt-2 flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition {{ request()->routeIs('pengukuran.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'hover:bg-slate-50' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Pengukuran</span>
                    </a>

                    <a href="{{ route('modul.index') }}"
                        class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition {{ request()->routeIs('modul.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'hover:bg-slate-50' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z">
                            </path>
                        </svg>
                        <span>Modul Pembelajaran</span>
                    </a>
                </div>

                <!-- Management Section -->
                <div class="my-4 pt-4 border-t border-slate-200">
                    <p class="px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Manajemen</p>

                    <a href="{{ route('answer-template.index') }}"
                        class="mt-2 flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition {{ request()->routeIs('answer-template.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'hover:bg-slate-50' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span>Template</span>
                    </a>

                    <a href="{{ route('question.index') }}"
                        class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition {{ request()->routeIs('question.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'hover:bg-slate-50' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>Pertanyaan</span>
                    </a>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('user.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition {{ request()->routeIs('user.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'hover:bg-slate-50' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 8.308 4 4 0 010-8.308M3 20.333A8 8 0 0112 4c4.97 0 9.185 3.364 9.938 7.8">
                                </path>
                            </svg>
                            <span>Pengguna</span>
                        </a>
                    @endif
                </div>

                <!-- Settings & Account -->
                <div class="my-4 pt-4 border-t border-slate-200">
                    <a href="#"
                        class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition hover:bg-slate-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </div>

                <!-- Logout Button -->
                <div class="mt-auto pt-4 border-t border-slate-200">
                    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-slate-700 transition hover:bg-red-50 hover:text-red-600 font-medium">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <div class="border-b border-slate-200 bg-white px-8 py-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">@yield('header', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
