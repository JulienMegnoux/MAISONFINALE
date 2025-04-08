<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Vérification de l'adresse email</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      padding: 20px;
    }
    .container {
      max-width: 400px;
      margin: auto;
      background: #fff;
      padding: 20px;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    h1 { text-align: center; }
    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #3a3a3a;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
    }
    .alert {
      padding: 10px;
      background-color: #f8d7da;
      color: #721c24;
      border-radius: 4px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Vérifiez votre email</h1>

    @if (session('error'))
      <div class="alert">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('code.verifier') }}" method="POST">
      @csrf
      <label for="code">Code reçu par mail :</label>
      <input type="text" id="code" name="code" required placeholder="Ex: 123456">
      <button type="submit">Vérifier</button>
    </form>
  </div>
</body>
</html>
