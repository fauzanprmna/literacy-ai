@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Edit Category')
@section('header', 'Edit Category')

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
        <a href="{{ route('category.index') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back_to_categories') }}
        </a>

        <div>
            <form action="{{ route('category.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                @include('category._form', ['category' => $category, 'buttonText' => 'Update'])
            </form>
        </div>
    </div>
@endsection
