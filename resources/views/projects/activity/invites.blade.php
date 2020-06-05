{{-- Card --}}
<div class="card bg-white p-5 rounded-lg pb-3 flex flex-col mt-3" >
    <h3 class="text-xl font-normal py-4 -ml-5 border-l-4 border-blue-400 pl-4 mb-3">
        Invite a User
    </h3>
    <div class="text-gray-500 mb-4 flex-1">{{ Str::limit($project->description,50,' ...') }}</div>

    <footer>
        <form method="POST" action="{{ $project->path() . '/invitations' }}" class="text-right">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="border border-gray-400 rounded w-full py-2 px-3" placeholder="Email address">
            </div>
            <button type="submit" class="text-gray-600 no-underline bg-blue-400 hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded">Invite</button>
        </form>

        @include('projects.errors', ['bag' => 'invitations'])
    </footer>
</div>
{{-- End card --}}