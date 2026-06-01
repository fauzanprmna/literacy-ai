@extends('template.template-admin')

@section('title', 'Edit User')
@section('header', 'Edit User')

@push('head')
    <style>
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--gray-100);
            color: var(--gray-700);
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 20px;
            transition: all .15s;
        }

        .btn-back:hover {
            background: var(--gray-200);
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    <div class="max">
        <a href="{{ route('user.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <div>
            <form action="{{ route('user.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                @include('user._form', ['user' => $user, 'buttonText' => 'Perbarui'])
            </form>
        </div>
    </div>
@endsection
