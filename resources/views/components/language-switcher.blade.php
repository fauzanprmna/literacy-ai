<div class="language-switcher">
    <details class="language-dropdown">
        <summary
            class="language-switcher-toggle inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:bg-slate-50">
            <i class="bi bi-globe"></i>
            @if (app()->getLocale() === 'en')
                {{ __('common.english') }}
            @else
                {{ __('common.indonesian') }}
            @endif
            <i class="bi bi-caret-down-fill text-slate-400"></i>
        </summary>

        <div
            class="language-dropdown-menu rounded-3xl border border-slate-200 bg-white py-2 shadow-lg shadow-slate-950/5">
            <a class="language-dropdown-item @if (app()->getLocale() === 'en') active @endif"
                href="{{ route('locale.set', 'en') }}">
                <span class="inline-flex items-center gap-2">
                    <i
                        class="bi bi-check-circle @if (app()->getLocale() === 'en') text-emerald-600 @else text-slate-400 @endif"></i>
                    {{ __('common.english') }}
                </span>
            </a>
            <a class="language-dropdown-item @if (app()->getLocale() === 'id') active @endif"
                href="{{ route('locale.set', 'id') }}">
                <span class="inline-flex items-center gap-2">
                    <i
                        class="bi bi-check-circle @if (app()->getLocale() === 'id') text-emerald-600 @else text-slate-400 @endif"></i>
                    {{ __('common.indonesian') }}
                </span>
            </a>
        </div>
    </details>
</div>

<style>
    .language-switcher details {
        position: relative;
        display: inline-block;
    }

    .language-switcher summary {
        list-style: none;
    }

    .language-switcher summary::-webkit-details-marker {
        display: none;
    }

    .language-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        z-index: 10;
        min-width: 14rem;
    }

    .language-dropdown[open] .language-dropdown-menu {
        display: block;
    }

    .language-dropdown-item {
        display: block;
        padding: 0.75rem 1rem;
        color: #334155;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .language-dropdown-item:hover {
        background-color: #f8fafc;
    }

    .language-dropdown-item.active {
        background-color: #e2e8f0;
        color: #0f172a;
        font-weight: 600;
    }
</style>
