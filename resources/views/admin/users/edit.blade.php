<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
</head>
<body style="font-family: Arial; background: #f0f0f0; padding: 40px;">
    <h1>✏️ Modifier l'utilisateur</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nom :</label><br>
        <input type="text" name="name" value="{{ $user->name }}" required><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" value="{{ $user->email }}" required><br><br>

        <label>Mot de passe (laisser vide si inchangé) :</label><br>
        <input type="password" name="password"><br><br>

        <label>Rôle :</label><br>
        <input type="text" name="role" value="{{ $user->role }}"><br><br>

        <label>Points :</label><br>
        <input type="number" name="points" value="{{ $user->points }}"><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <br><a href="{{ route('admin.dashboard') }}">⬅ Retour</a>
</body>
</html>
