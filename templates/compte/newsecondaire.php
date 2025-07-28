<?php 
// Debug - voir ce qui est disponible
var_dump($secondaires);
var_dump($principal);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXITSA - Gestion des comptes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            transform: translateX(400px);
            transition: all 0.3s ease;
        }
        .notification.show {
            transform: translateX(0);
        }
        .notification.success {
            background: #10b981;
        }
        .notification.error {
            background: #ef4444;
        }
        .loading {
            display: none;
            align-items: center;
            gap: 10px;
        }
        .loading.show {
            display: flex;
        }
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #ea580c, #dc2626);
        }
        
        * {
            scrollbar-width: thin;
            scrollbar-color: #f97316 rgba(255, 255, 255, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .nouveau-compte {
            border: 3px solid #10b981;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { box-shadow: 0 0 5px #10b981; }
            to { box-shadow: 0 0 20px #10b981, 0 0 30px #10b981; }
        }

        .compte-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .compte-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="font-sans">
    <div class="bg-white bg-opacity-10 border-l border-orange-500 border-opacity-90">
        <div class="h-screen py-2 md:px-12 lg:px-48">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-white mb-4">MAXITSA</h1>
                <p class="text-xl text-white opacity-90">Gestion des comptes</p>
            </div>

            <!-- Notifications -->
            <div id="notification" class="notification"></div>

            <!-- Success/Error Messages -->
            <?php if (isset($success) && !empty($success)): ?>
                <div class="max-w-[1500px] mx-auto mb-6">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl" role="alert">
                        <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="max-w-[1500px] mx-auto mb-6">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <div class="block"><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Add Account Form -->
            <div class="max-w-[1500px] mx-auto mb-12">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Ajouter un compte secondaire</h2>
                    
                    <form id="accountForm" action="createCompteSecondaire" method="POST">
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-medium mb-2">
                                Numéro de téléphone *
                            </label>
                            <input type="tel" 
                                   class="w-full text-black px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="+221 XX XXX XX XX"
                                   id="phoneNumber"
                                   name="telephone"
                                   required>
                            <div id="phoneValidation" class="text-sm mt-2 hidden"></div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-medium mb-2">
                                Solde initial (optionnel)
                            </label>
                            <input type="number" 
                                   class="w-full px-4 py-3 border text-black border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Montant en CFA"
                                   id="initialBalance"
                                   name="solde"
                                   min="0"
                                   step="0.01">
                            <p class="text-gray-500 text-xs mt-2">Ce montant sera débité de votre compte principal</p>
                        </div>
                        
                        <div class="flex justify-center">
                            <button type="submit" 
                                    class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-6 rounded-xl transition duration-200 disabled:opacity-50"
                                    id="submitButton">
                                <span id="submitText">Créer le compte</span>
                                <div class="loading" id="submitLoading">
                                    <div class="spinner"></div>
                                    <span>Création...</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing Secondary Accounts -->
            <div class="max-w-[1500px] mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8 fade-in">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Vos comptes</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="accountsGrid">
                        <!-- Compte Principal -->
                        <?php if (isset($comptes) && !empty($comptes)): ?>
                        <div class="bg-gradient-to-br from-gray-900 to-black text-white rounded-2xl p-6 shadow-xl relative compte-card">
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-medium">Principal</span>
                            </div>
                            <div class="mb-6">
                                <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($comptes['telephone']) ?></h3>
                                <p class="text-2xl font-bold text-white"><?= number_format($comptes['solde'], 0, ',', ' ') ?> CFA</p>
                            </div>
                            <div class="space-y-3">
                               <a href="/transactions" class="block"> 
                                   <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                        Consulter transactions
                                    </button>
                               </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Affichage du nouveau compte créé -->
                        <?php if (isset($nouveauCompte) && !empty($nouveauCompte)): ?>
                            <div class="bg-gradient-to-br from-green-800 to-green-900 text-white rounded-2xl p-6 shadow-xl relative compte-card nouveau-compte">
                                <div class="absolute top-4 right-4">
                                    <span class="bg-green-400 text-white text-xs px-3 py-1 rounded-full font-medium">Nouveau!</span>
                                </div>
                                <div class="mb-6">
                                    <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($nouveauCompte['telephone']) ?></h3>
                                    <p class="text-sm text-green-200 mb-1">N° : <?= htmlspecialchars($nouveauCompte['numero']) ?></p>
                                    <p class="text-2xl font-bold text-white"><?= number_format(floatval($nouveauCompte['solde']), 0, ',', ' ') ?> CFA</p>
                                </div>
                                <div class="space-y-3">
                                    <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200"
                                            onclick="definirCommePrincipal('<?= $nouveauCompte['numero'] ?>')">
                                        Définir comme principal
                                    </button>
                                    <a href="/transactions?compte=<?= $nouveauCompte['numero'] ?>" class="block">
                                        <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                            Consulter transactions
                                        </button>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Comptes secondaires existants -->
                        <?php if (isset($secondaires) && !empty($secondaires)): ?>
                            <?php foreach ($secondaires as $compte): ?>
                                <div class="bg-gradient-to-br from-blue-800 to-purple-900 text-white rounded-2xl p-6 shadow-xl relative compte-card">
                                    <div class="absolute top-4 right-4">
                                        <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-medium">Secondaire</span>
                                    </div>
                                    <div class="mb-6">
                                        <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($compte['telephone']) ?></h3>
                                        <p class="text-sm text-gray-300 mb-1">N° : <?= htmlspecialchars($compte['numerocompte']) ?></p>
                                        <p class="text-2xl font-bold text-white"><?= number_format($compte['solde'], 0, ',', ' ') ?> CFA</p>
                                        <?php if (isset($compte['datecreation'])): ?>
                                            <p class="text-xs text-gray-400 mt-1">
                                                Créé le <?= date('d/m/Y', strtotime($compte['datecreation'])) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="space-y-3">
                                        <button class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200"
                                                onclick="definirCommePrincipal('<?= $compte['numerocompte'] ?>')">
                                            Définir comme principal
                                        </button>
                                        <a href="/transactions?compte=<?= $compte['numerocompte'] ?>" class="block">
                                            <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                                Consulter transactions
                                            </button>
                                        </a>
                                        <button class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-xl transition duration-200 text-sm"
                                                onclick="supprimerCompte('<?= $compte['numerocompte'] ?>', '<?= $compte['telephone'] ?>')">
                                            Supprimer compte
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun compte secondaire -->
                            <div class="col-span-full text-center py-8">
                                <div class="bg-gray-100 rounded-2xl p-8">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <h4 class="text-xl font-semibold text-gray-600 mb-2">Aucun compte secondaire</h4>
                                    <p class="text-gray-500">Créez votre premier compte secondaire en utilisant le formulaire ci-dessus</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('accountForm').addEventListener('submit', function(e) 
        {
            const submitButton = document.getElementById('submitButton');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');
            
            submitButton.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.add('show');
        });

        // Validation du numéro de téléphone
        document.getElementById('phoneNumber').addEventListener('input', function(e) {
            const phone = e.target.value;
            const validation = document.getElementById('phoneValidation');
            
            if (phone.length === 0) {
                validation.classList.add('hidden');
                return;
            }
            
            // Validation simple pour numéro sénégalais
            const phoneRegex = /^(\+221|221)?[0-9]{9}$/;
            
            if (phoneRegex.test(phone.replace(/\s/g, ''))) {
                validation.textContent = '✓ Numéro valide';
                validation.className = 'text-sm mt-2 text-green-600';
                validation.classList.remove('hidden');
            } else {
                validation.textContent = '✗ Format invalide (ex: +221 XX XXX XX XX)';
                validation.className = 'text-sm mt-2 text-red-600';
                validation.classList.remove('hidden');
            }
        });

        // Fonction pour définir un compte comme principal
        function definirCommePrincipal(numeroCompte) {
            if (confirm('Êtes-vous sûr de vouloir définir ce compte comme principal ?')) {
                // Redirection vers l'action de définition du compte principal
                window.location.href = `/definir-principal?compte=${numeroCompte}`;
            }
        }

        // Fonction pour supprimer un compte
        function supprimerCompte(numeroCompte, telephone) {
            if (confirm(`Êtes-vous sûr de vouloir supprimer le compte ${telephone} ?`)) {
                // Redirection vers l'action de suppression
                window.location.href = `/supprimer-compte?compte=${numeroCompte}`;
            }
        }

        // Afficher les notifications s'il y en a
        <?php if (isset($success) && !empty($success)): ?>
            showNotification('<?= addslashes($success) ?>', 'success');
        <?php endif; ?>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            showNotification('<?= addslashes(implode(' ', $errors)) ?>', 'error');
        <?php endif; ?>

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }

        // Animation pour les nouveaux comptes
        document.addEventListener('DOMContentLoaded', function() {
            const nouveauxComptes = document.querySelectorAll('.nouveau-compte');
            nouveauxComptes.forEach(compte => {
                setTimeout(() => {
                    compte.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 1000);
            });
        });
    </script>
</body>
</html>