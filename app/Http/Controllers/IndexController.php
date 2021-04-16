<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\School;

class IndexController extends Controller
{

    public function index()
    {
        $schools = School::active();

        return view('index', ['schools' => $schools]);
    }
}
