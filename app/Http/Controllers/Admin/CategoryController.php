<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:objet,service',
        ]);

        Category::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Catégorie ajoutée.');
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()->route('admin.dashboard')->with('success', 'Catégorie supprimée.');
    }
}
