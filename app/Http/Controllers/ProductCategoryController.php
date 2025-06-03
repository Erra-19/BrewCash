<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!session('active_store_id')) {
            $categories = collect();
        } else {
            $categories = ProductCategory::where('store_id', session('active_store_id'))
                ->orderBy('category_id', 'desc')
                ->get();
        }
        return view('backend.v_category.index', [
            'title' => 'Category',
            'category' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!session('active_store_id')) {
            return redirect()->route('backend.store.index')->with('error', 'Please activate a store first!');
        }
        return view('backend.v_category.create', [
            'title' => 'Add category',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!session('active_store_id')) {
            return redirect()->route('backend.store.index')->with('error', 'Please activate a store first!');
        }
        $store_id = session('active_store_id');
        $validatedData = $request->validate([
            'category_name' => 'required|max:255|unique:product_categories,category_name',
        ]);
        ProductCategory::create([
            'category_name' => $validatedData['category_name'],
            'store_id' => $store_id,
        ]);
        return redirect()->route('backend.category.index')->with('success', 'Data succesfully saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $category_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $category_id)
    {
        $category = ProductCategory::findOrFail($category_id);
        return view('backend.v_category.edit', [
            'title' => 'Update category',
            'edit' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $category_id)
    {
        $rules = [
            'category_name' => 'required|max:255|unique:ProductCategory,category_name,' . $category_id,
        ];
        $validatedData = $request->validate($rules);
        ProductCategory::where('category_id', $category_id)->update($validatedData);
        return redirect()->route('backend.category.index')->with('success', 'Data succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category_id)
    {
        $category = ProductCategory::findOrFail($category_id);
        $category->delete();
        return redirect()->route('backend.category.index')->with('success', 'Data succesfully deleted');
    }
}
