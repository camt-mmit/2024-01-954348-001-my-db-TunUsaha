@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="content-wrapper">
        <!-- <form action="{{ route('users.list') }}" method="get" class="search-form">
            <div class="search-container">
                <label class="app-inp-search">
                    <label>Search <span class="separator text-blue-600">::</span></label>
                    <input type="text" name="term" value="{{ $search['term'] ?? '' }}" class="search-input"
                        placeholder="Search by email, name or role" />
                </label>
            </div>
            <div class="button-group">
                <button type="submit" class="primary-button">Search</button>
                <a href="{{ route('users.list') }}" class="secondary-button">Clear</a>
            </div>
        </form> -->
        <a href="{{ route('users.create-form') }}" class="new-product-button">New User</a>

        @if (isset($users) && count($users) > 0)
            <table class="product-table" mt-6>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        session()->put('bookmark.users.view', url()->full());
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users.view', $user->email) }}">{{ $user->email }}</a>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $users->links() }}
            </div>
        @else
            <p class="no-results">No users found.</p>
        @endif
    </div>
@endsection
