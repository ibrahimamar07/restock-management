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
{
    protected $imageService;

    //Dependency Injection
    public function __construct(StoreImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    
   
    private function getUserId()
    {
        //buat testing sementara
        return Auth::check() ? Auth::id() : 1; 
        
    }

    // Display list of user's stores
    public function index()
    {
        $userId = $this->getUserId();
        $stores = Store::where('idUser', $userId)->get();
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
        if ($store->idUser !== $this->getUserId()) {
            abort(403, 'Unauthorized action.');
        }
        return view('managemystore.storedetailview', compact('store'));
    }

    /**
     * Show edit store form (Menggunakan Route Model Binding)
     * @param Store $store
     */
    public function edit(Store $store)
    {
        
        if ($store->idUser !== $this->getUserId()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('managemystore.editstoreview', compact('store'));
    }

    /**
     * Update store (Menggunakan Route Model Binding dan Form Request)
     * @param StoreUpdateRequest $request
     * @param Store $store
     */
    public function update(UpdateRequest $request, Store $store)
    {
        if ($store->idUser !== $this->getUserId()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();
        $imageName = $store->storePic; // Gunakan nama gambar lama secara default

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
        if ($store->idUser !== $this->getUserId()) {
            abort(403, 'Unauthorized action.');
        }
        
        // 2. Hapus Gambar  Sebelum Menghapus Record Database 
        $this->imageService->deleteImage($store->storePic);

        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Store deleted successfully!');
    }
}