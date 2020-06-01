@extends('layouts.app')

@section('content')
    <div class="d-flex align-items" >
        <h1 class="mr-auto">BirdBoard</h1>
        <a href="{{ url('/projects/create') }}">Create a New Projects</a>
    </div>

    <ul>
        @forelse ($projects as $project) 
            <li>
                <a href="{{ url('projects/' . $project->id) }}">{{ $project->title }}</a>
            </li>
        @empty
            <li>No Project Yet</li>
        @endforelse
    </ul>
@endsection