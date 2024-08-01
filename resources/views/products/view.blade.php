@extends('layouts.main')

@section('title', $title)

@section('content')
<main>
    <dl>
        <dt>Code</dt>
        <dd>{{ $product->code }}</dd>

        <dt>Name</dt>
        <dd>{{ $product->name }}</dd>

        <dt>Price</dt>
        <dd>{{ number_format($product->price, 2) }}</dd>
    </dl>
    <pre>{{ $product->description }}</pre>
</main>
@endsection
