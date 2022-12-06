@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Directors</h2>
            </div>
            <div class="pull-right">
                @can('director-create')
                <a class="btn btn-success" href="/directors/create"> Create New Director</a>
                @endcan
                @can('director-delete')
                <a class="btn btn-info" href="directors/trash"> Deleted director</a>
                @endcan
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="/directors/search" method="post">
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
            <th>ID Director</th>
            <th>Nama Director</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($directors as $director)
        <tr>
            <td>{{ $director->id_director }}</td>
            <td>{{ $director->nama_director }}</td>
            <td>
                <form action="/directors/delete/{{$director->id_director}}" method="POST">
                    <a class="btn btn-info" href="/directors/show/{{$director->id_director}}">Show</a>
                    @can('director-edit')
                    <a class="btn btn-primary" href="/directors/edit/{{$director->id_director}}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('director-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
@endsection