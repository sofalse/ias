@extends('layouts.app')

@section('styles')
    {!! editor_css() !!}
@endsection

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
        {!! Form::model($lyric, ['method' => 'put', 'route' => ['lyric.update', $lyric->id]]) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', $lyric->title,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('htmlc', 'Text:') !!}
            <div id="editor">
                <textarea class="md" name="md">{{ $lyric->md_text }}</textarea>
                <!-- html textarea 需要开启配置项 saveHTMLToTextarea == true -->
                <textarea class="htmlc" name="htmlc"></textarea>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('gpx', 'Attach GPX:') !!}
            {!! Form::select('gpx', $gpx, $lyric->gpx != null ? $lyric->gpx->id : null, ['placeholder' => 'Nothing', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Submit changes', ['class' => 'btn btn-primary mr-auto']) !!}
            <button type="button" @click="show" class="btn btn-danger mr-auto">Delete Lyrics</button>
        </div>
        {!! Form::close() !!}
    </div>
    {!! editor_js() !!}
    {!! editor_config(['id' => 'editor']) !!}
@endsection