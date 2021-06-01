<?php

namespace App\Http\Controllers;

use App\Profile;
use App\FootPrint;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FootPrintController extends Controller
{
     public function index()
    {
        $delete_user_id = User::wherenotnull('deleted_at')->pluck('id');
        $foots = FootPrint::where('footed_user_id', Auth::id())->pluck('footting_user_id');
        $users = Profile::wherein('user_id', $foots)->wherenotin ('user_id', $delete_user_id)->get();
        
        $delete_days = User::wherenotnull('deleted_at')->pluck('deleted_at');
        $lost ="";
        $losts = FootPrint::where('footed_user_id', Auth::id())->where ('footting_user_id', $delete_user_id)->get();
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
        // dd($losts);
        return view('footprints.index', compact('users', 'losts'));
    }
}
