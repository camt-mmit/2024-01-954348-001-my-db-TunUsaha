@extends('layouts.main')

@section('title', $title)

@section('content')
<form action="{{ route('products.create-form') }}" method="post">
    @csrf

    <label>Code <input type="text" name="code" /></label><br />
    <label>Name <input type="text" name="name" /></label><br />
    <label>Price <input type="number" step="any" name="price" /></label><br />
    <label>
        Description
        <textarea name="description" cols="80" rows="10"></textarea>
    </label><br />

    <button type="submit">Create</button>
</form>n
