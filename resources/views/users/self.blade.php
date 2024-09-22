@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">User Details</h1>

        @if (isset($user))
    <div class="product-actions">
        <a href="{{ route('users.update-self', Auth::user()->id) }}" class="primary-button">Edit Profile</a>
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

            <div class="details-table">
                <div class="details-container">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                </div>
            </div>

            <div class="button-group" style="margin-top: 20px;">
                <a href="javascript:history.back()" class="secondary-button">Back</a>
            </div>
        @else
            <p class="no-results">No Users Found</p>
            <div class="button-group">
                <a href="javascript:history.back()" class="secondary-button">Back</a>
            </div>
        @endif
    </div>
@endsection
