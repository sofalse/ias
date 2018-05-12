<?php

namespace App\Http\Controllers;

use App\Gig;
use App\Agreement;
use Illuminate\Http\Request;

class GigsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gigs = Gig::where('id', '>', '0')->orderByDesc('updated_at')->paginate(15);
        return View('gig.index')->withGigs($gigs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('gig.create');
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
            'title' => 'string|min:3|max:255|required',
            'venue' => 'string|min:5|max:255|required',
            'show_date' => 'date|after:yesterday|required',
            'payout' => 'numeric|nullable',
            'confirmed' => 'boolean',
            'agreement' => 'file|mimes:pdf,doc,docx,txt,rtf,jpg,jpeg|max:8192|nullable',
        ]);

        $gig = new Gig();
        $gig -> title = $request -> title;
        $gig -> venue = $request -> venue;
        $gig -> date = date("Y-m-d H:i:s", strtotime($request -> show_date));

        if($request -> payout !== null) {
            $gig -> payout = $request -> payout;
        }

        $gig -> confirmed = $request -> confirmed;

        if($request -> hasFile('agreement')) {
            $agree = new Agreement();
            $filename = $request -> file('agreement') -> getClientOriginalName();
            $destinationPath = public_path().'/files/agreements';
            $request -> file('agreement') -> move($destinationPath, $filename);
            $agree -> title = $request -> title;
            $agree -> file_path = $filename;
            $agree -> save();
            $gig -> agreement_id = $agree -> id;
        }

        $gig -> save();

        if ($gig -> agreement_id !== null) {
            $ag = Agreement::where('id', $gig -> agreement_id) -> update(['gig_id' => $gig -> id]);
        }

        return redirect()->route('gig.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
