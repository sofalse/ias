<?php

namespace App\Http\Controllers;

use App\GPX;
use App\Lyric;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $last = User::find(Auth::id())->lastVisit;
        $gpx = GPX::where('updated_at', '>', $last)->get();
        $lyrics = Lyric::where('updated_at', '>', $last)->get();
        return view('home')->withGpx($gpx)->withLyrics($lyrics);
    }

    /**
     * Show user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        $gpx = GPX::where('user_id', Auth::id())->count();
        $lyrics = Lyric::where('user_id', Auth::id())->count();
        return view('user.profile')->withGpx($gpx)->withLyrics($lyrics);
    }

    /**
     * Change user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request, $id) {
        $valid = $request->validate([
            'current' => 'required',
            'new' => 'required|string|min:6|max:32',
            'new2' => 'required|string|min:6|max:32',
        ]);
        if (!(Hash::check($request->get('current'), Auth::user()->password))) {
            Session::flash('error', 'Your current password does not matches with the password you provided. Please try again.');
            return redirect()->route('profile');
        }

        if(strcmp($request->get('current'), $request->get('new')) == 0){
            Session::flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
            return redirect()->route('profile');
        }

        if(strcmp($request->get('new'), $request->get('new2')) != 0) {
            Session::flash('error', 'New password has to be equal in both fields. Try again.');
            return redirect()->route('profile');
        }

        $user = Auth::user();
        $user -> password = bcrypt($request ->get('new'));
        $user -> save();
        Session::flash('status', 'Password changed successfully.');
        return redirect()->route('profile');
    }
}
