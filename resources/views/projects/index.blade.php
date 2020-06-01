@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full">
            <h2 class="text-gray-500 text-sm font-normal">My Project</h2>

            <a href="{{ url('/projects/create') }}" class="text-gray-600 no-underline bg-blue-400 hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded">New Projects</a>
        </div>
    </header>

    <main class="lg:flex flex-wrap -mx-3">
        @forelse ($projects as $project) 
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>No Project Yet</div>
        @endforelse
    </main>
@endsection