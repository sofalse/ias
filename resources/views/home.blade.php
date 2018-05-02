@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <p>You are logged in!</p>

                    <b class="text-center">You may have not seen:</b>
                    <ul class="list-unstyled ml-2">
                        @foreach($gpx as $g)
                            <li><a href="{{ $g->filePath }}">[GPX] {{ $g->name }} </a></li>
                        @endforeach
                        @foreach($lyrics as $l)
                            <li><a href="{{ route('lyric.show', ['id' => $l->id]) }}">[Lyrics] {{ $l->title }} </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
