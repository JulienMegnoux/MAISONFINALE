<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::first(); // On récupère la première (et unique) ligne de paramètres
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255',
            'theme_color' => 'nullable|string|max:7',
            'welcome_message' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $settings = Setting::firstOrCreate([], []); // Crée si aucun paramètre n'existe

        $settings->platform_name = $request->platform_name;
        $settings->theme_color = $request->theme_color;
        $settings->welcome_message = $request->welcome_message;

        if ($request->hasFile('logo')) {
            // Supprime l'ancien logo si présent
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo_path = $path;
        }

        $settings->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Paramètres mis à jour avec succès.');
    }
}
