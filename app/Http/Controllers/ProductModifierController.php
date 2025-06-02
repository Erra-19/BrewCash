<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Modifier;
use App\Models\ProductModifier;
use App\Models\ProductCategory;

class ProductModifierController extends Controller
{
    /**
     * Show the add modifier form for a specific product.
     */
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = ProductCategory::orderBy('category_name')->get();

        return view('backend.v_product_modifier.create', compact('product', 'categories'));
    }

    /**
     * AJAX: Get modifiers by category.
     */
    public function modifiersByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $modifiers = Modifier::where('category_id', $category_id)->orderBy('mod_name')->get();

        return response()->json($modifiers);
    }

    /**
     * Store the new product-modifier relation.
     */
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'category_id' => 'required|exists:product_categories,category_id',
            'mod_id'      => 'required|exists:modifiers,mod_id',
            'mod_price'   => 'required|numeric|min:0',
        ]);

        // Prevent duplicate modifier for this product
        $exists = ProductModifier::where('product_id', $product_id)->where('mod_id', $request->mod_id)->exists();
        if ($exists) {
            return back()->withErrors(['mod_id' => 'This modifier is already attached to this product.'])->withInput();
        }

        ProductModifier::create([
            'product_id' => $product_id,
            'mod_id'     => $request->mod_id,
            'mod_price'  => $request->mod_price,
        ]);

        return redirect()->route('backend.product.index', $product_id)->with('success', 'Modifier added to product!');
    }
}