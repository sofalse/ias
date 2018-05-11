@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/gpx.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a id="gpxAddBtn" href="{{ route('gpx.create') }}" class="btn btn-lg btn-primary">Add new GPX</a>
    <div class="card">
        <table id="gpxTable" class="table table-bordered table-hover">
            <thead>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Version</th>
                <th>Added on</th>
                <th>Updated on</th>
                <th>Lyrics</th>
                <th>Download</th>
            </thead>
            <tbody>
            @foreach($gpxes as $gpx)
                <tr>
                    <td>{{ $gpx->id }}</td>
                    <td>{{ $gpx->name }}</td>
                    <td>{{ $gpx->user->name }}</td>
                    <td>{{ $gpx->version }}</td>
                    <td>{{ $gpx->created_at }}</td>
                    <td>{{ $gpx->updated_at }}</td>
                    @if($gpx->lyric != null)
                        <td>{{ $gpx->lyric->title }}</td>
                    @else
                        <td><i>No lyrics found. <a href="{{ route('lyric.create') }}">Add one!</a></i></td>
                    @endif
                    <td><a href="{{ 'files/gpx/'.$gpx->filePath }}">Download</a> @can('edit', $gpx->user->id)| <a href="{{ route('gpx.edit', ['id' => $gpx->id]) }}">Update</a>@endcan</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="align-self-center">
            {{ $gpxes->links() }}
        </div>
    </div>

@endsection