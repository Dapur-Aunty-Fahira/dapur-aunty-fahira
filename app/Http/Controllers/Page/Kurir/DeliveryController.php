<?php

namespace App\Http\Controllers\Page\Kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        return view("pages.kurir.delivery");
    }
}
