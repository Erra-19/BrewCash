<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;

class DashboardController extends Controller
{
    public function dashBackend()
    {
        $stores = Store::where('user_id', auth()->id())->orderBy('store_id', 'desc')->get();
        return view('backend.v_dash.index', [
            'title' => 'Dashboard',
            'sub' => 'Dashboard',
            'stores' => $stores
        ]);
    }

    public function index()
    {
        $product = Product::where('status', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('backend.v_dash.index', [
            'Title' => 'Dashboard',
            'produk' => $product,
            
        ]);
    }
}
