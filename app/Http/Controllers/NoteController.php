<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Item $item)
    {
        $notes = $item->notes()->with('user')->latest()->get();

        return view('notes.index', compact('item', 'notes'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $note = new Note([
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        $item->notes()->save($note);

        return redirect()->back()->with('status', 'Catatan disimpan.');
    }

    /**
     * Public store: allow guests to submit a general note (no item required).
     */
    public function publicStore(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $note = Note::create([
            'content' => $request->input('content'),
            'user_id' => Auth::check() ? Auth::id() : null,
            'item_id' => null,
        ]);

        return redirect()->back()->with('status', 'Catatan publik disimpan.');
    }

    public function destroy(Item $item, Note $note)
    {
        // Simple authorization: only creator can delete
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->back()->with('status', 'Catatan dihapus.');
    }
}
