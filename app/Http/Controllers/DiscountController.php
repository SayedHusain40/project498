<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        return redirect()->away('https://unipal.me/en-bh/');
    }

}
