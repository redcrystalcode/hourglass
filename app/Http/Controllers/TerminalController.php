<?php

namespace Hourglass\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use Hourglass\Http\Requests;

class TerminalController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        /** @var \Hourglass\Models\User $user */
        $user = Auth::user();

        return view('terminal', [
           'bootstrap' => [
               'user' => $user->toArray(),
           ]
        ]);
    }
}
