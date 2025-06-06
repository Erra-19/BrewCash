<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modifier;
use App\Models\ProductCategory;
use App\Helpers\ImageHelper;
use Illuminate\Validation\Rule;
use App\Traits\LoggableActivity;

class ModifierController extends Controller
{
    use LoggableActivity;
    public function index()
    {
        if (!session('active_store_id')) {
            $modifiers = collect();
        } else {
            $modifiers = Modifier::where('store_id', session('active_store_id'))
                ->orderBy('mod_id', 'desc')
                ->get();
        }
        
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
            'mod_name' => 'required|max:255|unique:modifiers,mod_name',
            'mod_image'   => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'category_id' => 'required|exists:product_categories,category_id',
        ], [
            'mod_name.unique' => 'This modifier name already exists.',
            'mod_image.image' => 'Picture format must be jpeg, jpg, or png.',
            'mod_image.max' => 'Picture max size is 1024 KB.',
            'category_id.required' => 'Please select a category.',
        ]);

        $validatedData['is_available'] = 0;

        if ($request->file('mod_image')) {
            $file = $request->file('mod_image');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-modifiers/'; // Corrected directory name
            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['mod_image'] = $originalFileName;
        }

        $validatedData['is_available'] = 0;
        $validatedData['store_id'] = session('active_store_id');
        $modifier = Modifier::create($validatedData);
        $this->logActivity(
            type: 'Modifier',
            action: 'Created new modifier',
            meta: [
                'modifier_id'   => $modifier->mod_id,
                'modifier_name' => $modifier->mod_name
            ]
        );
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
    public function toggle(Modifier $modifier)
    {
        $modifier->is_available = !$modifier->is_available;
        $modifier->save();
        $this->logActivity(
            type: 'Modifier',
            action: $modifier->is_available ? 'Activated modifier' : 'Deactivated modifier',
            meta: [
                'modifier_id'   => $modifier->mod_id,
                'modifier_name' => $modifier->mod_name
            ]
        );

        return back()->with('success', 'Modifier status updated successfully!');
    }
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
            'mod_image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ];
        $messages = [
            'mod_name.unique' => 'This modifier name is already taken.',
            'mod_image.image' => 'Picture format must be jpeg, jpg, or png.',
            'mod_image.max'   => 'Picture max size is 1024 KB.'
        ];
        $validatedData = $request->validate($rules, $messages);

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
        $this->logActivity(
            type: 'Modifier',
            action: 'Updated modifier details',
            meta: [
                'modifier_id'   => $modifier->mod_id,
                'modifier_name' => $modifier->mod_name,
                'updated_fields' => array_keys($validatedData)
            ]
        );
        return redirect()->route('backend.modifier.index')->with('success', 'Modifier successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mod_id)
    {
        $this->logActivity(
            type: 'Modifier',
            action: 'Deleted modifier',
            meta: [
                'modifier_id'   => $modifier->mod_id,
                'modifier_name' => $modifier->mod_name
            ]
        );
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