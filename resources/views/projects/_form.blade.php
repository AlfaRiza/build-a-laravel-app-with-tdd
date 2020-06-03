

        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $project->title }}" required>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Deskripsi</label>
            <textarea class="form-control" required id="description" name="description" rows="3">{{ $project->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ $ButtonText }}</button>
        <a href="{{ $project->path() }}">Cancel</a>

</div>

@if ($errors->any())
    <div class="field mt-6">
        @foreach ($errors->all() as $error)
            <li class="text-sm text-red-400">{{ $error }}</li>
        @endforeach
    </div>
@endif
