<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyExpert</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7fa;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      background-color: #0d6efd;
      color: white;
      width: 250px;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .sidebar h3 {
      font-size: 1.5rem;
      margin-bottom: 20px;
      text-align: center;
    }

    .sidebar a {
      color: white;
      padding: 12px;
      width: 100%;
      text-decoration: none;
      text-align: center;
      border-radius: 5px;
      transition: background 0.3s;
      cursor: pointer;
      margin: 5px;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.2);
    }

    /* Contenu */
    .content {
      margin-left: 260px;
      padding: 30px;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .hidden {
      display: none;
    }

    .search-container {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      /* max-width: 600px; */
    }

    /* Résultats */
    .result-container {
      margin-top: 30px;
      width: 100%;
      /* max-width: 600px; */
    }

    .result-container ul {
      background: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 10px;
      }
      .content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h3>MyExpert</h3>
    <a href="{{ route('accueil') }}"  class="{{ request()->routeIs('accueil') ? 'active' : '' }}">Accueil</a>
    <a href="{{ route('sparql') }}"  class="{{ request()->routeIs('sparql') ? 'active' : '' }}">Université</a>
    <a href="{{ route('voir.programme') }}" class="{{ request()->routeIs('voir.programme') ? 'active' : '' }}">Programme</a>
    <a href="{{ route('voir.etudiant') }}" class="{{ request()->routeIs('voir.etudiant') ? 'active' : '' }}" >Etudiant</a>
    <a href="{{ route('voir.personnel') }}" class="{{ request()->routeIs('voir.personnel') ? 'active' : '' }}">Personnel</a>
    <a href="{{ route('voir.enseignant_cours') }}" class="{{ request()->routeIs('voir.enseignant_cours') ? 'active' : '' }}">Enseignant-Cours</a>
    <a href="{{ route('voir.univ_programme') }}" class="{{ request()->routeIs('voir.univ_programme') ? 'active' : '' }}" >Univ - Programme</a>
    <a href="{{ route('voir.programme_univ') }}" class="{{ request()->routeIs('voir.programme_univ') ? 'active' : '' }}" >Programme - Univ</a>
    <a href="{{ route('voir.enseignant_universite') }}" class="{{ request()->routeIs('voir.enseignant_universite') ? 'active' : '' }}" >Enseignant - Université</a>
    <a href="{{ route('voir.enseignant_etudiant') }}" class="{{ request()->routeIs('voir.enseignant_etudiant') ? 'active' : '' }}" >Enseignant - Étudiant</a>
  </div>

  <!-- Contenu -->
  <div class="content">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width:100%">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:100%">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

  
    {{ $slot }}

    

  </div>

  <script>
    function showSection(sectionId) {
      // Masquer toutes les sections
      document.querySelectorAll('.search-container').forEach(section => {
        section.classList.add('hidden');
      });

      // Afficher la section sélectionnée
      document.getElementById(sectionId).classList.remove('hidden');

      // Mettre à jour la classe "active" dans la sidebar
      document.querySelectorAll('.sidebar a').forEach(link => {
        link.classList.remove('active');
      });

      event.target.classList.add('active');
    }
  </script>

</body>
</html>
