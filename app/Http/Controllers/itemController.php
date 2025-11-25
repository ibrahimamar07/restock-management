<?php
// app/Http/Controllers/ItemController.php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class itemController extends Controller
{
    // Show add items form
    public function create($storeId)
    {
        $store = Store::findOrFail($storeId);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }
       

        $items = Item::where('idStore', $storeId)->get();
        return view('managemystore.additemstoreview', compact('store', 'items'));
    }

    // Store new item
    public function store(Request $request, $storeId)
    {
        $store = Store::findOrFail($storeId);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        $request->validate([
            'itemName' => 'required|string|max:255',
            'itemPrice' => 'required|integer|min:0'
        ]);

        Item::create([
            'idStore' => $storeId,
            'itemName' => $request->itemName,
            'itemPrice' => $request->itemPrice
        ]);

        return redirect()->back()->with('success', 'Item added successfully!');
    }

    // Show edit item form (you can create a modal or separate page)
    // public function edit($id)
    // {
    //     $item = Item::with('store')->findOrFail($id);
        
    //     // Check if user owns this store (skip untuk testing)
    //     // $userId = 1; // Hardcode untuk testing
    //     // if ($item->store->idUser !== $userId) {
    //     //     abort(403, 'Unauthorized action.');
    //     // }

    //     return view('managemystore.edititemview', compact('item'));
    // }

    // Update item
    public function update(Request $request, $id)
    {
        $item = Item::with('store')->findOrFail($id);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($item->store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        $request->validate([
            'itemName' => 'required|string|max:255',
            'itemPrice' => 'required|integer|min:0'
        ]);

        $item->update([
            'itemName' => $request->itemName,
            'itemPrice' => $request->itemPrice
        ]);

        return redirect()->route('stores.show', $item->idStore)->with('success', 'Item updated successfully!');
    }

    // Delete item
    public function destroy($id)
    {
        $item = Item::with('store')->findOrFail($id);
        
        // Check if user owns this store (skip untuk testing)
        // $userId = 1; // Hardcode untuk testing
        // if ($item->store->idUser !== $userId) {
        //     abort(403, 'Unauthorized action.');
        // }

        $storeId = $item->idStore;
        $item->delete();

        return redirect()->route('stores.show', $storeId)->with('success', 'Item deleted successfully!');
    }
}