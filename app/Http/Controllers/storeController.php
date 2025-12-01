<?php
// ibrahim amar alfanani 5026231195
// app/Http/Controllers/StoreController.php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Requests\Store\UpdateRequest;
use App\Services\StoreImageService; 

class StoreController extends Controller

//kalau mau ubah controller ini lihat dulu validasi di StoreRequest dan UpdateRequest jangan tambah validasi langsung disini!!!
{
    protected $imageService;

    //Dependency Injection
    public function __construct(StoreImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    
   
    private function getUserId()
    {  
        return Auth::id();  
    }

    // Display list of user's stores
    public function index()
    {
        $userId = $this->getUserId();
        $stores = Store::where('idUser', $userId)->paginate(10);
        return view('managemystore.mystoreview', compact('stores'));
    }

    // Show create store form
    public function create()
    {
        return view('managemystore.setupstoreview');
    }

    /**
     * Store new store (Validasi dipindah ke StoreStoreRequest)
     * @param StoreStoreRequest $request
     */
    public function store(StoreRequest $request) 
    {
        // 1. Ambil semua data yang sudah divalidasi
        $data = $request->validated(); 

        // 2. Proses Gambar menggunakan Service dan simpan nama file
        $imageName = $this->imageService->saveImage($request->file('storePic'));
        
        // 3. Siapkan data untuk dimasukkan ke database dengan penyederhanaan
        $data['idUser'] = $this->getUserId(); 
        $data['storePic'] = $imageName; // Ganti object file dengan nama file string
        
        // 4. Simpan Data ke Database menggunakan array $data lengkap
        Store::create($data);

        return redirect()->route('stores.index')->with('success', 'Store created successfully!');
    }

    /**
     * Show specific store with items (Menggunakan Route Model Binding)
     * @param Store $store
     */
    public function show(Store $store) 
    {
         $this->authorize('manage', $store);
         $items = $store->items()->paginate(10);
        return view('managemystore.storedetailview', compact('store', 'items'));
    }

    /**
     * Show edit store form (Menggunakan Route Model Binding)
     * @param Store $store
     */
    public function edit(Store $store)
    {
        
        $this->authorize('manage', $store);
        
        return view('managemystore.editstoreview', compact('store'));
    }

    /**
     * Update store ( Route Model Binding dan Form Request)
     * @param StoreUpdateRequest $request
     * @param Store $store
     */
    public function update(UpdateRequest $request, Store $store)
    {
         $this->authorize('manage', $store);

        $data = $request->validated();
        $imageName = $store->storePic; 

        // 2. Logika Pengunggahan dan Penghapusan Gambar Baru
        if ($request->hasFile('storePic')) {
            
            // A. Proses Penghapusan Gambar Lama (Menggunakan Service)
            $this->imageService->deleteImage($store->storePic); 
            
            // B. Unggah Gambar Baru (Menggunakan Service)
            $imageName = $this->imageService->saveImage($request->file('storePic'));
        }

        // 3. Update Data Toko di Database
        // Menggunakan array $data yang sudah divalidasi dan menimpa 'storePic'
        $data['storePic'] = $imageName;

        $store->update($data);

        return redirect()->route('stores.show', $store->idStore)->with('success', 'Store updated successfully!');
    }

    /**
     * Delete store (Menggunakan Route Model Binding)
     * @param Store $store
     */
    public function destroy(Store $store)
    {
        $this->authorize('manage', $store);
        
        // 2. Hapus Gambar  Sebelum Menghapus Record Database 
        $this->imageService->deleteImage($store->storePic);

        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Store deleted successfully!');
    }
}