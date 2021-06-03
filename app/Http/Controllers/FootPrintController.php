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
        $footprints = FootPrint::getByLoginUserId(Auth::id());
        
        $withdrawMatchings = FootPrint::getWithdrawByLoginUserId(Auth::id());
        
        return view('footprints.index', [
            "footprints" => $footprints,
            "losts" => $withdrawMatchings,
        ]);
    }
}
