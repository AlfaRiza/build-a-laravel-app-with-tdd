@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full">
            <p class="text-gray-500 text-sm font-normal">
                <a href="{{ url('/projects') }}" class="text-gray-500 text-sm font-normal no-underline">My Project</a> / {{ $project->title }}
            </p>

            <div class="flex items-center">
                @foreach ($project->members as $member)
                    <img src="{{ garvatar_url($member->email) }}"  class="rounded-full w-8 mr-2" alt="{{ $member->name }}'s avatar">
                @endforeach
                    <img src="{{ garvatar_url($project->owner->email) }}" alt="{{ $member->name }}'s avatar">
                <a href="{{ $project->path() . '/edit' }}" class="text-gray-600 no-underline bg-blue-400 hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded ml-4">Edit Projects</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-gray-600 text-lg font-normal mb-3">My Project</h2>

                    @foreach ($project->tasks as $task)
                        <h2 class="card py-3 px-3 mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-400' : '' }}" >
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </h2>
                    @endforeach
                            <h2 class="card py-3 px-3 mb-3">
                                <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                @csrf
                                    <input type="text" placeholder="Add a New Tasks " class="w-full" name="body">
                                </form>
                            </h2>
                </div>
                <div class="">
                    <h2 class="text-gray-600 text-lg font-normal">General Notes</h2>
                    <form method="POST" action="{{ $project->path() }}">
                        @csrf   
                        @method('PATCH')
                        
                        <textarea class="card w-full" name="notes" style="min-height: 200px" placeholder="Anything what you do ... ">{{ $project->notes }}</textarea>

                        <button type="submit" class="text-gray-600 no-underline bg-blue-400 hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded">Save</button>
                    </form>

                    @include('projects.errors')
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                
                @include('projects.activity.cards')
                
                @can ('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>
    
@endsection