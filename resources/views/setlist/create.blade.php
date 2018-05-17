@extends('layouts.app')
@section('content')
    <div class="container text-center">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Add new setlist</h1>
        {!! Form::open(['route' => 'setlist.store']) !!}
            <div class="form-group mt-3">
                {!! Form::label('title', 'Title:*') !!}
                {!! Form::text('title', '', ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('gig', 'Attach gig:') !!}
                {!! Form::select('gig', $gig, null, ['placeholder' => 'Nothing', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('songs-no', 'Number of songs:') !!}
                <input type="number" v-model.number="songs" class="form-control" id="songs-no" min="0" max="35" />
            </div>
            <div class="form-group" v-for="n in songs">
                <label v-bind:for="n">Song @{{n}}:</label>
                <input type="text" v-bind:id="n" v-bind:name="n" class="form-control" />
            </div>
            <div class="form-group">
                {!! Form::label('encore', 'Encore?') !!} <br />
                <input type="checkbox" id="encore" name="encore" v-model="encore" />
            </div>
            <div class="form-group" v-if='encore'>
                {!! Form::label('encore-song', 'Encore:') !!} <br />
                {!! Form::text('encore-song', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection