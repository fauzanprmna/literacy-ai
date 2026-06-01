@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('messages.answer_templates'))
@section('header', __('messages.answer_templates'))

@push('head')
<style>
    .page-topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    }
    .page-topbar p { font-size: 13px; color: var(--gray-400); }
    .btn-add {
        background: var(--green-700); color: #fff; border: none;
        border-radius: var(--radius-sm); padding: 9px 20px;
        font-size: 13px; font-weight: 700; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px; transition: all .15s;
    }
    .btn-add:hover { background: var(--green-600); color: #fff; transform: translateY(-1px); }

    .alert-success {
        background: var(--green-50); border: 1px solid var(--green-100);
        border-left: 3px solid var(--green-500); border-radius: var(--radius-sm);
        padding: 12px 16px; font-size: 13px; color: var(--green-800);
        display: flex; align-items: center; gap: 9px; margin-bottom: 20px;
    }
    .alert-success i { color: var(--green-500); flex-shrink: 0; }

    .table-wrap {
        background: var(--white); border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: var(--gray-50); padding: 11px 18px; text-align: left;
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--gray-400); border-bottom: 1px solid var(--gray-200);
    }
    thead th.right { text-align: right; }
    thead th.center { text-align: center; }
    tbody td {
        padding: 13px 18px; font-size: 13px; color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100); vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: var(--gray-50); }
    td.td-name { font-weight: 600; color: var(--gray-800); }
    td.td-right { text-align: right; }
    td.td-center { text-align: center; }

    .answers-preview {
        display: flex; flex-wrap: wrap; gap: 5px;
    }
    .ans-chip {
        display: inline-flex; align-items: center; gap: 4px;
        background: var(--green-50); color: var(--green-700);
        border: 1px solid var(--green-100);
        border-radius: 12px; padding: 2px 9px;
        font-size: 11px; font-weight: 600;
    }
    .ans-chip .bobot { color: var(--gray-400); font-weight: 500; }

    .action-btns { display: inline-flex; gap: 5px; }
    .ab { padding: 5px 12px; border-radius: var(--radius-sm); font-size: 11px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .13s; display: inline-flex; align-items: center; gap: 4px; }
    .ab-view   { background: var(--gray-100); color: var(--gray-700); }
    .ab-view:hover   { background: var(--gray-200); }
    .ab-edit   { background: #fef3c7; color: #92400e; }
    .ab-edit:hover   { background: #fde68a; }
    .ab-delete { background: #fee2e2; color: #991b1b; }
    .ab-delete:hover { background: #fecaca; }

    .empty-row td { text-align: center; color: var(--gray-400); padding: 36px !important; }
    .pagination-wrap { padding: 14px 18px; border-top: 1px solid var(--gray-100); }
</style>
@endpush

@section('content')
    <div class="page-topbar">
        <p>Kelola template jawaban yang digunakan untuk soal Likert.</p>
        <a href="{{ route('answer-template.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Template
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nama Template</th>
                    <th>Pilihan Jawaban</th>
                    <th class="center">Jumlah Opsi</th>
                    <th class="right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr>
                        <td style="color:var(--gray-400);font-size:12px;">{{ $loop->iteration + ($templates->firstItem() - 1) }}</td>
                        <td class="td-name">{{ $template->translation->name }}</td>
                        <td>
                            <div class="answers-preview">
                                @foreach ($template->defaultAnswers->take(5) as $ans)
                                    <span class="ans-chip">
                                        {{ $ans->translation->name }}
                                        <span class="bobot">({{ $ans->bobot }})</span>
                                    </span>
                                @endforeach
                                @if ($template->defaultAnswers->count() > 5)
                                    <span style="font-size:11px;color:var(--gray-400);">+{{ $template->defaultAnswers->count() - 5 }} lagi</span>
                                @endif
                            </div>
                        </td>
                        <td class="td-center">
                            <span style="background:var(--gray-100);color:var(--gray-700);font-size:12px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                {{ $template->defaultAnswers->count() }}
                            </span>
                        </td>
                        <td class="td-right">
                            <div class="action-btns">
                                <a href="{{ route('answer-template.show', $template) }}" class="ab ab-view">
                                    <i class="bi bi-eye"></i> {{ __('messages.view') }}
                                </a>
                                <a href="{{ route('answer-template.edit', $template) }}" class="ab ab-edit">
                                    <i class="bi bi-pencil"></i> {{ __('messages.edit') }}
                                </a>
                                <form action="{{ route('answer-template.destroy', $template) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ab ab-delete">
                                        <i class="bi bi-trash"></i> {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="5">
                            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;color:var(--gray-200);"></i>
                            Belum ada template jawaban.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if (method_exists($templates, 'links'))
            <div class="pagination-wrap">{{ $templates->links() }}</div>
        @endif
    </div>
@endsection