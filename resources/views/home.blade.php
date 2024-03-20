@extends('layouts.app')
@section('content')
    <section class="container">
        <h1>I miei progetti</h1>
        <a href="{{ route('admin.projects.index') }}">vai</a>
        <h1>types</h1>
        <a href="{{ route('admin.types.index') }}">vai</a>
    </section>
@endsection

