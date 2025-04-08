<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 40px;
    }
    h1, h2 {
      color: #003366;
    }
    .section {
      background: white;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 12px;
      text-align: left;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    form.inline {
      display: inline;
    }
    button, .btn-link {
      cursor: pointer;
      padding: 6px 10px;
      font-size: 14px;
      border-radius: 5px;
      text-decoration: none;
    }
    .btn-add {
      background-color: #4CAF50;
      color: white;
      border: none;
    }
    .btn-delete {
      background-color: #e74c3c;
      color: white;
      border: none;
    }
    .btn-link {
      background-color: #3498db;
      color: white;
      margin-bottom: 20px;
      display: inline-block;
    }
  </style>
</head>
<body>

<h1>Bienvenue dans l'espace Admin 👨‍💻</h1>

<!-- 🔧 Bouton de configuration -->
<a href="{{ route('admin.settings.edit') }}" class="btn-link">⚙️ Personnalisation de la plateforme</a>

<!-- Section utilisateurs -->
<div class="section">
  <h2>👥 Utilisateurs</h2>
  <a href="{{ route('admin.users.create') }}" class="btn-add">➕ Ajouter un utilisateur</a>

  <table>
    <tr>
      <th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Points</th><th>Statut</th><th>Actions</th>
    </tr>
    @foreach($users as $user)
    <tr>
      <td>{{ $user->id }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->role }}</td>
      <td>{{ $user->points }}</td>
      <td>
        @if ($user->is_approved)
          ✅ Approuvé
        @else
          <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button class="btn-add">✅ Approuver</button>
          </form>
        @endif
      </td>
      <td>
        <a href="{{ route('admin.users.edit', $user->id) }}">✏️</a>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button class="btn-delete" onclick="return confirm('Supprimer cet utilisateur ?')">🗑️</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
</div>

<!-- Section logs -->
<div class="section">
  <h2>🕓 Historique des connexions et actions</h2>
  <table>
    <tr>
      <th>Date</th><th>Utilisateur</th><th>Action</th><th>Description</th>
    </tr>
    @foreach($logs as $log)
    <tr>
      <td>{{ $log->created_at }}</td>
      <td>{{ $log->user->name ?? 'Utilisateur supprimé' }}</td>
      <td>{{ $log->action }}</td>
      <td>{{ $log->description }}</td>
    </tr>
    @endforeach
  </table>
</div>

<!-- Section catégories -->
<div class="section">
  <h2>📂 Catégories d'objets et services</h2>
  <form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <input type="text" name="nom" placeholder="Nom de la catégorie" required>
    <select name="type" required>
      <option value="objet">Objet</option>
      <option value="service">Service</option>
    </select>
    <button type="submit" class="btn-add">➕ Ajouter une catégorie</button>
  </form>

  <table>
    <tr>
      <th>Nom</th><th>Type</th><th>Actions</th>
    </tr>
    @foreach($categories as $categorie)
    <tr>
      <td>{{ $categorie->nom }}</td>
      <td>{{ $categorie->type }}</td>
      <td>
        <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button class="btn-delete" onclick="return confirm('Supprimer cette catégorie ?')">🗑️</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
</div>

<!-- Section objets -->
<div class="section">
  <h2>🛠️ Objets et Outils/Services</h2>
  <form action="{{ route('admin.items.store') }}" method="POST">
    @csrf
    <input type="text" name="nom" placeholder="Nom de l'objet/service" required>
    <select name="category_id" required>
      @foreach($categories as $categorie)
        <option value="{{ $categorie->id }}">{{ $categorie->nom }} ({{ $categorie->type }})</option>
      @endforeach
    </select>
    <button type="submit" class="btn-add">➕ Ajouter un objet/service</button>
  </form>

  <table>
    <tr>
      <th>Nom</th><th>Catégorie</th><th>Actions</th>
    </tr>
    @foreach($items as $item)
    <tr>
      <td>{{ $item->nom }}</td>
      <td>{{ $item->category->nom }}</td>
      <td>
        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button class="btn-delete" onclick="return confirm('Supprimer cet objet/service ?')">🗑️</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
</div>

</body>
</html>
