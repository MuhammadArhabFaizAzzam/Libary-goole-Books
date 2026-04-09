<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TwoFactorAuthenticationController extends Controller
{
    public function show()
    {
        return view('settings.two-factor');
    }
}