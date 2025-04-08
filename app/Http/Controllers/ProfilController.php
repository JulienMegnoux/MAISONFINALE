<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'date_naissance' => 'nullable|date',
            'genre' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            // ✅ Upload de photo
            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $validated['photo'] = $request->file('photo')->store('photos', 'public');
            }

            // ✅ Mise à jour du profil
            $user->update($validated);

            return redirect()->route('profil.edit')->with('success', 'Profil mis à jour avec succès.');

        } catch (\Exception $e) {
            return redirect()->route('profil.edit')->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
}
