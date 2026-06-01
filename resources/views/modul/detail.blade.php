@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Module Details')
@section('header', $modul->name)

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route('modul.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <i class="bi bi-arrow-left"></i>
            {{ __('messages.back') }}
        </a>

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5">
                <h1 class="text-2xl font-semibold text-slate-900">{{ $modul->name }}</h1>
                @if ($modul->category || $modul->kategoriModul)
                    <div class="mt-3 flex flex-wrap gap-2">
                        @if ($modul->category)
                            <span
                                class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 border border-green-100">{{ $modul->category->name }}</span>
                        @endif
                        @if ($modul->kategoriModul)
                            <span
                                class="rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 border border-slate-100">{{ $modul->kategoriModul->name }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="space-y-6 px-6 py-6">
                @if ($modul->description)
                    <div class="space-y-2 rounded-2xl bg-slate-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                            {{ __('messages.description') }}</p>
                        <p class="text-sm text-slate-700">{{ $modul->description }}</p>
                    </div>
                @endif

                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400 mb-3">
                        {{ __('messages.module_content') }}</p>
                    <p class="whitespace-pre-line text-sm leading-7 text-slate-700">
                        {{ $modul->isi ?? __('messages.no_content_available') }}</p>
                </div>

                @if ($modul->link)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400 mb-3">
                            {{ __('messages.module_reference_link') }}</p>
                        <a href="{{ $modul->link }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-100 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700 transition hover:bg-green-100">
                            <i class="bi bi-box-arrow-up-right"></i>
                            Buka Link
                @endif

                @if (Auth::user()->role !== 'mahasiswa')
                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                    {{ __('messages.category') }}</p>
                                <p class="mt-2 text-sm font-medium text-slate-800">{{ $modul->category->name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                    {{ __('messages.module_category') }}</p>
                                <p class="mt-2 text-sm font-medium text-slate-800">{{ $modul->kategoriModul->name ?? '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('modul.edit', $modul) }}"
                                class="inline-flex items-center gap-2 rounded-lg bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-800 transition hover:bg-yellow-200">
                                <i class="bi bi-pencil"></i>
                                {{ __('messages.edit') }}
                            </a>
                            <form action="{{ route('modul.destroy', $modul) }}" method="POST"
                                onsubmit="return confirm('{{ __('messages.are_you_sure') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                                    <i class="bi bi-trash"></i>
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
