<?php

namespace App\Http\Controllers;

use App\Block;
use App\Matching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('a');
        // $user = Block::where('blocked_user_id', Auth::id())->where('blocking_user_id', Auth::id())->get();
        
        // return view('blocks.index',compact('user'));
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
        // dd($request);
        Block::create([
                'blocked_user_id' => $request->input('blocked_user_id'),
                'blocking_user_id' => Auth::id(),
            ]);
        $match1 = Matching::where('user_id', $request->input('blocked_user_id'))->where('receive_user_id', Auth::id())->first();
        $match1->delete();
        $match2 = Matching::where('user_id', Auth::id())->where('receive_user_id', $request->input('blocked_user_id'))->first();
        $match2->delete();
        
        return redirect()->route('matchings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        //
    }
}
