<?php

namespace Hourglass\Http\Controllers;

use Auth;
use Hourglass\Models\User;
use Illuminate\Http\Request;

use Hourglass\Http\Requests;

class TerminalController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        /** @var \Hourglass\Entities\User $user */
        $user = Auth::user();
        $eloquentUser = User::find($user->getId());

        return view('terminal', [
           'bootstrap' => [
               'user' => $eloquentUser->toArray(),
           ]
        ]);
    }
}
