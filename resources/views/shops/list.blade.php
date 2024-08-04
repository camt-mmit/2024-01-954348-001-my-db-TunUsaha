@extends('layouts.main')

@section('title', $title)

@section('content')
    <table class="app-cmp-data-list-shop">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Owner</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shops as $shop)
            <tr>
                <td>
                    <a href="{{ route('shops.view', $shop->code) }}">{{ $shop->code }}</a>
                </td>
                <td>{{ $shop->name }}</td>
                <td>{{ $shop->owner }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection