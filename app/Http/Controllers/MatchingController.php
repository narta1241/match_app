<?php

namespace App\Http\Controllers;

use App\User;
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
        $user_id = User::wherenotnull('deleted_at')->pluck('id');
        $matches = Matching::where('receive_user_id', Auth::id())->wherenotin ('user_id', $user_id)->get();
        
        $delete_days = User::wherenotnull('deleted_at')->pluck('deleted_at');
        $lost ="";
        $losts = Matching::where('receive_user_id', Auth::id())->where ('user_id', $user_id)->get();
        foreach($delete_days as $delete_day){
            $deleted_day = strtotime($delete_day);
            $today = date('Y-m-d');
            $today = strtotime($today);
            
            $other_day = (($today - $deleted_day) / (60 * 60 * 24));
            
            if($other_day < 10){
                $lost .= User::where ('deleted_at', $delete_day)->value('id');
            }
        }
        
        $losts = $losts->wherenotin('$id', $lost);
        
        return view('matchings.index', compact('matches', 'losts'));
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
