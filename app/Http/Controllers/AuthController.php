<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserLog;
use App\Mail\VerificationCodeMail;
use App\Models\Piece;

class AuthController extends Controller
{

    

    public function showRegister()
    {
        return view('inscription');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $code = rand(100000, 999999);

        Session::put('verification_code', $code);
        Session::put('user_registration', [
            'name' => $request->prenom . ' ' . $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photoPath,
        ]);

        Mail::to($request->email)->send(new VerificationCodeMail($code));

        return redirect()->route('code.form')->with('success', 'Un code vous a été envoyé par mail.');
    }

    public function showCodeForm()
    {
        return view('verification_code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
        ]);

        if (Session::get('verification_code') == $request->code) {
            $data = Session::get('user_registration');

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'photo' => $data['photo'],
            ]);

            Session::forget(['verification_code', 'user_registration']);

            return redirect()->route('connexion')->with('success', 'Inscription confirmée ! Vous pouvez vous connecter.');
        } else {
            return back()->with('error', 'Code incorrect. Veuillez réessayer.');
        }
    }

    public function showLogin()
    {
        return view('connexion');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            UserLog::create([
                'user_id' => Auth::id(),
                'action' => 'connexion',
                'description' => 'Connexion réussie à la plateforme',
            ]);

            return redirect()->route('menu')->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ]);
    }

    public function showMenu()
    {
        $pieces = Piece::with('appareils')->get();
        return view('menu', compact('pieces'));
    }
}
