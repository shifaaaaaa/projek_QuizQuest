@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@push('styles')
<style>
    .manage-users-title {
        text-align: center;
        margin-top: 2rem;
        margin-bottom: 2rem;
        color: var(--dark3);
    }
    .users-container {
        max-width: 1000px;
        margin: auto;
        padding: 1rem;
    }
    .users-table {
        width: 100%;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        overflow: hidden;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .actions a, .actions button {
        margin-right: 0.5rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        text-decoration: none;
        color: white;
        border: none;
        cursor: pointer;
    }
    .edit-btn { background-color: var(--dark1); }
    .delete-btn { background-color: #f05959; }

    body.dark-mode .manage-users-title { color: var(--bright1); }
    body.dark-mode .users-table { background-color: var(--dark4); }
    body.dark-mode th { background-color: var(--dark3); border-bottom-color: var(--dark2); }
    body.dark-mode td { border-bottom-color: var(--dark3); }
</style>
@endpush

@section('content')
<h1 class="manage-users-title">Manage Users</h1>
<div class="users-container">
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="users-table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span style="background-color: {{ $user->is_admin ? 'var(--bright2)' : '#6c757d' }}; color: white; padding: 0.2rem 0.5rem; border-radius: 5px; font-size: 0.8rem;">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem;">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 2rem;">
        {{ $users->links() }}
    </div>
</div>
@endsection