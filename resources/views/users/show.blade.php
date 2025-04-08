@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card mx-auto shadow" style="max-width: 500px;">
        <div class="card-body text-center">

            {{-- Photo de profil ou avatar --}}
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle mb-3" width="120" height="120" alt="Photo de {{ $user->name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3a3a3a&color=fff&rounded=true" class="rounded-circle mb-3" width="120" height="120" alt="Avatar">
            @endif

            {{-- Nom --}}
            <h3 class="card-title">{{ $user->name }}</h3>

            {{-- Type de membre --}}
            <p class="text-muted"><i class="bi bi-person-badge"></i> {{ $user->type ?? 'Non défini' }}</p>

            {{-- Genre --}}
            <p><i class="bi bi-gender-ambiguous"></i> {{ $user->genre ?? 'Non renseigné' }}</p>

            {{-- Date de naissance --}}
            <p><i class="bi bi-calendar-date"></i>
                @if ($user->date_naissance)
                    Né(e) le {{ \Carbon\Carbon::parse($user->date_naissance)->translatedFormat('d F Y') }}
                @else
                    Date de naissance non renseignée
                @endif
            </p>

        </div>
    </div>
</div>
@endsection
