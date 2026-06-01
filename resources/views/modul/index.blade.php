@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('messages.learning_modules'))
@section('header', __('messages.learning_modules'))

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

    /* ─── MAHASISWA: CATEGORY LIST ─────────────────────────── */
    .page-intro { font-size: 13px; color: var(--gray-400); margin-bottom: 20px; }

    .cat-list { display: flex; flex-direction: column; gap: 10px; }

    .cat-link {
        display: flex; align-items: center; gap: 14px;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        padding: 16px 18px;
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow-sm);
        transition: all .18s;
    }
    .cat-link:hover {
        border-color: var(--green-300);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
        color: inherit;
    }

    .cat-icon {
        width: 46px; height: 46px;
        border-radius: var(--radius-md);
        background: var(--green-50);
        color: var(--green-600);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        transition: background .15s;
    }
    .cat-link:hover .cat-icon { background: var(--green-100); }

    .cat-info { flex: 1; min-width: 0; }
    .cat-name { font-size: 14px; font-weight: 700; color: var(--gray-800); margin-bottom: 3px; }
    .cat-desc { font-size: 12px; color: var(--gray-400); line-height: 1.5;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .cat-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
    .cat-count { font-size: 18px; font-weight: 700; color: var(--gray-800); line-height: 1; }
    .cat-count-label { font-size: 10px; color: var(--gray-400); font-weight: 500; }
    .cat-chevron { color: var(--gray-400); font-size: 15px; transition: color .15s; }
    .cat-link:hover .cat-chevron { color: var(--green-600); }

    .empty-box {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        padding: 48px 24px;
        text-align: center;
    }
    .empty-box i { font-size: 2.5rem; color: var(--gray-200); display: block; margin-bottom: 12px; }
    .empty-box p { font-size: 13px; color: var(--gray-400); }

    /* ─── ADMIN: TABLE ─────────────────────────── */
    .admin-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }
    .admin-header p { font-size: 13px; color: var(--gray-400); }

    .btn-add {
        background: var(--green-700); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 9px 20px; font-size: 13px; font-weight: 700;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        transition: all .15s;
    }
    .btn-add:hover { background: var(--green-600); color: #fff; transform: translateY(-1px); }

    .table-wrap {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: var(--gray-50);
        padding: 11px 18px;
        text-align: left;
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .06em;
        color: var(--gray-400);
        border-bottom: 1px solid var(--gray-200);
    }
    thead th:last-child { text-align: right; }
    tbody td {
        padding: 13px 18px;
        font-size: 13px;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: var(--gray-50); }
    td.td-name { font-weight: 600; color: var(--gray-800); }
    td.td-actions { text-align: right; }

    .badge-cat {
        background: var(--green-50); color: var(--green-700);
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
        border: 1px solid var(--green-100);
    }

    .action-btns { display: inline-flex; gap: 6px; }
    .ab { padding: 5px 12px; border-radius: var(--radius-sm); font-size: 11px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .13s; }
    .ab-view   { background: var(--gray-100); color: var(--gray-700); }
    .ab-view:hover   { background: var(--gray-200); color: var(--gray-900); }
    .ab-edit   { background: #fef3c7; color: #92400e; }
    .ab-edit:hover   { background: #fde68a; }
    .ab-delete { background: #fee2e2; color: #991b1b; }
    .ab-delete:hover { background: #fecaca; }

    .pagination-wrap { padding: 14px 18px; border-top: 1px solid var(--gray-100); }
</style>
@endpush

@section('content')
    @if (Auth::user()->role === 'mahasiswa')
        <!-- ── MAHASISWA VIEW ── -->
        <p class="page-intro">{{ __('messages.choose_category_info') }}</p>

        @if (session('success'))
            <div class="alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
        @endif

        <div class="cat-list">
            @forelse($categories as $category)
                <a href="{{ route('modul.by-category', $category) }}" class="cat-link">
                    <div class="cat-icon"><i class="bi bi-folder2-open"></i></div>
                    <div class="cat-info">
                        <p class="cat-name">{{ $category->translation->name }}</p>
                        <p class="cat-desc">{{ $category->translation->description ?? __('messages.no_categories_available') }}</p>
                    </div>
                    <div class="cat-meta">
                        <span class="cat-count">{{ $category->moduls_count }}</span>
                        <span class="cat-count-label">{{ __('messages.modules') }}</span>
                    </div>
                    <i class="bi bi-chevron-right cat-chevron"></i>
                </a>
            @empty
                <div class="empty-box">
                    <i class="bi bi-inbox"></i>
                    <p>{{ __('messages.no_categories_available') }}</p>
                </div>
            @endforelse
        </div>

    @else
        <!-- ── ADMIN VIEW ── -->
        <div class="admin-header">
            <p>{{ __('messages.manage_modules') }}</p>
            <a href="{{ route('modul.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> {{ __('messages.add_module') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('messages.table_no') }}</th>
                        <th>{{ __('messages.table_module_name') }}</th>
                        <th>{{ __('messages.table_category') }}</th>
                        <th>{{ __('messages.table_content') }}</th>
                        <th>{{ __('messages.table_actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($moduls as $modul)
                        <tr>
                            <td>{{ $loop->iteration + $moduls->firstItem() - 1 }}</td>
                            <td class="td-name">{{ $modul->translation->name }}</td>
                            <td>
                                @if ($modul->category)
                                    <span class="badge-cat">{{ $modul->category->translation->name }}</span>
                                @else
                                    <span style="color:var(--gray-300)">—</span>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($modul->translation->isi ?? '—', 50) }}</td>
                            <td class="td-actions">
                                <div class="action-btns">
                                    <a href="{{ route('modul.show', $modul) }}" class="ab ab-view">{{ __('messages.view') }}</a>
                                    <a href="{{ route('modul.edit', $modul) }}" class="ab ab-edit">{{ __('messages.edit') }}</a>
                                    <form action="{{ route('modul.destroy', $modul) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.delete') }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ab ab-delete">{{ __('messages.delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:var(--gray-400);padding:32px;">
                                {{ __('messages.no_modules') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrap">{{ $moduls->links() }}</div>
        </div>
    @endif
@endsection