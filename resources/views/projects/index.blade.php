@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full">
            <h2 class="text-gray-400 text-sm font-normal">My Project</h2>
            <a href="{{ url('/projects/create') }}" class="text-gray-600 no-underline bg-blue-400 hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded">New Projects</a>
        </div>
    </header>

    <main class="lg:flex flex-wrap -mx-3">
        @forelse ($projects as $project) 
        <div class="lg:w-1/3 px-3 pb-6">
            <div class="bg-white p-5 rounded-lg pb-3" style="height: 200px; box-shadow: 3px 3px 5px 3px rgba(0,0,0,0.08)";>
                <h3 class="text-xl font-normal py-4 -ml-5 border-l-4 border-blue-400 pl-4 mb-3">
                    <a href="{{ $project->path() }}"> {{ $project->title }}</a>
                </h3>
                <div class="text-gray-500">{{ Str::limit($project->description,100,' ...') }}</div>
            </div>
        </div>
        @empty
            <div>No Project Yet</div>
        @endforelse
    </main>
@endsection