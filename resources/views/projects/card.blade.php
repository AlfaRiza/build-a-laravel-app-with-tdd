    <div class="card bg-white p-5 rounded-lg pb-3" style="max-height: 200px; box-shadow: 3px 3px 5px 3px rgba(0,0,0,0.08)";>
        <h3 class="text-xl font-normal py-4 -ml-5 border-l-4 border-blue-400 pl-4 mb-3">
            <a href="{{ $project->path() }}"> {{ $project->title }}</a>
        </h3>
        <div class="text-gray-500">{{ Str::limit($project->description,50,' ...') }}</div>
    </div>