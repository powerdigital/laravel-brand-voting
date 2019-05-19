<?php

namespace App\Http\Controllers;

use App\Company;

class IndexController extends Controller
{
    public function index(int $categoryId = null)
    {
        return view('index.index', Company::getCompanies($categoryId));
//        return view('index.alert');
    }
}
