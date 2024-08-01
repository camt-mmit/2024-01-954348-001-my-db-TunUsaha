@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2 text-left">Code</th>
                    <th class="border p-2 text-left">Name</th>
                    <th class="border p-2 text-left">Owner</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                <tr class="hover:bg-gray-100">
                    <td class="border p-2">
                        <a href="{{ route('shops.view', $shop->code) }}" class="text-blue-600 hover:text-blue-800">{{ $shop->code }}</a>
                    </td>
                    <td class="border p-2">{{ $shop->name }}</td>
                    <td class="border p-2">{{ $shop->owner }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
