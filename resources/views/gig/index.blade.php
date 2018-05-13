@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/gpx.css') }}" rel="stylesheet">
@endsection

@section('content')
    <a id="gpxAddBtn" href="{{ route('gig.create') }}" class="btn btn-lg btn-primary">Create new gig</a>
    <div class="card">
        <table id="gpxTable" class="table table-bordered table-hover">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Venue</th>
                <th>Date</th>
                <th>Payout</th>
                <th>Confirmed?</th>
                <th>Setlist</th>
                <th>Agreement</th>
                @if(Auth::user()->role > 1)<th>Actions</th> @endif
            </thead>
            <tbody>
            @foreach($gigs as $gig)
                <tr>
                    <td>{{ $gig->id }}</td>
                    <td>{{ $gig->title }}</td>
                    <td>{{ $gig->venue }}</td>
                    <td>{{ date("d/m/Y, G:i", strtotime($gig->date)) }}</td>
                    <td> @if($gig->payout === null) — @else {{ $gig->payout }} @endif</td>
                    <td> @if($gig->confirmed) &check; @else &cross; @endif</td>
                    <td> @if($gig->setlist === null) — @else {{ $gig->setlist }} @endif</td>
                <td> @if($gig->agreement === null) — @else <a href="files/agreements/{{ $gig->agreement->file_path }}">{{ $gig->agreement->title }}</a> @endif</td>
                    @if(Auth::user()->role > 1)<td><a class="btn btn-primary btn-sm" href="{{ route('gig.edit', ['id' => $gig->id]) }}">Edit</a></td> @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="align-self-center">
            {{ $gigs->links() }}
        </div>
    </div>

@endsection