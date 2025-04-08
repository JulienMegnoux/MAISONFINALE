@extends('layouts.app')

@section('content')
    <h2>Liste des membres</h2>

    <ul>
        @foreach ($users as $user)
            <li>
                <a href="{{ route('users.show', $user->id) }}">
                    {{ $user->name }} ({{ $user->type ?? 'type inconnu' }})
                </a>
            </li>
        @endforeach
    </ul>
@endsection
