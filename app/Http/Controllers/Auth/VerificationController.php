<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
    public function verify(Request $request)
    {

        if ($request->route('id') == $request->user()->getKey() &&
            hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))
        ) {

            $request->user()->markEmailAsVerified();


            return redirect()->route('/')->with('success', 'Email verified successfully.');
        }


        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }
}
