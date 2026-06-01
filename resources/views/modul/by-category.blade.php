@extends('template.template-mahasiswa')

@section('title', $category->translation->name . ' - Modul')
@section('header', 'Modul Pembelajaran')

@push('head')
<style>
    /* ─── BREADCRUMB ─────────────────────────── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--gray-600);
        margin-bottom: 20px;
        padding: 10px 14px;
        background: var(--gray-50);
        border-radius: 6px;
    }

    .breadcrumb a {
        color: var(--green-700);
        text-decoration: none;
        font-weight: 600;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    /* ─── CATEGORY HEADER ─────────────────────────── */
    .category-header {
        background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
        border-radius: 8px;
        padding: 24px 28px;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .ch-icon {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        background: rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .ch-content h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .ch-content p {
        font-size: 13px;
        opacity: .7;
    }

    /* ─── MODULE CARD ─────────────────────────── */
    .module-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .module-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        overflow: hidden;
        transition: all .2s;
    }

    .module-card:hover {
        border-color: var(--green-300);
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
        transform: translateY(-2px);
    }

    .module-card-inner {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        text-decoration: none;
        color: inherit;
    }

    .module-icon {
        width: 44px;
        height: 44px;
        border-radius: 6px;
        background: var(--green-50);
        color: var(--green-600);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        transition: background .2s;
    }

    .module-card:hover .module-icon {
        background: var(--green-100);
    }

    .module-body {
        flex: 1;
        min-width: 0;
    }

    .module-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 4px;
    }

    .module-card:hover .module-name {
        color: var(--green-700);
    }

    .module-desc {
        font-size: 12px;
        color: var(--gray-600);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 6px;
    }

    .module-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .module-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--green-50);
        color: var(--green-600);
        font-size: 10px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
        border: 1px solid var(--green-100);
    }

    .module-arrow {
        color: var(--gray-400);
        font-size: 16px;
        flex-shrink: 0;
        transition: color .2s;
    }

    .module-card:hover .module-arrow {
        color: var(--green-600);
    }

    /* ─── EMPTY STATE ─────────────────────────── */
    .empty-box {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
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
        color: var(--gray-600);
    }

    @media (max-width: 640px) {
        .category-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .ch-content h2 {
            font-size: 18px;
        }

        .module-card-inner {
            flex-direction: column;
            text-align: center;
        }

        .module-icon {
            width: 48px;
            height: 48px;
        }
    }
</style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('modul.index') }}"><i class="bi bi-house"></i> Modul</a>
        <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
        <span>{{ $category->translation->name }}</span>
    </div>

    <!-- Category Header -->
    <div class="category-header">
        <div class="ch-icon"><i class="bi bi-folder2-open"></i></div>
        <div class="ch-content">
            <h2>{{ $category->translation->name }}</h2>
            @if ($category->translation->description)
                <p>{{ $category->translation->description }}</p>
            @endif
        </div>
    </div>

    <!-- Module List -->
    <div class="module-list">
        @forelse($moduls as $modul)
            <a href="{{ route('modul.showContent', $modul) }}" class="module-card">
                <div class="module-card-inner">
                    <div class="module-icon">
                        @if ($modul->kategoriModul)
                            <i class="bi bi-{{ ['book' => 'book', 'video' => 'play-circle-fill', 'file' => 'file-earmark-fill', 'link' => 'link-45deg'][$modul->kategoriModul->name] ?? 'bookmark-fill' }}"></i>
                        @else
                            <i class="bi bi-file-earmark-text-fill"></i>
                        @endif
                    </div>
                    <div class="module-body">
                        <p class="module-name">{{ $modul->translation->name ?? $modul->name }}</p>
                        @if ($modul->translation->isi ?? $modul->isi)
                            <p class="module-desc">{{ Str::limit($modul->translation->isi ?? $modul->isi, 120) }}</p>
                        @endif
                        <div class="module-meta">
                            @if ($modul->kategoriModul)
                                <span class="module-tag">
                                    <i class="bi bi-tag"></i> {{ $modul->kategoriModul->name }}
                                </span>
                            @endif
                            @if ($modul->link)
                                <span class="module-tag">
                                    <i class="bi bi-link-45deg"></i> {{ __('modul.has_link') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <i class="bi bi-chevron-right module-arrow"></i>
                </div>
            </a>
        @empty
            <div class="empty-box">
                <i class="bi bi-inbox"></i>
                <p>{{ __('messages.no_modules') }}</p>
            </div>
        @endforelse
    </div>

@endsection