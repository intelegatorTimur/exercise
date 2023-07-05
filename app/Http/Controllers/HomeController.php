<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        return '123';
    }


}
