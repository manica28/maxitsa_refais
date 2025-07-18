<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée | MAXITSA</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 25%, #f97316 50%, #ea580c 75%, #000000 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .pulse-orange {
            animation: pulseOrange 2s ease-in-out infinite;
        }
        
        @keyframes pulseOrange {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(249, 115, 22, 0); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }
        
        .text-glow {
            text-shadow: 0 0 20px rgba(249, 115, 22, 0.8);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 404 Number -->
        <div class="float-animation mb-8">
            <h1 class="text-9xl md:text-[12rem] font-black text-white text-glow mb-4">
                404
            </h1>
        </div>
        
        <!-- Content Card -->
        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 md:p-12 border border-orange-500 border-opacity-30">
            <div class="space-y-6">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 bg-orange-500 rounded-full flex items-center justify-center pulse-orange">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.034 0-3.9.785-5.291 2.09M6.343 6.343L17.657 17.657M6.343 17.657L17.657 6.343"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Title -->
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Oops ! Page non trouvée
                </h2>
                
                <!-- Description -->
                <p class="text-lg md:text-xl text-gray-200 mb-8 leading-relaxed">
                    La page que vous recherchez semble avoir disparu dans les méandres du web. 
                    <br class="hidden md:block">
                    Ne vous inquiétez pas, nous allons vous remettre sur la bonne voie !
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="/" class="group relative inline-flex items-center px-8 py-4 bg-orange-500 text-white font-semibold rounded-lg shadow-lg hover:bg-orange-600 transform hover:scale-105 transition-all duration-300 ease-in-out">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour à l'accueil
                    </a>
                    
                    <button onclick="history.back()" class="group relative inline-flex items-center px-8 py-4 bg-transparent border-2 border-orange-500 text-orange-500 font-semibold rounded-lg hover:bg-orange-500 hover:text-white transform hover:scale-105 transition-all duration-300 ease-in-out">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                        </svg>
                        Page précédente
                    </button>
                </div>
                
                <!-- Brand -->
                <div class="mt-8 pt-6 border-t border-orange-500 border-opacity-30">
                    <p class="text-gray-300 text-sm">
                        Une erreur de 
                        <span class="text-orange-500 font-bold text-lg">MAXITSA</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-orange-500 rounded-full opacity-20 blur-xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-orange-600 rounded-full opacity-10 blur-2xl"></div>
        <div class="absolute top-1/3 right-1/4 w-16 h-16 bg-white rounded-full opacity-5 blur-lg"></div>
    </div>
</body>
</html>