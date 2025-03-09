<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyExpert - Système Expert en Enseignement Supérieur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .hero {
            background: linear-gradient(to right, #007bff, #6610f2);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .card {
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <header class="hero">
        <div class="container">
            <h1>Bienvenue sur MyExpert</h1>
            <p>Un système expert dédié à la gestion de l'enseignement supérieur</p>
            <a href="#services" class="btn btn-light btn-lg">Explorer</a>
        </div>
    </header>
    <section id="services" class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h3>Recherche d'Université</h3>
                    <p>Recherchez une université par son nom et découvrez ses programmes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h3>Programmes & Cours</h3>
                    <p>Trouvez les programmes offerts et les cours associés.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h3>Enseignants & Étudiants</h3>
                    <p>Identifiez les enseignants et les étudiants affiliés aux universités.</p>
                </div>
            </div>
        </div>
    </section>
    <footer class="text-center py-4 bg-dark text-light">
        <p>&copy; 2025 MyExpert - Tous droits réservés</p>
    </footer>
</body>
</html>
