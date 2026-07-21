@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('messages.learning_resources'))
@section('header', __('messages.learning_resources'))

@push('head')
<style>
    /* ─── SUCCESS ALERT ─────────────────────────── */
    .alert-success {
        background: var(--green-50);
        border: 1px solid var(--green-100);
        border-left: 3px solid var(--green-500);
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        font-size: 13px;
        color: var(--green-800);
        display: flex; align-items: center; gap: 9px;
        margin-bottom: 20px;
    }
    .alert-success i { color: var(--green-500); font-size: 15px; flex-shrink: 0; }

    /* ─── PAGE INTRO ─────────────────────────── */
    .page-intro {
        font-size: 13px;
        color: var(--gray-400);
        margin-bottom: 20px;
    }

    /* ─── FILTER BAR ─────────────────────────── */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-right: 4px;
        flex-shrink: 0;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 999px;
        border: 1px solid var(--gray-200);
        background: var(--white);
        color: var(--gray-600);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all .15s ease;
        white-space: nowrap;
    }

    .filter-btn:hover {
        border-color: var(--green-400);
        background: var(--green-50);
        color: var(--green-700);
    }

    .filter-btn.active {
        background: var(--green-600);
        border-color: var(--green-600);
        color: var(--white);
    }

    .filter-btn .filter-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        background: rgba(255,255,255,.25);
        color: inherit;
    }

    .filter-btn:not(.active) .filter-count {
        background: var(--gray-100);
        color: var(--gray-500);
    }

    /* ─── RESULT INFO ────────────────────────── */
    .result-info {
        font-size: 12px;
        color: var(--gray-400);
        margin-bottom: 16px;
    }

    /* ─── CONTENT GRID ─────────────────────────── */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .content-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all .18s;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .content-card:hover {
        border-color: var(--green-300);
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }

    .card-header-img {
        width: 100%;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.3);
    }

    .card-header-img.source-youtube {
        background: linear-gradient(135deg, #c4302b 0%, #ff0000 100%);
    }

    .card-header-img.source-journal {
        background: linear-gradient(135deg, #1a5bbf 0%, #3b82f6 100%);
    }

    .card-header-img.source-other {
        background: linear-gradient(135deg, var(--green-500) 0%, var(--green-600) 100%);
    }

    .card-body {
        padding: 14px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-desc {
        font-size: 12px;
        color: var(--gray-600);
        line-height: 1.5;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .card-source {
        font-size: 11px;
        color: var(--gray-500);
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .card-source i {
        font-size: 10px;
        color: var(--gray-400);
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 10px;
    }

    .badge {
        background: var(--green-50);
        color: var(--green-700);
        font-size: 10px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid var(--green-100);
    }
    .badge.dimension {
        background: #e8f2ff;
        color: #1a5bbf;
        border-color: #bee5eb;
    }
    .badge.source-youtube {
        background: #fff1f1;
        color: #c4302b;
        border-color: #fecaca;
    }
    .badge.source-journal {
        background: #eff6ff;
        color: #1a5bbf;
        border-color: #bfdbfe;
    }

    .card-footer {
        padding: 10px 0;
        border-top: 1px solid var(--gray-100);
    }

    .card-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--green-600);
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: all .15s;
    }
    .card-link:hover {
        color: var(--green-700);
        gap: 10px;
    }

    /* ─── EMPTY STATE ─────────────────────────── */
    .empty-box {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        padding: 48px 24px;
        text-align: center;
    }
    .empty-box i {
        font-size: 2.5rem;
        color: var(--gray-200);
        display: block;
        margin-bottom: 12px;
    }
    .empty-box p {
        font-size: 13px;
        color: var(--gray-400);
    }
    .empty-box a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 14px;
        color: var(--green-600);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    /* ─── PAGINATION ─────────────────────────── */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 24px;
    }
    .pagination-wrap a,
    .pagination-wrap span {
        padding: 8px 12px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        font-size: 13px;
        text-decoration: none;
        color: var(--gray-700);
        transition: all .15s;
    }
    .pagination-wrap a:hover {
        background: var(--green-50);
        border-color: var(--green-300);
        color: var(--green-600);
    }
    .pagination-wrap .active {
        background: var(--green-600);
        color: white;
        border-color: var(--green-600);
    }
    .pagination-wrap .disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ─── RESPONSIVE ─────────────────────────── */
    @media (max-width: 1024px) {
        .content-grid { grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); }
    }
    @media (max-width: 640px) {
        .content-grid { grid-template-columns: 1fr; }
        .filter-bar   { gap: 6px; }
    }
</style>
@endpush

@section('content')

    <p class="page-intro">{{ __('messages.scraper_intro') }}</p>

    @if (session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Filter Bar ─────────────────────────────────────────── --}}
    <div class="filter-bar">
        <span class="filter-label">{{ __('messages.filter_source') }}:</span>

        {{-- Semua --}}
        <a href="{{ route('scraper') }}"
           class="filter-btn {{ !request('source') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            {{ __('messages.filter_all') }}
            <span class="filter-count">{{ $sourceCounts['all'] ?? 0 }}</span>
        </a>

        {{-- YouTube --}}
        <a href="{{ route('scraper', ['source' => 'youtube']) }}"
           class="filter-btn {{ request('source') === 'youtube' ? 'active' : '' }}">
            <i class="bi bi-youtube"></i>
            YouTube
            <span class="filter-count">{{ $sourceCounts['youtube'] ?? 0 }}</span>
        </a>

        {{-- Journal --}}
        <a href="{{ route('scraper', ['source' => 'journal']) }}"
           class="filter-btn {{ request('source') === 'journal' ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            {{ __('messages.filter_journal') }}
            <span class="filter-count">{{ $sourceCounts['journal'] ?? 0 }}</span>
        </a>

        {{-- Sumber tambahan lain (dinamis dari DB) --}}
        @foreach ($otherSources as $src)
            <a href="{{ route('scraper', ['source' => $src]) }}"
               class="filter-btn {{ request('source') === $src ? 'active' : '' }}">
                <i class="bi bi-link-45deg"></i>
                {{ ucfirst($src) }}
                <span class="filter-count">{{ $sourceCounts[$src] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    {{-- ── Result count ────────────────────────────────────────── --}}
    @if ($recommendedContents->total() > 0)
        <p class="result-info">
            {{ __('messages.showing_results', [
                'from'  => $recommendedContents->firstItem(),
                'to'    => $recommendedContents->lastItem(),
                'total' => $recommendedContents->total(),
            ]) }}
        </p>
    @endif

    {{-- ── Content Grid ────────────────────────────────────────── --}}
    @if ($recommendedContents->count() > 0)
        <div class="content-grid">
            @foreach ($recommendedContents as $content)
                @php
                    $classification = $content->classification;
                    $dimension      = $classification->dimension ?? null;
                    $src            = strtolower($content->source ?? 'other');
                    $headerClass    = match($src) {
                        'youtube' => 'source-youtube',
                        'journal' => 'source-journal',
                        default   => 'source-other',
                    };
                    $headerIcon = match($src) {
                        'youtube' => 'bi-youtube',
                        'journal' => 'bi-journal-richtext',
                        default   => 'bi-file-earmark-text',
                    };
                @endphp

                <div class="content-card">
                    <div class="card-header-img {{ $headerClass }}">
                        <i class="bi {{ $headerIcon }}"></i>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title">{{ $content->title ?? 'Untitled' }}</h4>
                        <p class="card-desc">{{ $content->description ?? __('messages.no_description') }}</p>

                        @if ($content->url)
                            <div class="card-source">
                                <i class="bi bi-link-45deg"></i>
                                <span title="{{ $content->url }}">
                                    {{ parse_url($content->url, PHP_URL_HOST) ?? $content->url }}
                                </span>
                            </div>
                        @endif

                        <div class="card-meta">
                            <span class="badge source-{{ $src }}">
                                <i class="bi {{ $headerIcon }}" style="font-size:9px;"></i>
                                {{ ucfirst($content->source) }}
                            </span>

                            @if ($dimension)
                                <span class="badge dimension">{{ $dimension }}</span>
                            @endif
                        </div>

                        <div class="card-footer">
                            @if ($content->url)
                                <a href="{{ $content->url }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="card-link">
                                    <span>{{ __('messages.visit_source') }}</span>
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                            @else
                                <span style="font-size: 12px; color: var(--gray-400);">
                                    {{ __('messages.no_source_link') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Pagination ──────────────────────────────────────── --}}
        @if ($recommendedContents->hasPages())
            <div class="pagination-wrap">
                {{-- pagination tetap bawa query source --}}
                {{ $recommendedContents->appends(request()->query())->links() }}
            </div>
        @endif

    @else
        <div class="empty-box">
            <i class="bi bi-inbox"></i>
            <p>
                @if (request('source'))
                    {{ __('messages.no_content_for_source', ['source' => ucfirst(request('source'))]) }}
                @else
                    {{ __('messages.no_scraped_content') }}
                @endif
            </p>
            @if (request('source'))
                <a href="{{ route('modul.index') }}">
                    <i class="bi bi-arrow-left"></i>
                    {{ __('messages.filter_all') }}
                </a>
            @endif
        </div>
    @endif

@endsection