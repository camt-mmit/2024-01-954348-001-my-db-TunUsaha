@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">User Details</h1>

        @if (isset($user))
            <div class="product-actions">
                <a href="{{ route('users.edit-form', $user->id) }}" class="primary-button">Edit User</a>
                @can('delete', $user)
    @if (Auth::user()->id !== $user->id)
        <form id="deleteForm" action="{{ route('users.delete', $user->id) }}" method="post" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="button" class="delete-button" onclick="showConfirmation()">Delete User</button>
        </form>
    @endif
@endcan


            </div>
            <div id="confirmationModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to delete this user?</p>
                    <button onclick="confirmDelete()">Yes, Delete</button>
                    <button onclick="closeModal()">Cancel</button>
                </div>
            </div>

            <div class="details-table">
                <div class="details-container">
                    <p class="text-3xl text-blue-600">{{ $user->id }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Role:</strong> {{ $user->role }}</p>
                </div>
            </div>

            <div class="button-group" style="margin-top: 20px;">
                <a href="{{ route('users.list') }}" class="go-back-button">Back to Users List</a>
            </div>
        @else
            <p class="no-results">No Users Found</p>
            <div class="button-group">
                <a href="{{ session()->get('bookmark.users.view', route('users.list')) }}" class="go-back-button">Back
                    to Users List</a>
            </div>
        @endif
    </div>
@endsection
