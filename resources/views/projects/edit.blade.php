@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-5">
        Let's start somethink new
    </h1>
    <form method="POST" action="{{ $project->path() }}">
        @csrf
        @method('PATCH')
    @include('projects._form', ['ButtonText' => 'Update Project'])
    
</form>
@endsection