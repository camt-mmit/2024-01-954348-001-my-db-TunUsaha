@extends('layouts.main')

@section('title', $title)

@section('content')
<main>
    <dl class="grid grid-cols-2 gap-4">
        <dt class="font-bold">Code</dt>
        <dd>{{ $shop->code }}</dd>

        <dt class="font-bold">Name</dt>
        <dd>{{ $shop->name }}</dd>

        <dt class="font-bold">Owner</dt>
        <dd>{{ $shop->owner }}</dd>

        <dt class="font-bold">Latitude</dt>
        <dd>{{ number_format($shop->latitude, 6) }}° N</dd>

        <dt class="font-bold">Longitude</dt>
        <dd>{{ number_format($shop->longitude, 6) }}° E</dd>

        <dt class="font-bold">Address</dt>
        <dd>{{ $shop->address }}</dd>
    </dl>
</main>
@endsection
