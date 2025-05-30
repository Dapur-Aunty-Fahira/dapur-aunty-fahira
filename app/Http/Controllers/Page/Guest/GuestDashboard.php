<?php

namespace App\Http\Controllers\Page\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestDashboard extends Controller
{
    public function show(){
        return view('pages.guest.dashboard');
    }
}
