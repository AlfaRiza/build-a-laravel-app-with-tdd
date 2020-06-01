@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-5">Create a Project</h1>
        <form method="POST" action="{{ url('/projects') }}">
            @csrf

            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" class="form-control" id="title" name="title" >
            </div>
    
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
    
            <button type="submit" class="btn btn-primary">Send</button>
            <a href="{{ url('/projects') }}">Cancel</a>
    
    
        </form>
    </div>
@endsection