<?php
// app/Http/Controllers/ItemController.php
// ibrahim amar alfanani 5026231195

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;

class ItemController extends Controller
{

    /**
     * Tampilkan form tambah item dan daftar item (Daftar Item Toko).
     * @param Store $store Menggunakan Route Model Binding
     */
    public function createItemView(Store $store) 
    {
        // 1. Otorisasi: Pastikan pengguna yang login adalah pemilik toko ini.
        $this->authorize('manage', $store);
        
        return view('managemystore.additemstoreview', compact('store'));
    }

    /**
     * Simpan item baru ke toko.
     * @param ItemStoreRequest $request Menggunakan Form Request untuk validasi
     * @param Store $store Menggunakan Route Model Binding
     */
    public function addItem(ItemStoreRequest $request, Store $store)
    {
        // 1. Otorisasi: Pastikan pengguna yang login adalah pemilik toko ini.
        $this->authorize('manage', $store);

        // 2. Validasi sudah dilakukan oleh ItemStoreRequest, gunakan validated()
        
        // 3. Simpan Item menggunakan relasi store
        $store->items()->create($request->validated());

        return redirect()->back()->with('success', 'Item added successfully!');
    }

    /**
     * Update item yang sudah ada.
     * @param ItemStoreRequest $request Menggunakan Form Request untuk validasi
     * @param Item $item Menggunakan Route Model Binding
     */
    public function updateItem(ItemUpdateRequest $request, Item $item)
    {
        // 1. Otorisasi: Pastikan pengguna yang login adalah pemilik toko dari item ini.
        // Item memiliki relasi ke Store, sehingga saya cek kepemilikan di Store.
        $this->authorize('manage', $item->store); 

        // 2. Update data
        $item->update($request->validated());

        // Redirect ke detail store
        return redirect()->route('stores.showStore', $item->idStore)->with('success', 'Item updated successfully!');
    }

    /**
     * Hapus item.
     * @param Item $item Menggunakan Route Model Binding
     */
    public function deleteItem(Item $item)
    {
        // 1. Otorisasi: Pastikan pengguna yang login adalah pemilik toko dari item ini.
        $this->authorize('manage', $item->store); 
        
        $storeId = $item->idStore;
        $item->delete();

        return redirect()->route('stores.showStore', $storeId)->with('success', 'Item deleted successfully!');
    }
}