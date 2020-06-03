@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-5">
        Let's start somethink new
    </h1>
    <form method="POST" action="{{ url('/projects') }}">
        @csrf
    @include('projects._form', ['project' => new App\Project], ['ButtonText' => 'Create Project'])
    
</form>
@endsection