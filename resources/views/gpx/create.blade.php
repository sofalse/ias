@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Add new GPX</h1>
        {!! Form::open(['route' => 'gpx.store', 'files' => 'true']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Title:') !!}
                {!! Form::text('name', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('gpx_file', 'GPX File:') !!}
                {!! Form::file('gpx_file') !!}
            </div>
            <div class="form-group">
                {!! Form::label('lyrics', 'Attach lyrics:') !!}
                {!! Form::select('lyrics', $lyrics, null, ['placeholder' => 'Nothing', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection