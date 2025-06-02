<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modifier;
use App\Models\ProductCategory;
use App\Helpers\ImageHelper;
use Illuminate\Validation\Rule;

class ModifierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modifiers = Modifier::orderBy('mod_id', 'desc')->get();
        return view('backend.v_modifier.index', [
            'title' => 'Modifier',
            'sub' => 'Modifier Page',
            'modifier' => $modifiers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('category_name', 'asc')->get();
        return view('backend.v_modifier.create', [
            'title' => 'Modifier',
            'sub' => 'Add Modifier',
            'category' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mod_name' => 'required|max:255|unique:modifiers,mod_name',
            'mod_image' => 'nullable|image|mimes:jpeg,jpg,png|file|max:1024',
            // --- ADD THIS LINE ---
            'category_id' => 'required|exists:product_categories,category_id',
        ], [
            'mod_name.unique' => 'This modifier name already exists.',
            'mod_image.image' => 'Picture format must be jpeg, jpg, or png.',
            'mod_image.max' => 'Picture max size is 1024 KB.',
            // --- ADD A MESSAGE FOR THE NEW RULE (OPTIONAL) ---
            'category_id.required' => 'Please select a category.',
        ]);
    
        // NOTE: You have is_available = 0 hardcoded.
        // If you want it to be dynamic, add it to validation and get from request.
        $validatedData['is_available'] = 0; 

        if ($request->file('mod_image')) {
            // ... your image handling code ...
            $validatedData['mod_image'] = $originalFileName;
        }

        // Now, $validatedData will correctly contain the validated 'category_id'.
        Modifier::create($validatedData);
    
        return redirect()->route('backend.modifier.index')->with('success', 'Modifier has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $mod_id)
    {
        $modifier = Modifier::findOrFail($mod_id);
        $categories = ProductCategory::orderBy('category_name', 'asc')->get();
        return view('backend.v_modifier.show', [
            'title' => 'Modifier',
            'show' => $modifier,
            'category' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $mod_id)
    {
        $modifier = Modifier::findOrFail($mod_id);
        $categories = ProductCategory::orderBy('category_name', 'asc')->get();
        return view('backend.v_modifier.edit', [
            'title' => 'Modifier',
            'edit' => $modifier,
            'category' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $mod_id)
    {
        $modifier = Modifier::findOrFail($mod_id);
        $rules = [
            'mod_name' => [
                'required',
                'max:255',
                Rule::unique('modifiers', 'mod_name')->ignore($modifier->mod_id, 'mod_id'),
            ],
            'mod_image' => 'nullable|image|mimes:jpeg,jpg,png|file|max:1024',
            'is_available' => 'required|boolean',
        ];
        $messages = [
            'mod_name.unique' => 'This modifier name is already taken.',
            'mod_image.image' => 'Picture format must be jpeg, jpg, or png.',
            'mod_image.max'   => 'Picture max size is 1024 KB.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $validatedData['is_available'] = $request->boolean('is_available');

        if ($request->file('mod_image')) {
            // Remove old images
            if ($modifier->mod_image) {
                $directory = public_path('storage/img-modifier/');
                $oldFiles = [
                    $directory . $modifier->mod_image,
                    $directory . 'thumb_lg_' . $modifier->mod_image,
                    $directory . 'thumb_md_' . $modifier->mod_image,
                    $directory . 'thumb_sm_' . $modifier->mod_image
                ];
                foreach ($oldFiles as $file) {
                    if (file_exists($file)) {
                        @unlink($file);
                    }
                }
            }
            $file = $request->file('mod_image');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-modifier/';

            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);

            $validatedData['mod_image'] = $originalFileName;
        }

        $modifier->update($validatedData);
        return redirect()->route('backend.modifier.index')->with('success', 'Modifier successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mod_id)
    {
        $modifier = Modifier::findOrFail($mod_id);
        if ($modifier->mod_image) {
            $directory = public_path('storage/img-modifier/');
            $files = [
                $directory . $modifier->mod_image,
                $directory . 'thumb_lg_' . $modifier->mod_image,
                $directory . 'thumb_md_' . $modifier->mod_image,
                $directory . 'thumb_sm_' . $modifier->mod_image
            ];
            foreach ($files as $file) {
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
        }
        $modifier->delete();
        return redirect()->route('backend.modifier.index')->with('success', 'Modifier deleted successfully.');
    }

    // Optionally adjust or remove these if not needed
    public function formModifier()
    {
        return view('backend.v_modifier.form', [
            'title' => 'Modifier Data Page',
        ]);
    }

    public function detail($mod_id)
    {
        $detail = Modifier::findOrFail($mod_id);
        $categories = ProductCategory::orderBy('category_name', 'desc')->get();
        return view('v_modifier.detail', [
            'title' => 'Detail Modifier',
            'kategori' => $categories,
            'row' => $detail
        ]);
    }

    public function Productcategory($category_id)
    {
        $categories = ProductCategory::orderBy('category_name', 'desc')->get();
        $modifiers = Modifier::where('category_id', $category_id)->where('is_available', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_modifier.Productcategory', [
            'title' => 'Filter Category',
            'Category' => $categories,
            'modifier' => $modifiers,
        ]);
    }

    public function modifierAll()
    {
        $categories = ProductCategory::orderBy('category_name', 'desc')->get();
        $modifiers = Modifier::where('is_available', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_modifier.index', [
            'title' => 'All Modifier',
            'category' => $categories,
            'modifier' => $modifiers,
        ]);
    }
}