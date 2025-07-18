<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Supprime la scrollbar */
        body 
        {
            overflow: hidden;
        }
        
        /* Scrollbar personnalisée pour le contenu interne */
        .scroll-container::-webkit-scrollbar 
        {
            width: 0px;
            background: transparent;
        }
        
        /* Gradient orange personnalisé */
        .bg-orange-gradient 
        {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        }
        
        /* Focus orange personnalisé */
        .focus-orange:focus 
        {
            outline: none;
            ring: 2px;
            ring-color: #ff6b35;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div id="register" class="h-screen flex justify-center items-center px-4 py-4 overflow-hidden">
        <div class="scroll-container bg-white shadow-2xl border-2 border-orange-500 rounded-2xl p-6 w-full max-w-4xl h-full flex flex-col">
            <div class="text-center mb-4 flex-shrink-0">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">MAXITSA</h1>
                <p class="text-gray-700 mt-1 text-base">Créer votre compte principal</p>
                <div class="w-20 h-1 bg-orange-gradient mx-auto mt-2 rounded-full"></div>
            </div>

            <form id="registerForm" class="space-y-4 flex-1 flex flex-col" action="store" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block text-sm font-semibold text-black mb-1">Prénom *</label>
                        <input type="text" id="firstName" name="firstName"  placeholder="Votre prénom"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-semibold text-black mb-1">Nom *</label>
                        <input type="text" id="lastName" name="lastName"  placeholder="Votre nom"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-black mb-1">Numéro de téléphone *</label>
                    <input type="tel" id="phone" name="phone"  placeholder="+221 XX XXX XX XX"
                        class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                </div>

                <div>
                    <label for="idNumber" class="block text-sm font-semibold text-black mb-1">Numéro de carte d'identité *</label>
                    <input type="text" id="idNumber" name="idNumber"  placeholder="Numéro de CNI"
                        class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-black mb-1">Adresse *</label>
                    <textarea id="address" name="address"  rows="2" placeholder="Votre adresse complète"
                        class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300 resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="idFront" class="block text-sm font-semibold text-black mb-1">Photo CNI (Recto) *</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="idFront"
                                class="w-full flex flex-col items-center px-3 py-4 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-700 rounded-lg border-2 border-orange-300 cursor-pointer hover:from-orange-100 hover:to-orange-200 transition duration-300">
                                <svg class="w-6 h-6 mb-1 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16l4 4m0 0l4-4m-4 4V4" />
                                </svg>
                                <span class="text-xs font-medium">Photo recto</span>
                                <input type="file" id="idFront" name="idFront" accept="image/*" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="idBack" class="block text-sm font-semibold text-black mb-1">Photo CNI (Verso) *</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="idBack"
                                class="w-full flex flex-col items-center px-3 py-4 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-700 rounded-lg border-2 border-orange-300 cursor-pointer hover:from-orange-100 hover:to-orange-200 transition duration-300">
                                <svg class="w-6 h-6 mb-1 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16l4 4m0 0l4-4m-4 4V4" />
                                </svg>
                                <span class="text-xs font-medium">Photo verso</span>
                                <input type="file" id="idBack" name="idBack" accept="image/*" class="hidden"/>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-black mb-1">Mot de passe *</label>
                        <input type="password" id="password" name="password"  placeholder="Choisissez un mot de passe"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                    </div>
                    <div>
                        <label for="confirmPassword" class="block text-sm font-semibold text-black mb-1">Confirmer le mot de passe *</label>
                        <input type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirmez votre mot de passe"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                    </div>
                </div>

                <div class="flex-1 flex flex-col justify-end">
                    <button type="submit"
                        class="w-full bg-orange-gradient text-white font-bold py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-300 text-base">
                        Créer mon compte
                    </button>

                    <div class="text-center mt-3">
                        <a href="/" class="text-sm text-gray-600 hover:text-orange-600 transition duration-300 font-medium">J'ai déjà un compte</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>