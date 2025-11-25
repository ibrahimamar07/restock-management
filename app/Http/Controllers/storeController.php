<?php
// app/Http/Controllers/StoreController.php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class storeController extends Controller
{
    // Display list of user's stores
    public function index()
    {
        // Untuk testing tanpa login, gunakan user ID = 1
        // Setelah ada login, ganti dengan: Auth::id()
        $userId = 1; // Hardcode untuk testing
        $stores = Store::where('idUser', $userId)->get();
        return view('managemystore.mystoreview', compact('stores'));
    }

    // Show create store form
    public function create()
    {
        return view('managemystore.setupstoreview');
    }

    // Store new store
    public function store(Request $request)
    {
        $request->validate([
            'storeName' => 'required|string|max:255',
            'storeAddress' => 'required|string',
            'storeDesc' => 'nullable|string',
            'storePic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Untuk testing tanpa login, user ID = 1
        $userId = 1; 
        $imageName = time().'.'.$request->storePic->extension(); 
        $request->storePic->storeAs('storepic', $imageName, 'public');
        Store::create([
            'idUser' => $userId,
            'storeName' => $request->storeName,
            'storeAddress' => $request->storeAddress,
            'storeDesc' => $request->storeDesc,
            'storePic' => $imageName,
        ]);
      

        return redirect()->route('stores.index')->with('success', 'Store created successfully!');
    }

    // Show specific store with items
    public function show($id)
    {
        $store = Store::with('items')->findOrFail($id);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('managemystore.storedetailview', compact('store'));
    }

    // Show edit store form
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('managemystore.editstoreview', compact('store'));
    }

    // Update store
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        $request->validate([
            'storeName' => 'required|string|max:255',
            'storeAddress' => 'required|string',
            'storeDesc' => 'nullable|string',
            'storePic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = $store->storePic; // Secara default, gunakan nama gambar lama

    // 2. Logika Pengunggahan dan Penghapusan Gambar Baru
    if ($request->hasFile('storePic')) {
        
        // A. Proses Penghapusan Gambar Lama
        // Cek apakah ada gambar lama, dan hapus dari storage.
        
        if ($store->storePic) {
            // Path lengkap ke file lama: storepic/namafilelama.jpg
            Storage::disk('public')->delete('storepic/' . $store->storePic); 
        }
       
        // B. Unggah Gambar Baru
        $imageName = time().'.'.$request->storePic->extension();
        
        // Simpan file baru ke: storage/app/public/storepic/namafileunikbaru.jpg
        $request->storePic->storeAs('storepic', $imageName, 'public'); 
    }
        $store->update([
            'storeName' => $request->storeName,
            'storeAddress' => $request->storeAddress,
            'storeDesc' => $request->storeDesc,
            'storePic' => $imageName,
        ]);

        return redirect()->route('stores.show', $store->idStore)->with('success', 'Store updated successfully!');
    }

    // Delete store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Store deleted successfully!');
    }
}