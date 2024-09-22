@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">User: Edit</h1>

        <form action="{{ route('users.update', $user->id) }}" method="post" class="search-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="price-input" value="{{ $user->email }}" >
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="price-input" value="{{ $user->name }}"
                    required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="price-input" placeholder="Leave blank if you don't want to change">
            </div>

            <div class="form-group">
                <p><strong>Role:</strong> {{ $user->role }}</p>
            </div>


            <div class="button-group">
                <button type="submit" class="primary-button">Update User</button>
                <a href="javascript:history.back()" class="secondary-button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
