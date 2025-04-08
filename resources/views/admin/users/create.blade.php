<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
</head>
<body style="font-family: Arial; background: #f0f0f0; padding: 40px;">
    <h1>➕ Ajouter un utilisateur</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <label>Nom :</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <label>Rôle :</label><br>
        <input type="text" name="role" value="user"><br><br>

        <label>Points :</label><br>
        <input type="number" name="points" value="0"><br><br>

        <button type="submit">Créer</button>
    </form>

    <br><a href="{{ route('admin.dashboard') }}">⬅ Retour</a>
</body>
</html>
