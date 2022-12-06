@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Movie Database</h2>
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
            <th>Nama Movie</th>
            <th>Genre</th>
            <th>Director</th>
        </tr>
        @foreach ($joins as $join)
        <tr>
            <td>{{ $join->nama_movie }}</td>
            <td>{{ $join->nama_genre }}</td>
            <td>{{ $join->nama_director}} </td>
        </tr>
        @endforeach
    </table>
    {!! $joins->links() !!}
    <p class="text-center text-primary"><small></small></p>
@endsection