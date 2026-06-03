<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Invoice;

class RestockController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // 2. Proses Upload Gambar
        if ($request->hasFile('proof_image')) {
            // Simpan ke folder 'storage/app/public/proofs'
            $imagePath = $request->file('proof_image')->store('proofs', 'public');
        }

        // 3. Simpan ke Database (Sesuaikan nama Model dan Kolom Tabel Anda)
        // Contoh ini menggunakan asumsi tabel 'invoices' atau 'restocks'
        Invoice::create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'proof_image_path' => $imagePath, // Simpan path gambar
            'status' => 'pending', // Status awal
            'user_id' => auth()->id(), // Jika perlu ID user yang login
        ]);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('stores.index')->with('success', 'Bukti restock berhasil dikirim!');
    }

    public function create($itemId)
    {
        // Ambil data item agar user tahu apa yang mereka restock
        $item = Item::findOrFail($itemId);
        
        return view('managemystore.browsestoreview.addproofofrestockview', compact('item'));
    }
}
