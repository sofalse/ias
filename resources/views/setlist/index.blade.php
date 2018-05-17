@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/gpx.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a id="gpxAddBtn" href="{{ route('setlist.create') }}" class="btn btn-lg btn-primary">Create new setlist</a>
    <div class="card">
        <table id="gpxTable" class="table table-bordered table-hover">
            <thead>
                <th>ID</th>
                <th>Title</th>
                <th>Gig</th>
                <th>Gig venue</th>
                <th>Gig date</th>
                <th>Content</th>
                @if(Auth::user()->role > 1)<th>Actions</th> @endif
            </thead>
            <tbody>
            @foreach($setlists as $setlist)
            <div class="modal fade" id="setlist-{{ $setlist->id }}" tabindex="-1" role="dialog" aria-labelledby="Setlist text" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $setlist->title }}({{ $setlist->gig->date }})</h5>
                                <div class="pull-right">
                                    <a @click="print" href="#" class="mt-auto mb-auto"><span aria-hidden="true" class="fa fa-lg fa-print"></span></a>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body align-self-center text-center printable">
                                {!! $setlist -> text !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <tr>
                    <td>{{ $setlist->id }}</td>
                    <td>{{ $setlist->title }}</td>
                    <td>{{ $setlist->gig->title }}</td>
                    <td>{{ $setlist->gig->venue }}</td>
                    <td>{{ date("d/m/Y, G:i", strtotime($setlist->gig->date)) }}</td>
                    <td> <a href="#setlist-{{ $setlist->id }}" data-toggle="modal" data-target="#setlist-{{ $setlist->id }}">Show</a></td>
                    @if(Auth::user()->role > 1)<td><a class="btn btn-primary btn-sm" href="{{ route('setlist.edit', ['id' => $gig->id]) }}">Edit</a></td> @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="align-self-center">
            {{ $setlists->links() }}
        </div>
    </div>

@endsection