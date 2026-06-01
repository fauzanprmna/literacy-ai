@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', __('messages.add_answer_template'))
@section('header', __('messages.add_answer_template'))

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
    </style>
@endpush
@section('content')
    <div class="max">
        <a href="{{ route('answer-template.index') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back') }}
        </a>

        <div>
            <form action="{{ route('answer-template.store') }}" method="POST">
                @csrf
                @include('answer-template._form', [
                    'template' => new \App\Models\AnswerTemplate(),
                    'buttonText' => __('messages.save'),
                ])
            </form>
        </div>
    </div>
@endsection
