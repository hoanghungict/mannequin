<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index() {
        return view ('pages.user.products.index', [

        ]);
    } 

    public function showDetail() {
        return view('pages.user.products.detail',[
            
        ]);
    }
}
