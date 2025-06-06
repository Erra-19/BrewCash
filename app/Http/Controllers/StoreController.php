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
        $user = auth()->user();
        $stores = collect();

        if ($user->isOwner()) {
            $stores = Store::where('user_id', $user->user_id)->orderBy('store_name', 'asc')->get();
        } 
        elseif ($user->isStaff()) {
            $stores = $user->staffs()
            ->wherePivot('status', 1)
            ->wherePivotIn('store_role', ['Manager', 'Admin'])
            ->orderBy('store_name', 'asc')
            ->get();
        }

        return view('backend.v_store.index', [
            'title' => 'My Stores',
            'sub' => 'Store Page',
            'stores' => $stores
        ]);
    }

    public function create()
    {
        return view('backend.v_store.create', [
            'title' => 'Store',
            'sub' => 'Register Store',
        ]);
    }

    public function edit(string $store_id)
    {
        $store = Store::findOrFail($store_id);
        return view('backend.v_store.edit', [
            'title' => 'Store',
            'sub'   => 'Edit Store',
            'edit' => $store
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_icon' => 'nullable|image|max:2048',
        ]);

        $store = Store::create([
            'store_name' => $validatedData['store_name'],
            'store_address' => $validatedData['store_address'],
            'user_id' => auth()->id(),
            ]);

        return redirect()->route('backend.store.index')->with('success', 'Store registered successfully!');
    }

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
