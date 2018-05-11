<?php

namespace App\Http\Controllers;

use App\GPX;
use App\Lyric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LyricsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lyrics = Lyric::where('id', '>', '0')->orderByDesc('updated_at')->paginate(15);
        return view('lyric.index')->withLyrics($lyrics);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lyric.create')->withGpxes(GPX::whereNull('lyric_id')->pluck('name', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'title' => 'required|min:1|max:32',
            'htmlc' => 'required|min:6',
        ]);

        $out = new Lyric();
        $out -> title = $request -> title;
        $out -> md_text = $request -> htmlc;
        $out -> text = $request['editor-html-code'];
        $out -> user_id = Auth::id();
        if($request -> gpx != null) {
            $out -> gpx_id = $request -> gpx;
        }
        if($out->gpx_id != null) {
            $g = GPX::where('id', $out->gpx_id);
            $g -> update(['lyric_id' => $out->id]);
        }
        $out -> save();
        Session::flash('status', 'Successfully aded new lyrics!');
        return redirect()->route('lyric.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gpx = GPX::whereNull('lyric_id')->pluck('name', 'id');
        $lyric = Lyric::find($id);
        $this->authorize('edit', $lyric->user->id);
        return view('lyric.edit')->withGpx($gpx)->withLyric($lyric);
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
        $old = Lyric::find($id);
        $this->authorize('edit', $old->user->id);
        $valid = $request->validate([
            'title' => 'min:3|max:32',
            'htmlc' => 'min:6',
        ]);

        if( $request->title != $old->title) {
            $old->title = $request->title;
        }

        if($request->gpx != $old->gpx_id) {
            if($request->gpx == null ) {
                $g =GPX::find($old->gpx_id);
                $g -> update(['lyric_id' => null]);
            }
            $old->gpx_id = $request->gpx;
            
        if($old->gpx_id != null) {
            $g = GPX::where('id', $old->gpx_id);
            $g -> update(['lyric_id' => $old->id]);
        }
        }

        if($request->htmlc != $old->md_text) {
            $old -> md_text = $request->htmlc;
            $old -> text = $request['editor-html-code'];
        }
        $old->save();
        Session::flash('status', 'Successfully edited lyrics '.$old->title.'!');
        return redirect()->route('lyric.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lyric = Lyric::Find($id);
        $this->authorize('edit', $lyric->user->id);
        try {
            $lyric->delete();
        } catch (\Exception $e) {
            echo 'Error while deleting the lyric!';
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
