<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXITSA - Achat Code Woyofal</title>
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

        /* Animation de chargement */
        .loading {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #ff6b35;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div id="register" class="h-screen flex justify-center items-center px-4 py-4">
        <div class="scroll-container w-[2500px] bg-white shadow-2xl border-2 border-orange-500 rounded-2xl p-6 w-full max-w-4xl h-full flex flex-col overflow-y-auto">
            <div class="text-center mb-6 flex-shrink-0">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">MAXITSA</h1>
                <p class="text-gray-700 mt-1 text-base">Achat de code Woyofal depuis votre compte principal</p>
                <div class="w-20 h-1 bg-orange-gradient mx-auto mt-2 rounded-full"></div>
            </div>

            <form id="woyofalForm" class="space-y-4 flex-1" action="acheterWoyofal" method="POST">
                
                <!-- Section Numéro de Compteur -->
                <div>
                    <label for="numeroCompteur" class="block text-sm font-semibold text-black mb-1">Numéro de Compteur Woyofal *</label>
                    <div class="relative">
                        <input type="text" 
                               name="numeroCompteur" 
                               id="numeroCompteur"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               placeholder="Ex: CPT001234567">
                        <div id="compteurLoading" class="absolute right-3 top-1/2 transform -translate-y-1/2 loading hidden"></div>
                    </div>
                    
                    <button type="button" 
                            id="verifyCompteurBtn"
                            class="mt-2 w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors text-sm">
                        🔍 Vérifier le Compteur Woyofal
                    </button>
                    
                    <div id="compteur-error" class="flex items-center mt-2 bg-red-400 justify-center px-3 py-2 rounded-md hidden">
                        <p class="text-xs text-white">⚠️ Numéro de compteur non trouvé dans le système Woyofal</p>
                    </div>
                    
                    <div id="compteur-success" class="flex items-center mt-2 bg-green-400 justify-center px-3 py-2 rounded-md hidden">
                        <p class="text-xs text-white">✅ Compteur valide ! Informations client récupérées.</p>
                    </div>
                    
                    <?php if(!empty($_SESSION['errors']['numeroCompteur'])): ?>
                        <div class="flex items-center mt-1 bg-red-400 justify-center px-3 py-2 rounded-md">
                            <p class="text-xs text-white"><?= $_SESSION['errors']['numeroCompteur']; ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Informations Client Récupérées -->
                <div id="clientInfo" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h3 class="text-sm font-semibold text-blue-800 mb-2">📋 Informations du Client Senelec</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <span class="text-xs font-medium text-blue-600">Nom du client:</span>
                            <p id="clientNom" class="text-sm font-bold text-blue-800"></p>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-blue-600">Numéro compteur:</span>
                            <p id="clientCompteur" class="text-sm font-bold text-blue-800"></p>
                        </div>
                    </div>
                </div>

                <!-- Montant à acheter -->
                <div>
                    <label for="montant" class="block text-sm font-semibold text-black mb-1">Montant à acheter (FCFA) *</label>
                    <input type="number" 
                           id="montant" 
                           name="montant" 
                           min="1"
                           placeholder="Ex: 5000"
                           class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                    
                    <!-- Aperçu des tranches -->
                  
                    
                    <?php if(!empty($_SESSION['errors']['montant'])): ?>
                        <p class="text-xs text-red-500 font-bold"><?= $_SESSION['errors']['montant']; ?></p>
                    <?php endif ?>
                </div>

                <!-- Vérification du solde -->
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <h3 class="text-sm font-semibold text-yellow-800 mb-2">💰 Vérification du Solde</h3>
                    <p class="text-xs text-yellow-700">Le montant sera débité de votre compte principal MAXITSA après vérification de la disponibilité.</p>
                    
                    <div id="soldeInfo" class="mt-2 hidden">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-medium text-yellow-600">Solde disponible:</span>
                            <span id="soldeDisponible" class="text-sm font-bold text-yellow-800">0 FCFA</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs font-medium text-yellow-600">Montant à débiter:</span>
                            <span id="montantDebiter" class="text-sm font-bold text-red-600">0 FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Informations de facturation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nomClient" class="block text-sm font-semibold text-black mb-1">Nom du titulaire du compte *</label>
                        <input type="text" id="nomClient" name="nomClient" placeholder="Votre nom complet"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                        <?php if(!empty($_SESSION['errors']['nomClient'])): ?>
                            <p class="text-xs text-red-500 font-bold"><?= $_SESSION['errors']['nomClient']; ?></p>
                        <?php endif ?>
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-semibold text-black mb-1">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" placeholder="+221 XX XXX XX XX"
                            class="w-full p-2 border-2 border-gray-300 rounded-lg focus-orange hover:border-orange-300 transition duration-300">
                        <?php if(!empty($_SESSION['errors']['telephone'])): ?>
                            <p class="text-xs text-red-500 font-bold"><?= $_SESSION['errors']['telephone']; ?></p>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Conditions d'achat -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">📜 Conditions d'achat</h3>
                    <div class="space-y-1 text-xs text-gray-600">
                        <p>• Le code de recharge sera généré instantanément après paiement</p>
                        <p>• Un reçu détaillé sera fourni avec toutes les informations</p>
                        <p>• Le montant sera débité de votre compte principal MAXITSA</p>
                        <p>• Les tranches tarifaires se remettent à zéro chaque 1er du mois</p>
                    </div>
                    
                    <div class="flex items-center mt-3">
                        <input type="checkbox" id="acceptConditions" name="acceptConditions" required
                               class="mr-2 text-orange-500 focus:ring-orange-400">
                        <label for="acceptConditions" class="text-xs text-gray-700">
                            J'accepte les conditions d'achat et confirme la transaction
                        </label>
                    </div>
                </div>

                <!-- Bouton d'achat -->
                <div class="pt-4">
                    <button type="submit" id="submitBtn" disabled
                        class="w-full bg-gray-400 text-white font-bold py-3 rounded-lg transition duration-300 text-base cursor-not-allowed">
                        🔒 Vérifiez d'abord le compteur
                    </button>

                    <div class="text-center mt-3">
                        <a href="/home" class="text-sm text-gray-600 hover:text-orange-600 transition duration-300 font-medium">← Retour au tableau de bord</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // URL de l'API AppWoyofal déployée
        const APPWOYOFAL_API_URL = 'https://votre-appwoyofal-deploy.onrender.com'; // Remplacez par l'URL réelle
        
        let compteurValide = false;
        let clientData = null;

        // Fonction pour vérifier le compteur
        document.getElementById('verifyCompteurBtn').addEventListener('click', async function () {
            const numeroCompteur = document.getElementById('numeroCompteur').value.trim();
            const loading = document.getElementById('compteurLoading');
            const errorDiv = document.getElementById('compteur-error');
            const successDiv = document.getElementById('compteur-success');
            const clientInfo = document.getElementById('clientInfo');
            const submitBtn = document.getElementById('submitBtn');

            // Reset des messages
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            clientInfo.classList.add('hidden');

            if (!numeroCompteur) {
                errorDiv.querySelector('p').textContent = '⚠️ Veuillez saisir un numéro de compteur';
                errorDiv.classList.remove('hidden');
                return;
            }

            // Afficher le loading
            loading.classList.remove('hidden');
            this.disabled = true;
            this.textContent = '🔄 Vérification en cours...';

            try {
                const response = await fetch(`${APPWOYOFAL_API_URL}/api/verifier-compteur`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        numeroCompteur: numeroCompteur
                    })
                });

                const result = await response.json();

                if (result.statut === 'success' && result.data) {
                    // Compteur trouvé
                    compteurValide = true;
                    clientData = result.data;
                    
                    // Afficher les informations du client
                    document.getElementById('clientNom').textContent = result.data.client || 'Client Senelec';
                    document.getElementById('clientCompteur').textContent = numeroCompteur;
                    
                    successDiv.classList.remove('hidden');
                    clientInfo.classList.remove('hidden');
                    
                    // Activer le bouton d'achat
                    submitBtn.disabled = false;
                    submitBtn.className = 'w-full bg-orange-gradient text-white font-bold py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-300 text-base';
                    submitBtn.textContent = '💡 Acheter le Code Woyofal';
                    
                } else {
                    // Compteur non trouvé
                    compteurValide = false;
                    clientData = null;
                    
                    errorDiv.querySelector('p').textContent = result.message || '⚠️ Numéro de compteur non trouvé dans le système Woyofal';
                    errorDiv.classList.remove('hidden');
                    
                    // Désactiver le bouton d'achat
                    submitBtn.disabled = true;
                    submitBtn.className = 'w-full bg-gray-400 text-white font-bold py-3 rounded-lg transition duration-300 text-base cursor-not-allowed';
                    submitBtn.textContent = '🔒 Compteur non valide';
                }

            } catch (error) {
                console.error('Erreur lors de la vérification:', error);
                compteurValide = false;
                clientData = null;
                
                errorDiv.querySelector('p').textContent = '🔌 Erreur de connexion à AppWoyofal. Vérifiez votre connexion.';
                errorDiv.classList.remove('hidden');
                
                // Désactiver le bouton d'achat
                submitBtn.disabled = true;
                submitBtn.className = 'w-full bg-gray-400 text-white font-bold py-3 rounded-lg transition duration-300 text-base cursor-not-allowed';
                submitBtn.textContent = '🔒 Erreur de connexion';
            }

            // Masquer le loading et restaurer le bouton
            loading.classList.add('hidden');
            this.disabled = false;
            this.textContent = '🔍 Vérifier le Compteur Woyofal';
        });

        // Simulation du calcul du montant à débiter
        document.getElementById('montant').addEventListener('input', function() {
            const montant = parseFloat(this.value) || 0;
            const soldeInfo = document.getElementById('soldeInfo');
            const montantDebiter = document.getElementById('montantDebiter');
            
            if (montant > 0) {
                montantDebiter.textContent = `${montant.toLocaleString()} FCFA`;
                soldeInfo.classList.remove('hidden');
            } else {
                soldeInfo.classList.add('hidden');
            }
        });

        // Validation du formulaire avant soumission
        document.getElementById('woyofalForm').addEventListener('submit', function(e) {
            if (!compteurValide) {
                e.preventDefault();
                alert('⚠️ Veuillez d\'abord vérifier le numéro de compteur Woyofal');
                return false;
            }

            const montant = parseFloat(document.getElementById('montant').value);
            if (!montant || montant <= 0) {
                e.preventDefault();
                alert('⚠️ Veuillez saisir un montant valide');
                return false;
            }

            const acceptConditions = document.getElementById('acceptConditions').checked;
            if (!acceptConditions) {
                e.preventDefault();
                alert('⚠️ Veuillez accepter les conditions d\'achat');
                return false;
            }

            // Confirmation finale
            const confirmation = confirm(`Confirmer l'achat de ${montant.toLocaleString()} FCFA de crédit Woyofal pour le compteur ${document.getElementById('numeroCompteur').value} ?`);
            if (!confirmation) {
                e.preventDefault();
                return false;
            }

            return true;
        });

        // Auto-focus sur le champ compteur
        document.getElementById('numeroCompteur').focus();
    </script>
</body>
</html>