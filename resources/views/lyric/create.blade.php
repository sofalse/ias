@extends('layouts.app')

@section('styles')
    {!! editor_css() !!}
@endsection

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

        <h1>Add new lyrics</h1>
        {!! Form::open(['route' => 'lyric.store']) !!}
        <div class="form-group">
            {!! Form::label('title', 'Title:') !!}
            {!! Form::text('title', '', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('htmlc', 'Text:') !!}
            <div id="editor">
                <textarea class="md" name="md"></textarea>
                <!-- html textarea 需要开启配置项 saveHTMLToTextarea == true -->
                <textarea class="htmlc" name="htmlc"></textarea>
            </div>
        </div>
         <div class="form-group">
                {!! Form::label('gpx', 'Attach GPX: ') !!}
                {!! Form::select('gpx', $gpxes, null, ['placeholder' => 'Nothing', 'class' => 'form-control']) !!}
         </div>
        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    {!! editor_js() !!}
    {!! editor_config(['id' => 'editor']) !!}
@endsection