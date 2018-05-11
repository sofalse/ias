@extends('layouts.app')

@section('styles')
    {!! editor_css() !!}
    <link href="{{ asset('css/gpx.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a id="gpxAddBtn" href="{{ route('lyric.create') }}" class="btn btn-lg btn-primary">Add new lyrics</a>
    <div class="card">
        <table id="gpxTable" class="table table-bordered table-hover not-printable">
            <thead class="not-printable">
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Added on</th>
            <th>Updated on</th>
            <th>Linked GPX</th>
            <th>Text</th>
            </thead>
            <tbody>
            @foreach($lyrics as $lyric)
                <div class="modal fade" id="text-{{ $lyric->id }}" tabindex="-1" role="dialog" aria-labelledby="Change password" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $lyric->title }}</h5>
                                <div class="pull-right">
                                    <a @click="print" href="#" class="mt-auto mb-auto"><span aria-hidden="true" class="fa fa-lg fa-print"></span></a>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body align-self-center text-center printable">
                                {!! $lyric -> text !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <tr class="not-printable">
                    <td>{{ $lyric->id }}</td>
                    <td>{{ $lyric->title }}</td>
                    <td>{{ $lyric->user->name }}</td>
                    <td>{{ $lyric->created_at }}</td>
                    <td>{{ $lyric->updated_at }}</td>
                    @if($lyric->gpx != null)
                        <td><a href="{{ 'files/gpx/'.$lyric->gpx->filePath }}">{{ $lyric->gpx->name }}</a></td>
                    @else
                        <td><i>No GPXes found. <a href="{{ route('gpx.create') }}">Add one!</a></i></td>
                    @endif
                <td><a href="#text-{{ $lyric->id }}" data-toggle="modal" data-target="#text-{{ $lyric->id }}">Show</a> @can('edit', $lyric->user->id)| <a href=" {{ route('lyric.edit', ['id' => $lyric->id]) }}">Edit</a> @endcan</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="align-self-center not-printable">
            {{ $lyrics->links() }}
        </div>
    </div>

@endsection