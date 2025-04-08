<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Maison Connectée</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    .container {
      max-width: 500px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    }
    h1 { text-align: center; }
    form {
      display: flex;
      flex-direction: column;
    }
    label { margin-top: 10px; }
    input[type="email"],
    input[type="password"] {
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      margin-top: 20px;
      padding: 10px;
      background: #3a3a3a;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 4px;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 4px;
      margin-top: 10px;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 4px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Connexion</h1>

    @if ($errors->any())
      <div class="alert-danger">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    @if (session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
      @csrf
      <label for="email">Adresse mail :</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Se connecter</button>
    </form>
  </div>
</body>
</html>
