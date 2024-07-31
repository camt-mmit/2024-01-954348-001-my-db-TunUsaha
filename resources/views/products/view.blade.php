@extends('layouts.main')

@section('title', $title)

@section('content')
<main>
    <dl>
        <dt>Code </dt>
        <dd>{{ $product->code }}</dd>

        <dt> Name</dt>
        <dd>{{ $product->name }}</dd>

        <dt> Price</dt>
        <dd>{{ number_format((float)) $product->code, 2 }}</dd>

        <pre>{{ $product->des</pre>
    </dl>
</main>
