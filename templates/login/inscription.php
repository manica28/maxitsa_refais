<?php var_dump($_SESSION['errors']) ?>
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
    <div id="register" class="h-screen flex justify-center items-center px-4 py-4">
        <div class="scroll-container bg-white shadow-2xl border-2 border-orange-500 rounded-2xl p-6 w-full max-w-4xl h-full flex flex-col overflow-y-auto">
            <div class="text-center mb-6 flex-shrink-0">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">MAXITSA</h1>
                <p class="text-gray-700 mt-1 text-base">Créer votre compte principal</p>
                <div class="w-20 h-1 bg-orange-gradient mx-auto mt-2 rounded-full"></div>
            </div>

            <form id="registerForm" class="space-y-4 flex-1" action="createCompte" method="POST" enctype="multipart/form-data">
                  <div>
                    <label for="idNumber" class="block text-sm font-semibold text-black mb-1">Numéro de carte d'identité *</label>
                       <div class="relative">
                                    <input type="text" 
                                           name="numeroCNI" 
                                           id="idNumber"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                           placeholder="Entrez le numéro CNI à rechercher">
                                    <div id="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2 loading hidden"></div>
                                </div>
                                
                                <button type="button" 
                                        id="searchBtn"
                                        class="mt-2 w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                     Recherche du CNI
                                </button>
                                
                                <div id="cni-error" class="flex items-center mt-2 bg-red-400 justify-center px-3 py-2 rounded-md hidden">
                                    <p class="text-xs text-white">CNI non trouvée dans la base de données</p>
                                </div>
                                
                                <div id="cni-success" class="flex items-center mt-2 bg-green-400 justify-center px-3 py-2 rounded-md hidden">
                                    <p class="text-xs text-white">Citoyen trouvé ! Informations pré-remplies.</p>
                                </div>
                                
                                <?php if(!empty($_SESSION['errors']['numeroCNI'])): ?>
                                    <div class="flex items-center mt-1 bg-red-400 justify-center px-3 py-2 rounded-md">
                                        <p class="text-xs text-white"><?= $_SESSION['errors']['numeroCNI']; ?></p>
                                    </div>
                                <?php endif; ?>
                    </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block text-sm font-semibold text-black mb-1">Prénom *</label>
                        <input type="text" id="firstName" name="prenom"  placeholder="Votre prénom"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                             <?php if(!empty($_SESSION['errors']['prenom'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['prenom'] ?> </p>
                            <?php endif ?>
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-semibold text-black mb-1">Nom *</label>
                        <input type="text" id="lastName" name="nom"  placeholder="Votre nom"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                             <?php if(!empty($_SESSION['errors']['nom'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['nom'] ?> </p>
                             <?php endif ?>
                    </div>
                </div>
                    
                <div>
                        <label for="login" class="block text-sm font-semibold text-black mb-1">Login *</label>
                        <input type="text" id="login" name="login"  placeholder="Votre login"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                             <?php if(!empty($_SESSION['errors']['login'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['login'] ?> </p>
                                <?php endif ?>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-black mb-1">Numéro de téléphone *</label>
                    <input type="tel" id="phone" name="telephone"  placeholder="+221 XX XXX XX XX"
                        class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                         <?php if(!empty($_SESSION['errors']['telephone'])) : ?>
                                <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['telephone'] ?> </p>
                        <?php endif ?>
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-black mb-1">Adresse *</label>
                    <textarea id="address" name="adresse"  rows="2" placeholder="Votre adresse complète"
                        class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300 resize-none"></textarea>
                         <?php if(!empty($_SESSION['errors']['adresse'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['adresse'] ?> </p>
                             <?php endif ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="idFront" class="block text-sm font-semibold text-black mb-1">Photo CNI (Recto) *</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="idFront"
                                class="w-full flex flex-col items-center px-3 py-3 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-700 rounded-lg border-2 border-orange-300 cursor-pointer hover:from-orange-100 hover:to-orange-200 transition duration-300">
                                <svg class="w-5 h-5 mb-1 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16l4 4m0 0l4-4m-4 4V4" />
                                </svg>
                                <span class="text-xs font-medium">Photo recto</span>
                                <input type="file" id="idFront" name="photoRecto" accept="image/*" class="hidden" />
                            </label>
                        </div>
                         <?php if(!empty($_SESSION['errors']['photoRecto'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['photoRecto'] ?> </p>
                             <?php endif ?>
                    </div>

                    <div>
                        <label for="idBack" class="block text-sm font-semibold text-black mb-1">Photo CNI (Verso) *</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="idBack"
                                class="w-full flex flex-col items-center px-3 py-3 bg-gradient-to-br from-orange-50 to-orange-100 text-orange-700 rounded-lg border-2 border-orange-300 cursor-pointer hover:from-orange-100 hover:to-orange-200 transition duration-300">
                                <svg class="w-5 h-5 mb-1 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16l4 4m0 0l4-4m-4 4V4" />
                                </svg>
                                <span class="text-xs font-medium">Photo verso</span>
                                <input type="file" id="idBack" name="photoVerso" accept="image/*" class="hidden"/>
                            </label>
                        </div>
                         <?php if(!empty($_SESSION['errors']['photoVerso'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['photoVerso'] ?> </p>
                             <?php endif ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-black mb-1">Mot de passe *</label>
                        <input type="password" id="password" name="password"  placeholder="Choisissez un mot de passe"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                             <?php if(!empty($_SESSION['errors']['password'])) : ?>
                                    <p class="text-xs text-red-500 font-bold"> <?= $_SESSION['errors']['password'] ?> </p>
                             <?php endif ?>
                    </div>
                    <div>
                        <label for="confirmPassword" class="block text-sm font-semibold text-black mb-1">Confirmer le mot de passe *</label>
                        <input type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirmez votre mot de passe"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                    </div>
                </div>

                <div class="pt-4">
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

    <script>
    document.getElementById('searchBtn').addEventListener('click', function () {
    const cni = document.getElementById('numeroCNI').value.trim();

    document.getElementById('cni-error').classList.add('hidden');
    document.getElementById('cni-success').classList.add('hidden');

    if (cni !== '') {
        fetch(`https://appdafapi.onrender.com/api/citoyens/${cni}`)
            .then(response => {
                if (!response.ok) throw new Error("CNI non trouvée");
                return response.json();
            })
            .then(data => {
                if (data && data.data) {
                    const citoyen = data.data;

                    document.getElementById('prenom').value = citoyen.prenom || '';
                    document.getElementById('nom').value = citoyen.nom || '';
                    document.getElementById('adresse').value = citoyen.adresse || '';
                    document.getElementById('telephone').value = citoyen.telephone || '';

                    document.getElementById('cni-success').classList.remove('hidden');
                } else {
                    document.getElementById('cni-error').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error("Erreur :", error);
                document.getElementById('cni-error').classList.remove('hidden');
            });
    }
});
</script>


</body>
</html>