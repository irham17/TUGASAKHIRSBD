@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Movies</h2>
            </div>
            <div class="pull-right">
                @can('movie-create')
                <a class="btn btn-success" href="/movies/create"> Create New Movie</a>
                @endcan
                @can('movie-delete')
                <a class="btn btn-info" href="movies/trash"> Deleted Movie</a>
                @endcan
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="/movies/search" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Keyword" name = "keyword" aria-label="Keyword" aria-describedby="basic-addon1">
                        <button type="submit" class="input-group-text btn btn-primary" id="basic-addon1">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID Movie</th>
            <th>Nama Movie</th>
            <th>ID Genre</th>
            <th>ID Director</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($movies as $movie)
        <tr>
            <td>{{ $movie->id_movie }}</td>
            <td>{{ $movie->nama_movie }}</td>
            <td>{{ $movie->id_genre }}</td>
            <td>{{ $movie->id_director }}</td>
            <td>
                <form action="/movies/delete/{{$movie->id_movie}}" method="POST">
                    <a class="btn btn-info" href="/movies/show/{{$movie->id_movie}}">Show</a>
                    @can('movie-edit')
                    <a class="btn btn-primary" href="/movies/edit/{{$movie->id_movie}}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('movie-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
@endsection