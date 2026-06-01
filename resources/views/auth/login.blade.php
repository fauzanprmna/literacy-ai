<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Literacy AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-bg">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-10">
        <div class="auth-glow auth-glow-1"></div>
        <div class="auth-glow auth-glow-2"></div>

        <div
            class="relative w-full max-w-xl rounded-[2rem] auth-card border border-emerald-700/20 p-8 shadow-2xl shadow-emerald-950/10">
            <div class="mb-8 text-center">
                <span
                    class="inline-flex items-center justify-center rounded-full bg-emerald-900/10 px-4 py-2 text-sm font-semibold text-emerald-100 shadow-inner shadow-emerald-950/10">
                    Selamat Datang
                </span>
                <h1 class="mt-4 text-4xl font-black tracking-tight text-emerald-950">Literacy AI</h1>
                <p class="mt-3 text-sm text-slate-600">Masuk ke akun Anda dengan mudah dan cepat</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-800 shadow-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nomor_induk" class="block text-sm font-medium text-slate-700">NIM/NIDN/NUP TK</label>
                    <input id="nomor_induk" name="nomor_induk" type="text" value="{{ old('nomor_induk') }}" required
                        class="auth-input mt-2 block w-full rounded-2xl bg-white/95 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:outline-none">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="auth-input mt-2 block w-full rounded-2xl bg-white/95 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:outline-none">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full rounded-full bg-emerald-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-950/20 transition hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-300/40">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-700">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-emerald-900 hover:underline">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
