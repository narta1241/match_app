<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function setting()
    {
        $user = User::where('id', Auth::id())->first();
        
        return view('settings.index', compact('user'));
    }
}
