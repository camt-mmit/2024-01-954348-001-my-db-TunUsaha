@extends('layouts.main')

@section('title', $title)

@section('content')
<a href="javascript:history.back()" class="back-button" aria-label="ย้อนกลับ">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
        <path
            d="M23.5587,16.916 C24.1447,17.4999987 24.1467,18.446 23.5647,19.034 L16.6077,26.056 C16.3147,26.352 15.9287,26.4999987 15.5427,26.4999987 C15.1607,26.4999987 14.7787,26.355 14.4867,26.065 C13.8977,25.482 13.8947,24.533 14.4777,23.944 L20.3818,17.984 L14.4408,12.062 C13.8548,11.478 13.8528,10.5279 14.4378,9.941 C15.0218,9.354 15.9738,9.353 16.5588,9.938 L23.5588,16.916 L23.5587,16.916 Z">
        </path>
    </svg>
</a>
    <div class="content-wrapper">
        <h1 class="page-title">User List</h1>
        <form action="{{ route('users.list') }}" method="get" class="search-form">
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
        </form>
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
