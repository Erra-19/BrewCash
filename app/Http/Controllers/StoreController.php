<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Helpers\ImageHelper;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('user_id', auth()->id())->orderBy('store_id', 'desc')->get();
        return view('backend.v_store.index', [
            'title' => 'Store',
            'sub' => 'Store Page',
            'stores' => $stores
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_store.create', [
            'title' => 'Store',
            'sub' => 'Register Store',
        ]);
    }
    // In App\Http\Controllers\StoreController.php

// Rename the old 'show' method to 'edit':
public function edit(string $store_id) // This will be mapped to backend.store.edit
{
    $store = Store::findOrFail($store_id);
    return view('backend.v_store.edit', [
        'title' => 'Store',
        'sub'   => 'Edit Store', // Optional: update sub-title if you use it
        'edit' => $store         // 'edit' is a suitable variable name for the edit view
    ]);
}
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'store_name' => 'required|max:255|unique:stores,store_name',
            'store_address' => 'required',
            'store_icon' => 'required|image|mimes:jpeg,jpg,png|file|max:1024',
        ], [
            'store_icon.image' => 'Picture format in jpeg, jpg, and png extension only.',
            'store_icon.max' => 'Picture max size is 1024 KB.'
        ]);
        $validatedData['status'] = 0;
        $validatedData['user_id'] = auth()->id();

        if ($request->file('store_icon')) {
            $file = $request->file('store_icon');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-store';

            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['store_icon'] = $fileName;

            // create thumbnail 1 (lg)
            $thumbnailLg = 'thumb_lg_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);

            // create thumbnail 2 (md)
            $thumbnailMd = 'thumb_md_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);

            // create thumbnail 3 (sm)
            $thumbnailSm = 'thumb_sm_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);

            // Simpan nama file asli di database
            $validatedData['picture'] = $originalFileName;
        }

        $store = Store::create($validatedData);
        return redirect()->route('backend.store.index')->with('success', 'Your store has been saved');
    }
    public function update(Request $request, string $store_id)
    {
        //ddd($request);
        $store = Store::findOrFail($store_id);
        $rules = [
            'store_name' => 'required|max:255|unique:stores,store_name,' . $store_id. ',store_id',
            'store_address' => 'required',
            'store_icon' => 'image|mimes:jpeg,jpg,png|file|max:1024',
        ];
        $messages=[
            'store_icon.image' => 'Picture format in jpeg, jpg, and png extension only.',
            'store_icon.max' => 'Picture max size is 1024 KB.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $validatedData['user_id'] = auth()->id();

        if ($request->file('store_icon')) {
            //hapus gambar lama
            if ($store->store_icon) {
                $directory = public_path('storage/img-store/');
                $oldImagePath = $directory . $store->store_icon;
                $oldThumbnailLg = $directory . 'thumb_lg_' . $store->store_icon;
                $oldThumbnailMd = $directory . 'thumb_md_' . $store->store_icon;
                $oldThumbnailSm = $directory . 'thumb_sm_' . $store->store_icon;
                foreach ([$oldImagePath, $oldThumbnailLg, $oldThumbnailMd, $oldThumbnailSm] as $img) {
                    if (file_exists($img)) unlink($img);
                }
            }
            $file = $request->file('store_icon');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-store/';

            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);

            $validatedData['store_icon'] = $originalFileName;
        }

        $store->update($validatedData);
        return redirect()->route('backend.store.index')->with('success', 'Store Info Has Been Updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $store_id)
    {
        $store = Store::findOrFail($store_id);
        if ($store->store_icon) {
            $directory = public_path('storage/img-store/');
            $icon = $directory . $store->store_icon;
            $thumbLg = $directory . 'thumb_lg_' . $store->store_icon;
            $thumbMd = $directory . 'thumb_md_' . $store->store_icon;
            $thumbSm = $directory . 'thumb_sm_' . $store->store_icon;

            foreach ([$icon, $thumbLg, $thumbMd, $thumbSm] as $file) {
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
        }
        $store->delete();
        return redirect()->route('backend.store.index')->with('success', 'Store deleted successfully.');
    }
    public function show(string $store_id)
    {
        // Load store and eager load staff relation (limit 5)
        $store = \App\Models\Store::with(['staffs' => function($q) {
            $q->orderBy('name')->limit(5);
        }])->findOrFail($store_id);

        return view('backend.v_store.show', [
            'title' => 'Store Detail',
            'store' => $store
        ]);
    }
}
