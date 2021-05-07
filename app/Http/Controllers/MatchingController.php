<?php

namespace App\Http\Controllers;

use App\Matching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = Matching::where('receive_user_id', Auth::id())->get();
         
        return view('matchings.index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Maching  $maching
     * @return \Illuminate\Http\Response
     */
    public function show(Maching $maching)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Maching  $maching
     * @return \Illuminate\Http\Response
     */
    public function edit(Maching $maching)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Maching  $maching
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maching $maching)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Maching  $maching
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maching $maching)
    {
        //
    }
}
