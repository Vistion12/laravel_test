<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function posts()
    {
        return view('admin.posts');
    }

    public function categories()
    {
        return view('admin.categories');
    }
}
