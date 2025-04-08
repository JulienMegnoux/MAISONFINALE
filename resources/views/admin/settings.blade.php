@extends('layouts.app') <!-- Adapte ce layout si besoin -->

@section('content')
<div class="container">
    <h1>⚙️ Paramètres de la plateforme</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="platform_name" class="form-label">Nom de la plateforme :</label>
            <input type="text" name="platform_name" class="form-control" value="{{ $settings->platform_name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="theme_color" class="form-label">Couleur principale :</label>
            <input type="color" name="theme_color" class="form-control form-control-color" value="{{ $settings->theme_color ?? '#003366' }}">
        </div>

        <div class="mb-3">
            <label for="welcome_message" class="form-label">Message d’accueil :</label>
            <textarea name="welcome_message" class="form-control" rows="3">{{ $settings->welcome_message ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo actuel :</label><br>
            @if($settings && $settings->logo_path)
                <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" style="max-height: 100px;"><br>
            @else
                <em>Aucun logo</em><br>
            @endif
            <input type="file" name="logo" class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection
