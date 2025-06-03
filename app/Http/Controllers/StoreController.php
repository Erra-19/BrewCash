<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Helpers\ImageHelper;
use App\Helpers\PasswordHelper;
use Illuminate\Support\Facades\Hash;

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
// StoreController.php

public function store(Request $request)
{
    // Validate and create the store
    $validatedData = $request->validate([
        'store_name' => 'required|string|max:255',
        'store_address' => 'required|string',
        'store_icon' => 'nullable|image|max:2048', // add other validations as needed
    ]);

    // handle file upload, etc.

    $store = Store::create([
        'store_name' => $validatedData['store_name'],
        'store_address' => $validatedData['store_address'],
        'user_id' => auth()->id(),
        // handle icon and other fields
    ]);

    return redirect()->route('backend.store.index')->with('success', 'Store registered successfully!');
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
    public function activate($store_id)
    {
        $store = Store::where('user_id', auth()->id())->findOrFail($store_id);
        session(['active_store_id' => $store->store_id]);
        return back()->with('success', 'Store activated!');
    }
    public function deactivate()
    {
        session()->forget('active_store_id');
        return back()->with('success', 'Store deactivated!');
    }
}
