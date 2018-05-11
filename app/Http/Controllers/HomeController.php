<?php

namespace App\Http\Controllers;

use App\GPX;
use App\Lyric;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Rules\ImageURL;

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
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request) {
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

    /**
     * Change user's avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function avatar(Request $request) {
        $user = User::find(Auth::id());
        if($request->hasFile('avatar_file')) {
            $validation = $request->validate([
                'avatar_file' => 'file|mimes:jpeg,png,jpg|max:2048'
            ]);
            $filename = Auth::user()->name.'_'.time().'.'.$request->file('avatar_file')->getClientOriginalExtension();
            $destinationPath = public_path().'/files/avatars';
            $request->file('avatar_file')->move($destinationPath, $filename);
            if(strpbrk($user->avatar, '/') === false && $user->avatar !== null) {
                unlink($destinationPath.'\\'.$user->avatar);
            }
            $user->avatar = $filename;
            $user->save();
            Session::flash('status', 'Avatar has been successfully set.');
            return redirect()->route('profile');
        } else {
            $validation = $request->validate([
                'url' => ['required', 'url', 'max:255', new ImageURL()]
            ]);
            if(strpbrk($user->avatar, '/') === false) {
                unlink(public_path().'\\files\\avatars\\'.$user->avatar);
            }
            $user->avatar = $request->url;
            $user->save();
            Session::flash('status', 'Avatar has been successfully set.');
            return redirect()->route('profile');
        }
    }
}
