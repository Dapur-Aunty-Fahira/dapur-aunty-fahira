<?php

namespace App\Http\Controllers\Page\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function show(){
        return view('pages.admin.dashboard');
    }
}
