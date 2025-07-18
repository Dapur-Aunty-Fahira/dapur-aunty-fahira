<?php

namespace App\Http\Controllers\Page\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderCustomerController extends Controller
{
    public function index()
    {
        // Logic to display the order page for customers
        return view('pages.guest.order-customer');
    }
}
