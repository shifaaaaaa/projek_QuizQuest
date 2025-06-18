@extends('layouts.app')

@section('title', 'Edit User - Admin')

@push('styles')
<style>
    .edit-user-title {
        text-align: center;
        margin: 2rem 0;
        color: var(--dark3);
    }
    .edit-form-container {
        background-color: white;
        padding: 2rem;
        max-width: 600px;
        margin: auto;
        border-radius: 12px;
        box-shadow: 0 10px 18px rgba(0,0,0,0.2);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 0.8rem;
        border-radius: 8px;
        border: 1px solid var(--bright3);
    }
    .form-group button {
        background-color: var(--dark2);
        color: white;
        padding: 0.8rem 1.6rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    body.dark-mode .edit-user-title { color: var(--bright1); }
    body.dark-mode .edit-form-container { background-color: var(--dark4); }
    body.dark-mode .form-group label { color: var(--bright1); }
    body.dark-mode .form-group input, body.dark-mode .form-group select {
        background: var(--dark3);
        color: var(--bright1);
        border: 1px solid var(--dark2);
    }
    body.dark-mode .form-group button { background: var(--bright2); color: var(--dark4); }
</style>
@endpush

@section('content')
<h1 class="edit-user-title">Edit User: {{ $user->name }}</h1>

<div class="edit-form-container">
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <strong>Whoops! Something went wrong.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label for="password">New Password (leave blank if no change)</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        <div class="form-group">
            <label for="is_admin">Role</label>
            <select id="is_admin" name="is_admin" required>
                <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>User</option>
                <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Update User</button>
            <a href="{{ route('admin.users.index') }}" style="margin-left: 1rem; color: inherit;">Cancel</a>
        </div>
    </form>
</div>
@endsection