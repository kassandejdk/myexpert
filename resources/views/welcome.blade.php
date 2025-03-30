<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyExpert - Système Expert en Enseignement Supérieur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        /* Hero Section with Animated Background */
        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('{{ asset('493.jpg') }}');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            position: relative;
            animation: backgroundFade 10s infinite alternate; /* Animation de fond */
        }

        /* Animation d'opacité de l'arrière-plan */
        @keyframes backgroundFade {
            0% {
                opacity: 0.5;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(1.05);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 600;
            letter-spacing: 2px;
        }

        .hero p {
            font-size: 1.5rem;
            margin-top: 20px;
            opacity: 0.8;
        }

        .btn {
            padding: 15px 40px;
            background-color: transparent;
            border: 2px solid white;
            border-radius: 30px;
            color: white;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 30px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: white;
            color: #6610f2;
        }

        /* Overlay for text contrast */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero div {
            position: relative;
            z-index: 2;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 30px 0;
        }

        footer p {
            font-size: 1rem;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Bienvenue sur <span style="color:rgb(34, 174, 239)">MyExpert</span></h1>
            <p>Le système expert pour la gestion de l'enseignement supérieur</p>
            <a href="{{ route('accueil') }}" style="color:rgb(0, 0, 0)"><button class="btn" >Tester</button></a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 MyExpert - Tous droits réservés</p>
    </footer>

</body>
</html>
