<?php

namespace App\Http\Controllers;

use App\Profile;
use App\FootPrint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FootPrintController extends Controller
{
     public function index()
    {
        $foots = FootPrint::where('footed_user_id', Auth::id())->pluck('footting_user_id');
        $users = Profile::wherein('user_id', $foots)->get();
        return view('footprints.index', compact('users'));
    }
}
