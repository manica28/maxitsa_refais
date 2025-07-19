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
                        <!-- Compte Principal (exemple) -->
                        <div class="bg-black text-white rounded-2xl p-6 shadow-xl relative">
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-medium">Principal</span>
                            </div>
                            <div class="mb-6">
                                <h3 class="text-xl font-bold mb-2">+221 77 6675550</h3>
                                <p class="text-2xl font-bold text-white">250 000 CFA</p>
                            </div>
                            <div class="space-y-3">
                                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                    Consulter transactions
                                </button>
                            </div>
                        </div>

                        <!-- Comptes Secondaires -->
                        <?php if (isset($comptesSecondaires) && !empty($comptesSecondaires)): ?>
                            <?php foreach ($comptesSecondaires as $compte): ?>
                                <div class="bg-black text-white rounded-2xl p-6 shadow-xl">
                                    <div class="mb-6">
                                        <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($compte['telephone']) ?></h3>
                                        <p class="text-2xl font-bold text-white"><?= number_format($compte['solde'], 0, ',', ' ') ?> CFA</p>
                                    </div>
                                    <div class="space-y-3">
                                        <button class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                            Définir comme principal
                                        </button>
                                        <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                            Consulter transactions
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Exemple de compte secondaire statique -->
                        <div class="bg-black text-white rounded-2xl p-6 shadow-xl">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold mb-2">+221 77 4093057</h3>
                                <p class="text-2xl font-bold text-white">10 000 CFA</p>
                            </div>
                            <div class="space-y-3">
                                <button class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                    Définir comme principal
                                </button>
                                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                                    Consulter transactions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('accountForm').addEventListener('submit', function(e) {
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
    </script>
</body>
</html>