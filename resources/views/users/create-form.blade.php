@extends('layouts.main')

@section('title', $title)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create-form.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="page-title">Create New User</h1>

        <form action="{{ route('users.create-form') }}" method="post" class="create-form">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">-- Please select --</option>
                    <option value="ADMIN">Admin</option>
                    <option value="USER">User</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="primary-button ">Create User</button>
                <a href="{{ route('users.list') }}" class="delete-button ">Cancel</a>
            </div>
        </form>
    </div>

@endsection
