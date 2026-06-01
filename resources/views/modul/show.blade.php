


@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Konten Modul')
@section('header', 'Konten Modul')

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

    /* ─── CONTENT HEADER ─────────────────────────── */
    .content-header {
        background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
        border-radius: 8px;
        padding: 20px 24px;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .ch-icon {
        width: 44px;
        height: 44px;
        border-radius: 6px;
        background: rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .ch-text h3 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .ch-text p {
        font-size: 12px;
        opacity: .7;
    }

    /* ─── CONTENT CARD ─────────────────────────── */
    .content-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .content-body {
        padding: 28px;
    }

    /* ─── TEXT CONTENT STYLES ─────────────────────────── */
    .text-content {
        line-height: 1.8;
        color: var(--gray-800);
    }

    .text-content h1, .text-content h2, .text-content h3,
    .text-content h4, .text-content h5, .text-content h6 {
        margin: 20px 0 12px;
        font-weight: 700;
        color: var(--gray-900);
    }

    .text-content h1 { font-size: 24px; }
    .text-content h2 { font-size: 20px; }
    .text-content h3 { font-size: 16px; }
    .text-content h4 { font-size: 14px; }

    .text-content p {
        margin-bottom: 14px;
    }

    .text-content ul, .text-content ol {
        margin: 12px 0 12px 24px;
    }

    .text-content li {
        margin-bottom: 6px;
    }

    .text-content blockquote {
        border-left: 3px solid var(--green-500);
        padding: 12px 0 12px 16px;
        margin: 14px 0;
        color: var(--gray-700);
        background: var(--gray-50);
        border-radius: 6px;
        font-style: italic;
    }

    .text-content pre {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        padding: 14px 16px;
        overflow-x: auto;
        margin: 14px 0;
        font-size: 12px;
        line-height: 1.6;
        font-family: 'Courier New', monospace;
    }

    .text-content code {
        background: var(--gray-100);
        color: #c7254e;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
        font-family: 'Courier New', monospace;
    }

    .text-content pre code {
        background: none;
        color: var(--gray-700);
        padding: 0;
    }

    .text-content a {
        color: var(--green-700);
        font-weight: 500;
        text-decoration: underline;
    }

    .text-content a:hover {
        color: var(--green-800);
    }

    .text-content img {
        max-width: 100%;
        height: auto;
        margin: 14px 0;
        border-radius: 6px;
        border: 1px solid var(--gray-200);
    }

    .text-content table {
        width: 100%;
        margin: 14px 0;
        border-collapse: collapse;
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        overflow: hidden;
    }

    .text-content th, .text-content td {
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }

    .text-content th {
        background: var(--gray-50);
        font-weight: 700;
    }

    .text-content tr:last-child td {
        border-bottom: none;
    }

    /* ─── FILE DISPLAY ─────────────────────────── */
    .file-display {
        text-align: center;
        padding: 32px 20px;
    }

    .fd-icon {
        width: 72px;
        height: 72px;
        border-radius: 8px;
        background: var(--green-50);
        color: var(--green-600);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 16px;
    }

    .fd-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 6px;
    }

    .fd-size {
        font-size: 12px;
        color: var(--gray-600);
        margin-bottom: 20px;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 26px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        background: var(--green-700);
        color: #fff;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s;
        box-shadow: 0 2px 8px rgba(26,92,64,.2);
    }

    .btn-download:hover {
        background: var(--green-600);
        transform: translateY(-1px);
    }

    /* ─── VIDEO/LINK DISPLAY ─────────────────────────── */
    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 8px;
    }

    .link-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--gray-600);
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .link-display {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        font-size: 13px;
        color: var(--gray-700);
    }

    .link-display a {
        color: var(--green-700);
        font-weight: 700;
        text-decoration: none;
        word-break: break-all;
    }

    .link-display a:hover {
        text-decoration: underline;
    }

    /* ─── NAVIGATION ─────────────────────────── */
    .content-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 24px;
        padding: 16px 0;
        border-top: 1px solid var(--gray-200);
    }

    .nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 6px;
        text-decoration: none;
        transition: all .2s;
        border: none;
        cursor: pointer;
    }

    .nav-btn.prev {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .nav-btn.prev:hover {
        background: var(--gray-200);
        color: var(--gray-800);
    }

    .nav-btn.next {
        background: var(--green-700);
        color: #fff;
    }

    .nav-btn.next:hover {
        background: var(--green-600);
        transform: translateY(-1px);
    }

    /* ─── ADMIN PANEL ─────────────────────────── */
    .admin-section {
        border-top: 1px solid var(--gray-200);
        padding: 16px 0;
        margin-top: 16px;
    }

    .admin-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--gray-600);
        margin-bottom: 10px;
        letter-spacing: .05em;
    }

    .admin-actions {
        display: flex;
        gap: 8px;
    }

    .btn-admin {
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all .2s;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-edit:hover {
        background: #fde68a;
    }

    @media (max-width: 640px) {
        .content-header {
            flex-direction: column;
            text-align: center;
            padding: 16px;
        }

        .content-nav {
            flex-direction: column;
            gap: 10px;
        }

        .nav-btn {
            width: 100%;
            justify-content: center;
        }

        .content-body {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('modul.index') }}"><i class="bi bi-house"></i> {{ __('modul.module') }}</a>
        <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
        <a href="{{ route('modul.by-category', $content->modul->category->id) }}">{{ $content->modul->category->translation->name }}</a>
        <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
        <span>{{ $content->modul->translation->name }}</span>
    </div>

    <!-- Content Header -->
    <div class="content-header">
        <div class="ch-icon">
            @if ($content->type === 'text')
                <i class="bi bi-file-earmark-text"></i>
            @elseif ($content->type === 'file')
                <i class="bi bi-file-earmark-arrow-down"></i>
            @elseif ($content->type === 'link')
                <i class="bi bi-play-circle"></i>
            @else
                <i class="bi bi-file-earmark"></i>
            @endif
        </div>
        <div class="ch-text">
            <h3>{{ $content->modul->translation->name }}</h3>
            <p>
                @if ($content->type === 'text')
                    {{ __('modul.text_material') }}
                @elseif ($content->type === 'file')
                    {{ __('modul.download_file') }}
                @elseif ($content->type === 'link')
                    {{ __('modul.video_link') }}
                @endif
            </p>
        </div>
    </div>

    <!-- Content Display -->
    <div class="content-card">
        <div class="content-body">

            {{-- TEXT CONTENT --}}
            @if ($content->type === 'text')
                <div class="text-content">
                    @if (app()->getLocale() === 'id')
                        {!! $content->content_id !!}
                    @else
                        {!! $content->content_en !!}
                    @endif
                </div>
            @endif

            {{-- FILE CONTENT --}}
            @if ($content->type === 'file')
                <div class="file-display">
                    <div class="fd-icon"><i class="bi bi-file-earmark-arrow-down"></i></div>
                    <p class="fd-name">{{ basename($content->file_path) }}</p>
                    <p class="fd-size">{{ __('modul.file_download') }}</p>
                    <a href="{{ route('file.download', $content->id) }}" class="btn-download">
                        <i class="bi bi-download"></i> {{ __('modul.download_button') }}
                    </a>
                </div>
            @endif

            {{-- VIDEO/LINK CONTENT --}}
            @if ($content->type === 'link')
                <div>
                    @php
                        $isYouTube = preg_match('/youtube\.com|youtu\.be/', $content->url);
                        $isVimeo = preg_match('/vimeo\.com/', $content->url);
                        $embedUrl = '';

                        if ($isYouTube) {
                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $content->url, $matches);
                            if ($matches[1] ?? null) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                            }
                        } elseif ($isVimeo) {
                            preg_match('/vimeo\.com\/(\d+)/', $content->url, $matches);
                            if ($matches[1] ?? null) {
                                $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                            }
                        }
                    @endphp

                    @if ($embedUrl)
                        <div class="video-container">
                            <iframe src="{{ $embedUrl }}" allowfullscreen allow="autoplay"></iframe>
                        </div>
                    @endif

                    <p class="link-label">{{ __('modul.external_link') }}</p>
                    <div class="link-display">
                        <i class="bi bi-link-45deg"></i>
                        <a href="{{ $content->url }}" target="_blank" rel="noopener noreferrer">
                            {{ Str::limit($content->url, 60) }}
                        </a>
                    </div>
                </div>
            @endif

        </div>

        <!-- Navigation & Admin Section -->
        <div>
            <div class="content-nav">
                @if ($prevContent)
                    <a href="{{ route('modul.showContent', $prevContent->id) }}" class="nav-btn prev">
                        <i class="bi bi-chevron-left"></i> {{ __('modul.previous') }}
                    </a>
                @else
                    <div></div>
                @endif
                @if ($nextContent)
                    <a href="{{ route('modul.showContent', $nextContent->id) }}" class="nav-btn next">
                        {{ __('modul.next') }} <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <div></div>
                @endif
            </div>

            {{-- ADMIN PANEL --}}
            @if (Auth::user()->role === 'admin')
                <div class="admin-section">
                    <p class="admin-label">{{ __('modul.admin_panel') }}</p>
                    <div class="admin-actions">
                        <a href="{{ route('modul.edit', $content->modul->id) }}" class="btn-admin btn-edit">
                            <i class="bi bi-pencil"></i> {{ __('modul.edit_module') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection