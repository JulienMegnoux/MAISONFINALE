<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Item::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Objet ou service ajouté.');
    }

    public function destroy($id)
    {
        Item::destroy($id);

        return redirect()->route('admin.dashboard')->with('success', 'Objet ou service supprimé.');
    }
}
