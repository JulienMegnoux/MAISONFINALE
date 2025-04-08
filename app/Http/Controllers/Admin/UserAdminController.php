<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $logs = UserLog::latest()->take(50)->get();
        $categories = Category::all();
        $items = Item::with('category')->get();

        return view('admin', compact('users', 'logs', 'categories', 'items'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'points' => 'required|integer',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_approved'] = true; // approuvé par défaut si créé par un admin

        User::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur ajouté.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'points' => 'required|integer',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur modifié.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur supprimé.');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur approuvé.');
    }
}
