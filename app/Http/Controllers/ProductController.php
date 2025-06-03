<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Helpers\ImageHelper;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!session('active_store_id')) {
            $products = collect();
        } else {
            $products = Product::where('store_id', session('active_store_id'))
                ->orderBy('product_id', 'desc')
                ->get();
        }
        $products = Product::orderBy('product_id', 'desc')->get();
        return view('backend.v_product.index', [
            'title' => 'Product',
            'sub' => 'Product Page',
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('category_name', 'asc')->get();
        if (!session('active_store_id')) {
            return redirect()->route('backend.store.index')->with('error', 'Please activate a store first!');
        }
        return view('backend.v_product.create', [
            'title' => 'Product',
            'sub' => 'Add Product',
            'category' => $categories
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
            'category_id'   => 'required|exists:product_categories,category_id',
            'product_name'  => 'required|max:255|unique:products,product_name',
            'product_image' => 'nullable|image|mimes:jpeg,jpg,png|file|max:1024',
            'product_price' => 'required|numeric',
        ], [
            'product_name.unique'    => 'This product name already exists.',
            'product_image.image'    => 'Picture format must be jpeg, jpg, or png.',
            'product_image.max'      => 'Picture max size is 1024 KB.'
        ]);
        $validatedData['is_available'] = 0;

        if ($request->file('product_image')) {
            $file = $request->file('product_image');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-product/';

            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);

            $validatedData['product_image'] = $originalFileName;
        }

        $validatedData['store_id'] = $store_id;

        Product::create($validatedData);
        return redirect()->route('backend.product.index')->with('success', 'Your Product has Been Saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product_id)
    {
        $product = Product::findOrFail($product_id);
        $category = ProductCategory::orderBy('category_name', 'asc')->get();
        return view('backend.v_product.show', [
            'title' => 'Product',
            'show' => $product,
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $product_id)
    {
        $product = Product::findOrFail($product_id);
        $category = ProductCategory::orderBy('category_name', 'asc')->get();
        return view('backend.v_product.edit', [
            'title' => 'Product',
            'edit' => $product,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
        $product = Product::findOrFail($product_id);
        $rules = [
            'product_name'  => [
                'required',
                'max:255',
                Rule::unique('products', 'product_name')->ignore($product->product_id, 'product_id'),
            ],
            'product_price' => 'required|numeric',
            'product_image' => 'nullable|image|mimes:jpeg,jpg,png|file|max:1024',
            'is_available'  => 'required|boolean',
        ];
        $messages = [
            'product_name.unique'    => 'This product name is already taken.',
            'product_image.image'    => 'Picture format must be jpeg, jpg, or png.',
            'product_image.max'      => 'Picture max size is 1024 KB.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $validatedData['is_available'] = $request->boolean('is_available');

        if ($request->file('product_image')) {
            // Remove old images
            if ($product->product_image) {
                $directory = public_path('storage/img-product/');
                $oldFiles = [
                    $directory . $product->product_image,
                    $directory . 'thumb_lg_' . $product->product_image,
                    $directory . 'thumb_md_' . $product->product_image,
                    $directory . 'thumb_sm_' . $product->product_image
                ];
                foreach ($oldFiles as $file) {
                    if (file_exists($file)) {
                        @unlink($file);
                    }
                }
            }
            $file = $request->file('product_image');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-product/';

            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);

            $validatedData['product_image'] = $originalFileName;
        }

        $product->update($validatedData);
        return redirect()->route('backend.product.index')->with('success', 'Product Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $product = Product::findOrFail($product_id);
        if ($product->product_image) {
            $directory = public_path('storage/img-product/');
            $files = [
                $directory . $product->product_image,
                $directory . 'thumb_lg_' . $product->product_image,
                $directory . 'thumb_md_' . $product->product_image,
                $directory . 'thumb_sm_' . $product->product_image
            ];
            foreach ($files as $file) {
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
        }
        $product->delete();
        return redirect()->route('backend.product.index')->with('success', 'Product deleted successfully.');
    }

    // Method untuk Form Laporan menu
    public function formProduct()
    {
        return view('backend.v_product.form', [
            'title' => 'Product Data Page',
        ]);
    }

    public function detail($product_id)
    {
        $detail = Product::findOrFail($product_id);
        $category = ProductCategory::orderBy('category_name', 'desc')->get();
        return view('v_product.detail', [
            'title' => 'Detail Product',
            'kategori' => $category,
            'row' => $detail
        ]);
    }

    public function Productcategory($category_id)
    {
        $category = ProductCategory::orderBy('category_name', 'desc')->get();
        $product = Product::where('category_id', $category_id)->where('is_available', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_product.Productcategory', [
            'title' => 'Filter Category',
            'Category' => $category,
            'product' => $product,
        ]);
    }

    public function productAll()
    {
        $category = ProductCategory::orderBy('category_name', 'desc')->get();
        $product = Product::where('is_available', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_product.index', [
            'title' => 'All Product',
            'category' => $category,
            'product' => $product,
        ]);
    }
}