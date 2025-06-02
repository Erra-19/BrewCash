<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\UserStore;
use App\Models\ProductCategory;
use App\Models\Product;

class CashierController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
{
    $user = Auth::user();

    // Get the staff's store_role
    $userStore = UserStore::where('user_id', $user->user_id)
        ->where('status', 1)
        ->whereNull('end_date')
        ->orderByDesc('start_date')
        ->first();

    $storeRole = $userStore?->store_role ?? 'Staff';

    $categories = ProductCategory::withCount(['products' => function ($q) {
        $q->where('is_available', 1);
    }])
    ->having('products_count', '>', 0)
    ->get();

    $activeCategoryId = $request->get('category_id') ?? $categories->first()?->category_id;
    $activeCategory = $categories->firstWhere('category_id', $activeCategoryId);

    $products = [];
    if ($activeCategory) {
        $products = Product::with(['modifiers' => function($q) {
            $q->where('is_available', 1);
        }])
        ->where('category_id', $activeCategory->category_id)
        ->where('is_available', 1)
        ->get();

        foreach ($products as $product) {
            $product->modifiers_for_json = $product->modifiers->map(function($m){
                return [
                    "id" => $m->mod_id,
                    "name" => $m->mod_name,
                    "price" => $m->pivot->mod_price // <<< this is the fix!
                ];
            });
        }
    }
    $totalOrders = Order::where('user_id', $user->user_id)->count();

    return view('frontend.main', [
        'user'           => $user,
        'storeRole'      => $storeRole, // <--- now this is defined
        'categories'     => $categories,
        'products'       => $products,
        'activeCategory' => $activeCategory,
        'totalOrders'    => $totalOrders,
    ]);
}

public function productsByCategory(Request $request)
{
    $categoryId = $request->get('category_id');
    $products = [];

    if ($categoryId) {
        $products = Product::with(['modifiers' => function ($q) {
            $q->where('is_available', 1);
        }])
        ->where('category_id', $categoryId)
        ->where('is_available', 1)
        ->get();

        foreach ($products as $product) {
            $product->modifiers_for_json = $product->modifiers->map(function($m) {
                return [
                    "id" => $m->mod_id,
                    "name" => $m->mod_name,
                    "price" => $m->pivot->mod_price // FIXED!
                ];
            });
        }
    }

    // Return a Blade partial with just the menu HTML for AJAX replacement
    return view('frontend.partials.product-list', compact('products'))->render();
}
}