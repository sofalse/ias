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

        <h1>Add new gig</h1>
        {!! Form::open(['route' => 'gig.store', 'files' => 'true']) !!}
            <div class="form-group mt-3">
                {!! Form::label('title', 'Name:*') !!}
                {!! Form::text('title', '', ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('venue', 'Venue:*') !!}
                {!! Form::text('venue', '', ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('show_date', 'Date:*') !!}
                <input type="datetime-local" name="show_date" id="show_date" class="form-control" required>
            </div>
            <div class="form-group">
                {!! Form::label('payout', 'Payout:') !!}
                {!! Form::number('payout', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('confirmed', 'Confirmed?') !!}<br />
                {!! Form::checkbox('confirmed') !!}
            </div>
            <div class="form-group">
                {!! Form::label('agreement', 'Agreement:') !!}<br />
                {!! Form::file('agreement') !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection