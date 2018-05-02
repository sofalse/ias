<?php

namespace App\Http\Controllers;

use App\GPX;
use App\Lyric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GPXController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gpxes = GPX::where('id', '>', '0')->orderByDesc('updated_at')->paginate(15);
        return view('gpx.index')->withGpxes($gpxes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lyrics = Lyric::whereNull('gpx_id')->pluck('title', 'id');
        return view('gpx.create')->withLyrics($lyrics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gpx = $request->validate([
            'name' => 'required|unique:gpx|min:3|max:64',
            'gpx_file' => 'required|file|max:2048',
        ]);

        $out = new GPX();
        $out->name = $request->name;
        $out->version = 1.0;
        $filename = uniqid().'_'.$request->file('gpx_file')->getClientOriginalName();
        $destinationPath = public_path().'/files/gpx';
        $request->file('gpx_file')->move($destinationPath, $filename);
        $out->filePath = $filename;
        $out->user_id = Auth::id();
        if($request->lyrics != null) {
            $out->lyric_id = $request->lyrics;
        }
        Session::flash('status', 'GPX added successfully!');
        $out->save();
        if($out->lyric_id != null) {
            $l = Lyric::where('id', $out->lyric_id);
            $l -> update(['gpx_id' => $out->id]);
        }
        return redirect()->route('gpx.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lyrics = Lyric::whereNull('gpx_id')->pluck('title', 'id');
        $gpx = GPX::find($id);
        return view('gpx.edit')->withGpx($gpx)->withLyrics($lyrics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $old = GPX::find($id);
        $v = 0.0;
        $gpx = $request->validate([
            'name' => 'required|min:3|max:64',
            'gpx_file' => 'file|max:2048',
        ]);
        if( $request->name != $old->name) {
            $old -> name = $request->name;
            $v = 0.1;
        }
        if ($request->hasFile('gpx_file')) {
            $filename = uniqid().'_'.$request->file('gpx_file')->getClientOriginalName();
            $destinationPath = public_path().'/files/gpx';
            $request->file('gpx_file')->move($destinationPath, $filename);
            $old->filePath = $filename;
            $v = 1.0;
        }
        if($request->lyrics != $old->lyric_id) {
            if($request->lyrics == null ) {
                $l =Lyric::find($old->lyric_id);
                $l -> update(['gpx_id' => null]);
            }
            $old->lyric_id = $request->lyrics;
            $v = 0.1;
        }
        $old->version += $v;
        $old -> save();
        if($old->lyric_id != null) {
            $l = Lyric::where('id', $old->lyric_id);
            $l -> update(['gpx_id' => $old->id]);
        }
        return redirect()->route('gpx.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gpx = GPX::find($id);
        try {
            $gpx->delete();
        } catch (\Exception $e) {
            echo 'Error while deleting model GPX';
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
