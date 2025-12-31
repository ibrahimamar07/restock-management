<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class RestockSubmissionController extends Controller
{
    public function create($idItem)
    {
        $item = Item::where('idItem', $idItem)->firstOrFail();
        
        // Pastikan nama view ini sesuai dengan file yang Anda punya
        return view('managemystore.browsestoreview.addproofofrestockview', compact('item'));
    }

    public function store(Request $request)
    {
        // ... (Kode validasi & simpan biarkan sama seperti sebelumnya) ...
        // Redirect balik ke browse setelah sukses
        return redirect()->route('browse.index')->with('success', 'Restock proof submitted!');
    }
}