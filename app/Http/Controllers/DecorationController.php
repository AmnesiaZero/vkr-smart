<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DecorationController extends Controller
{
    public function view()
    {
        return view('templates.dashboard.settings.decoration');
    }
}
