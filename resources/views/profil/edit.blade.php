@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4">Modifier mon profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Nom --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" name="name" class="form-control"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" id="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        {{-- Date de naissance --}}
        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance</label>
            <input type="date" id="date_naissance" name="date_naissance" class="form-control"
                   value="{{ old('date_naissance', $user->date_naissance) }}">
        </div>

        {{-- Genre --}}
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" id="genre" name="genre" class="form-control"
                   value="{{ old('genre', $user->genre) }}">
        </div>

        {{-- Type (rôle) --}}
        <div class="mb-3">
            <label for="type" class="form-label">Rôle (type)</label>
            <input type="text" id="type" name="type" class="form-control"
                   value="{{ old('type', $user->type) }}">
        </div>

        {{-- Photo --}}
        <div class="mb-3">
            <label for="photo" class="form-label">Photo de profil</label>
            <input type="file" id="photo" name="photo" class="form-control">

            @if($user->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" width="100" alt="Photo actuelle" class="rounded">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
