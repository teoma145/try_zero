@extends('layouts.app')
@section('content')
    <h1>{{ $type->name }}</h1>
    <ul>
    @foreach($type->projects as $project)

        <li>{{ $project->name }}</li>
    @endforeach
    </ul>
@endsection
