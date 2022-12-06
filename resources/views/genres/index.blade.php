@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Genres</h2>
            </div>
            <div class="pull-right">
                @can('genre-create')
                <a class="btn btn-success" href="/genres/create"> Create New Genre</a>
                @endcan
                @can('genre-delete')
                <a class="btn btn-info" href="genres/trash"> Deleted Genre</a>
                @endcan
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="/genres/search" method="post">
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
            <th>ID Genre</th>
            <th>Nama Genre</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($genres as $genre)
        <tr>
            <td>{{ $genre->id_genre }}</td>
            <td>{{ $genre->nama_genre }}</td>
            <td>
                <form action="/genres/delete/{{$genre->id_genre}}" method="POST">
                    <a class="btn btn-info" href="/genres/show/{{$genre->id_genre}}">Show</a>
                    @can('genre-edit')
                    <a class="btn btn-primary" href="/genres/edit/{{$genre->id_genre}}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('genre-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
@endsection