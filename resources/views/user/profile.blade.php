@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ Auth::user()->name }}'s profile</div>
            <div class="card-body ml-5">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal fade" id="pwd-change" tabindex="-1" role="dialog" aria-labelledby="Change password" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            {!! Form::open(['route' => 'changePassword']) !!}
                            <div class="modal-header">
                                <h5 class="modal-title" id="passwordChange">Change password</h5>
                                <div class="pull-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body align-self-center text-center">
                                    <div class="form-group">
                                        {!! Form::label('current', 'Current password: ') !!}
                                        {!! Form::password('current', ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('new', 'New password: ') !!}
                                        {!! Form::password('new', ['class' => 'form-control', 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('new2', 'Repeat new password: ') !!}
                                        {!! Form::password('new2', ['class' => 'form-control', 'required']) !!}
                                    </div>
                            </div>
                            <div class="modal-footer">
                                {!! Form::submit('Change', ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="avatar-change" tabindex="-1" role="dialog" aria-labelledby="Change avatar" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            {!! Form::open(['route' => 'changeAvatar', 'files' => 'true']) !!}
                            <div class="modal-header">
                                <h5 class="modal-title" id="avatarChange">Change avatar</h5>
                                <div class="pull-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body align-self-center text-center">
                                    <div class="form-group">
                                        {!! Form::label('url', 'Enter URL: ') !!}
                                        {!! Form::text('url', '',  ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('avatar_file', 'Or upload from a file: ') !!}
                                        <small class="text-muted">(max. 2MB; PNG and JPG accepted only)</small>
                                        {!! Form::file('avatar_file') !!}
                                    </div>
                            </div>
                            <div class="modal-footer">
                                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <p><b>Nickname: </b> {{ Auth::user()->name }}</p>
                        <p><b>Added GPX: </b> {{ $gpx }}</p>
                        <p><b>Added lyrics: </b> {{ $lyrics }}</p>
                    </div>
                    <div class="col-4 pull-right">
                        <div class="btn-group" role="group" aria-label="Profile actions">
                            <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#pwd-change">Change password</button>
                            <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#avatar-change">Change avatar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection