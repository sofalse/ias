@extends('layouts.bare')
@section('navbar')
<nav class="navbar navbar-expand-md navbar-light navbar-laravel not-printable">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item {{ Route::is('gpx.index') ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('gpx.index') }}">GPXes</a>
                </li>
                <li class="nav-item {{ Route::is('lyric.index') ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('lyric.index') }}">Lyrics</a>
                </li>
                <li class="nav-item {{ Route::is('gig.index') ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('gig.index') }}">Gigs</a>
                </li>
                <li class="nav-item {{ Route::is('setlist.index') ? 'active': '' }}">
                    <a class="nav-link" href="{{ route('setlist.index') }}">Setlists</a>
                </li>
                @endauth
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img class="avatar" src="@if(Auth::user()->avatar == null)https://placeimg.com/32/32/any @elseif(strpos(Auth::user()->avatar, '://')) {!! Auth::user()->avatar !!} @else /files/avatars/{!! Auth::user()->avatar !!} @endif">   Hi, {{ Auth::user()->name }}! <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                            <div class="dropdown-divider"></div>
                            @can('register-user')
                            <a class="dropdown-item" href="{{ route('register') }}">Register new user</a>
                            @endcan
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
@endsection

@section('status')
@if (session('status'))
    <div class="alert alert-success container not-printable alert-dismissible">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@endsection
