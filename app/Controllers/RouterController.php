<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RouterController extends BaseController
{
    public function start()
    {
        return view('pages/start_view');
    }

    public function products()
    {
        return view('pages/products_view');
    }

    public function cart()
    {
        return view('pages/cart_view');
    }

    public function checkout()
    {
        return view('pages/checkout_view');
    }
}
