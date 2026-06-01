@extends('template.template-admin')

@section('title', 'Detail Kategori')
@section('header', 'Detail Kategori')

@push('head')
    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-600);
            text-decoration: none;
            padding: 8px 14px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            background: var(--white);
            transition: all .15s;
            margin-bottom: 20px;
        }

        .back-link:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .detail-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .detail-hero {
            background: linear-gradient(135deg, var(--green-800) 0%, var(--green-700) 100%);
            padding: 22px 26px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            position: relative;
            overflow: hidden;
        }

        .detail-hero::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .dh-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .dh-text {
            position: relative;
            z-index: 1;
        }

        .dh-title {
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .dh-chips {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .dh-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, .85);
        }

        .detail-section {
            padding: 18px 24px;
            border-bottom: 1px solid var(--gray-100);
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .detail-field {}

        .df-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--gray-400);
            margin-bottom: 5px;
        }

        .df-value {
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-800);
        }

        .badge-cat {
            background: var(--green-50);
            color: var(--green-700);
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid var(--green-100);
            display: inline-block;
        }

        .detail-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            text-decoration: none;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            transition: all .15s;
        }

        .btn-edit:hover {
            background: #fde68a;
        }

        .btn-del {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            background: #fee2e2;
            color: #991b1b;
            transition: all .15s;
        }

        .btn-del:hover {
            background: #fecaca;
        }

        @media (max-width: 576px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="detail-wrap">
        <a href="{{ route('category.index') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back_to_categories') }}
        </a>

        <div class="detail-card">
            <!-- Hero -->
            <div class="detail-hero">
                <div class="dh-icon"><i class="bi bi-tag"></i></div>
                <div class="dh-text">
                    <p class="dh-title">{{ $category->name_id ?? $category->name }}</p>
                    <div class="dh-chips">
                        <span class="dh-chip"><i class="bi bi-bookmark"></i> {{ __('messages.category') }}</span>
                        @if ($category->bobot)
                            <span class="dh-chip"><i class="bi bi-percent"></i> {{ __('messages.category_weight') }}: {{ $category->bobot }}%</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Translations -->
            @if ($category->translations && $category->translations->count() > 0)
                <div class="detail-section">
                    <p class="df-label" style="margin-bottom:12px;">{{ __('messages.category_name') }}</p>
                    <div class="detail-grid">
                        @foreach ($category->translations as $t)
                            <div class="detail-field">
                                <p class="df-label">
                                    {{ strtoupper($t->locale) === 'ID' ? '🇮🇩 Indonesia' : '🇬🇧 English' }}</p>
                                <p class="df-value">{{ $t->name }}</p>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

            @if ($category->translations && $category->translations->count() > 0)
                <div class="detail-section">
                    <p class="df-label" style="margin-bottom:12px;">{{ __('messages.category_description') }}</p>
                    <div class="detail-grid">
                        @foreach ($category->translations as $t)
                            <div class="detail-field">
                                <p class="df-label">
                                    {{ strtoupper($t->locale) === 'ID' ? '🇮🇩 Indonesia' : '🇬🇧 English' }}</p>
                                <p class="df-value">{{ $t->description }}</p>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif


            <!-- Actions -->
            <div class="detail-section" style="display: flex; align-items: center; justify-content: space-between;">
                <div></div>
                <div class="detail-actions">
                    <a href="{{ route('category.edit', $category) }}" class="btn-edit">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('category.destroy', $category) }}" style="display: inline;"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-del">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
