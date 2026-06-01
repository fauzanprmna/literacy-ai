@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('messages.manage_questions'))
@section('header', __('messages.question_list'))

@push('head')
<style>
    .page-topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    }
    .page-topbar p { font-size: 13px; color: var(--gray-400); }

    .btn-add {
        background: var(--green-700); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 9px 20px; font-size: 13px; font-weight: 700;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        transition: all .15s;
    }
    .btn-add:hover { background: var(--green-600); color: #fff; transform: translateY(-1px); }

    .alert-success {
        background: var(--green-50); border: 1px solid var(--green-100);
        border-left: 3px solid var(--green-500);
        border-radius: var(--radius-sm); padding: 12px 16px;
        font-size: 13px; color: var(--green-800);
        display: flex; align-items: center; gap: 9px; margin-bottom: 20px;
    }
    .alert-success i { color: var(--green-500); flex-shrink: 0; }

    .table-wrap {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: var(--gray-50); padding: 11px 18px;
        text-align: left; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .06em;
        color: var(--gray-400); border-bottom: 1px solid var(--gray-200);
    }
    thead th.center { text-align: center; }
    thead th.right  { text-align: right; }

    tbody td {
        padding: 13px 18px; font-size: 13px;
        color: var(--gray-700); border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: var(--gray-50); }
    td.td-num { color: var(--gray-400); font-size: 12px; }
    td.td-question { font-weight: 600; color: var(--gray-800); max-width: 340px; }
    td.td-center { text-align: center; }
    td.td-right { text-align: right; }

    .badge-cat {
        background: var(--green-50); color: var(--green-700);
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
        border: 1px solid var(--green-100);
        white-space: nowrap;
    }
    .badge-type {
        font-size: 10px; font-weight: 700;
        padding: 3px 8px; border-radius: 12px;
        white-space: nowrap;
    }
    .bt-likert { background: #cffafe; color: #155e75; }
    .bt-mc     { background: #ede9fe; color: #5b21b6; }
    .bt-text   { background: var(--gray-100); color: var(--gray-600); }

    .bobot-pill {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 24px; padding: 0 8px;
        border-radius: 20px;
        background: var(--gray-100); color: var(--gray-700);
        font-size: 12px; font-weight: 700;
    }

    .action-btns { display: inline-flex; gap: 5px; }
    .ab { padding: 5px 12px; border-radius: var(--radius-sm); font-size: 11px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .13s; display: inline-flex; align-items: center; gap: 4px; }
    .ab-view   { background: var(--gray-100); color: var(--gray-700); }
    .ab-view:hover   { background: var(--gray-200); }
    .ab-edit   { background: #fef3c7; color: #92400e; }
    .ab-edit:hover   { background: #fde68a; }
    .ab-delete { background: #fee2e2; color: #991b1b; }
    .ab-delete:hover { background: #fecaca; }

    .pagination-wrap { padding: 14px 18px; border-top: 1px solid var(--gray-100); }
    .empty-row td { text-align: center; color: var(--gray-400); padding: 36px !important; }
</style>
@endpush

@section('content')
    <div class="page-topbar">
        <p>{{ __('messages.manage_all_questions') }}</p>
        <a href="{{ route('question.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> {{ __('messages.add_question') }}
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
                    <th style="width:48px;">{{ __('messages.table_no') }}</th>
                    <th>{{ __('messages.question') }}</th>
                    <th>{{ __('messages.category') }}</th>
                    <th>Tipe</th>
                    <th class="center">{{ __('messages.bobot') }}</th>
                    <th class="right">{{ __('messages.table_actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    <tr>
                        <td class="td-num">{{ $loop->iteration + $questions->firstItem() - 1 }}</td>
                        <td class="td-question">
                            {{ \Illuminate\Support\Str::limit($question->translation->question, 60) }}
                        </td>
                        <td>
                            @if ($question->category)
                                <span class="badge-cat">{{ $question->category->name }}</span>
                            @else
                                <span style="color:var(--gray-300);">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $typeClass = match($question->type ?? 'text') {
                                    'likert'          => 'bt-likert',
                                    'multiple_choice' => 'bt-mc',
                                    default           => 'bt-text',
                                };
                                $typeLabel = match($question->type ?? 'text') {
                                    'likert'          => 'Likert',
                                    'multiple_choice' => 'Pilihan Ganda',
                                    default           => 'Text',
                                };
                            @endphp
                            <span class="badge-type {{ $typeClass }}">{{ $typeLabel }}</span>
                        </td>
                        <td class="td-center">
                            <span class="bobot-pill">{{ $question->bobot }}</span>
                        </td>
                        <td class="td-right">
                            <div class="action-btns">
                                <a href="{{ route('question.show', $question) }}" class="ab ab-view">
                                    <i class="bi bi-eye"></i> {{ __('messages.view') }}
                                </a>
                                <a href="{{ route('question.edit', $question) }}" class="ab ab-edit">
                                    <i class="bi bi-pencil"></i> {{ __('messages.edit') }}
                                </a>
                                <form action="{{ route('question.destroy', $question) }}" method="POST" class="inline"
                                    onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
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
                        <td colspan="6">
                            <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;color:var(--gray-200);"></i>
                            {{ __('messages.no_questions') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $questions->links() }}</div>
    </div>
@endsection