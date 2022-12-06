@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Director</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('directors.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID Director:</strong>
                {{ $director->id_director }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama Director:</strong>
                {{ $director->nama_director }}
            </div>
        </div>
    </div>
@endsection

