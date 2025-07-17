<?php 
//  var_dump($_SESSION['erreurs'])
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MAXITSA</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <!-- Main Container -->
    <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex min-h-[600px]">
            <!-- Left Panel - Background Image (50%) -->
            <div class="w-1/2 relative overflow-hidden">
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://pbs.twimg.com/media/GAHy5JMWwAAIk2G.jpg')"></div>
                <!-- Overlay for better text readability -->
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            </div>

            <!-- Right Panel - Login Form (50%) -->
            <div class="w-1/2 bg-white flex flex-col justify-center px-8 py-12">
                <div class="max-w-sm mx-auto w-full bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-semibold text-orange-500 mb-2 text-center">Connectez-vous</h2>
                    <p class="text-gray-600 mb-8 text-center">Connectez-vous pour accéder à votre espace <span class="text-orange-500 font-bold">MAXITSA</span></p>
                    
                    <form class="space-y-6" method="POST" action="/connexion">
                        <div>
                            <!-- affichage du message d'identifiants incorrect en haut -->
                            <?php if(!empty($_SESSION['erreurs']['identifiants'])) : ?>
                                    <p class="text-sm text-white font-bold text-center bg-red-500 border-10 border-r w-full px-3 py-2 border border-gray-300 rounded-md mb-2 "> <?= $_SESSION['erreurs']['identifiants'] ?> </p>
                                <?php endif ?>
                            <label class="block text-sm font-medium text-gray-700 mb-2 ">
                                Login
                            </label>
                            <input 
                                type="text" 
                                name="login"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Entrez votre login"/>
                            <!-- affichage du message en dessous du login -->
                                <?php if(!empty($_SESSION['erreurs']['login'])) : ?>
                                    <p class="text-sm text-red-500 font-bold"> <?= $_SESSION['erreurs']['login'] ?> </p>
                                <?php endif ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe
                            </label>
                            <input 
                                type="password" 
                                name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Entrez votre mot de passe"/>
                            <!-- affichage du message en dessous du password -->
                                <?php if(!empty($_SESSION['erreurs']['password'])) : ?>
                                    <p class="text-sm text-red-500 font-bold"> <?= $_SESSION['erreurs']['password'] ?> </p>
                                <?php endif ?>
                        </div>
                        
                        <button 
                            type="submit"
                            class="w-full bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 font-medium transition-colors">Connexion
                        </button>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Vous n'avez pas de compte ? 
                            <a href="/inscription" class="text-orange-500 hover:text-orange-600 font-medium">
                                Créer un compte
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>