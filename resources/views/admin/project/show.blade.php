@extends('layouts.app')
@section('content')
<section class="container">
    <h1>{{ $project->name }}</h1>
    <p>{{ $project->description }}</p>
    <h2>{{ $project->language }}</h2>
    <h3>{{ $project->type->name }}</h3>
    <img src="{{asset('storage/'.$project->image)}}" alt="{{ $project->name }}">
</section>
@endsection
