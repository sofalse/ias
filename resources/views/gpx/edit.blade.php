@extends('layouts.app')

@section('content')
    <div class="container" id="edit-form">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::model($gpx, ['method' => 'put', 'route' => ['gpx.update', $gpx->id], 'files' => 'true']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Title:') !!}
            {!! Form::text('name', $gpx->name,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('gpx_file', 'GPX File:') !!}
            {!! Form::file('gpx_file') !!}
        </div>
        <div class="form-group">
            {!! Form::label('lyrics', 'Attach lyrics:') !!}
            {!! Form::select('lyrics', $lyrics, $gpx->lyric != null ? $gpx->lyric->id : null, ['placeholder' => 'Nothing', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Submit changes', ['class' => 'btn btn-primary mr-auto']) !!}
            <button type="button" @click="show" class="btn btn-danger mr-auto">Delete GPX</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection