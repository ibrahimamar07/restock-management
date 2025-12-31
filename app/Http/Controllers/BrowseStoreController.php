<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class BrowseStoreController extends Controller
{
    public function index()
    {
        $stores = Store::paginate(10);
        return view('managemystore.browsestoreview.storelistview', compact('stores'));
    }

    public function show($idStore)
    {
        $store = Store::with('items')->where('idStore', $idStore)->firstOrFail();
        
        // PERBAIKAN: Arahkan ke 'selectitemtorestockview'
        // Ini adalah halaman "Store Detail" di mana user memilih barang
        return view('managemystore.browsestoreview.selectitemtorestockview', compact('store'));
    }
}