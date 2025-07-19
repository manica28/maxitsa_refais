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
        
        /* Custom scrollbar styles */
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
        
        /* Firefox scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: #f97316 rgba(255, 255, 255, 0.1);
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
                                   >
                            <div id="phoneValidation" class="text-sm mt-2 hidden"></div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-medium mb-2">
                                Solde initial (optionnel)
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border text-black border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Montant en CFA"
                                   id="initialBalance",
                                   name="solde"
                                   >
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

            <!-- Accounts Grid -->
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="accountsGrid">
                    <!-- Compte Principal -->
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

                    <!-- Compte Secondaire 1 -->
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

                    <!-- Compte Secondaire 2 -->
                    <div class="bg-black text-white rounded-2xl p-6 shadow-xl">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold mb-2">+221 77 2677777</h3>
                            <p class="text-2xl font-bold text-white">15 000 CFA</p>
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


    <script>
        // Fonction pour afficher les notifications
    
        // Gestion du formulaire
        document.getElementById('accountForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('submitButton');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');
            
            // Afficher le loading
            submitText.style.display = 'none';
            submitLoading.classList.add('show');
            submitButton.disabled = true;
            
            // Simuler une création de compte
            setTimeout(() => {
                // Masquer le loading
                submitText.style.display = 'inline';
                submitLoading.classList.remove('show');
                submitButton.disabled = false;
                
                // Afficher la notification de succès
                // showNotification('Compte créé avec succès !', 'success');
                
                // Réinitialiser le formulaire
                this.reset();
            }, 2000);
        });

        // Gestion des boutons des cartes
        document.addEventListener('click', function(e) {
            if (e.target.textContent === 'Définir comme principal') {
                // showNotification('Compte défini comme principal', 'success');
            } else if (e.target.textContent === 'Consulter transactions') {
                document.getElementById('transactionModal').classList.remove('hidden');
            }
        });

        // Fermer le modal
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('transactionModal').classList.add('hidden');
        });

        // Fermer le modal en cliquant à l'extérieur
        document.getElementById('transactionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

    <script>
        // Variables globales
        let accounts = [];
        let isLoading = false;

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            loadAccounts();
            setupEventListeners();
        });

        // Configuration des écouteurs d'événements
        function setupEventListeners() {
            // Validation du téléphone en temps réel
            document.getElementById('phoneNumber').addEventListener('input', function(e) {
                formatPhoneNumber(e);
                validatePhoneNumber(e.target.value);
            });

            // Soumission du formulaire
            document.getElementById('accountForm').addEventListener('submit', handleFormSubmit);

            // Fermeture du modal
            document.getElementById('closeModal').addEventListener('click', closeTransactionModal);
            document.getElementById('transactionModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTransactionModal();
                }
            });
        }

        // Formater le numéro de téléphone
        function formatPhoneNumber(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.startsWith('221')) {
                value = value.substring(3);
            }
            
            if (value.length > 0) {
                if (value.length <= 2) {
                    value = '+221 ' + value;
                } else if (value.length <= 5) {
                    value = '+221 ' + value.substring(0, 2) + ' ' + value.substring(2);
                } else if (value.length <= 8) {
                    value = '+221 ' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5);
                } else {
                    value = '+221 ' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5, 7) + ' ' + value.substring(7, 9);
                }
            }
            
            e.target.value = value;
        }

        // Fonction améliorée pour extraire le numéro sans formatage
        function extractPhoneNumber(formattedPhone) {
            // Extraire seulement les chiffres
            const digits = formattedPhone.replace(/\D/g, '');
            
            // Si commence par 221, garder tel quel, sinon ajouter 221
            if (digits.startsWith('221')) {
                return digits;
            } else {
                return '221' + digits;
            }
        }

        // Fonction de validation côté client améliorée
        function isValidSenegalPhone(phone) {
            const digits = phone.replace(/\D/g, '');
            
            // Vérifier si c'est un numéro sénégalais valide
            if (digits.length === 12 && digits.startsWith('221')) {
                const localNumber = digits.substring(3); // Enlever 221
                
                // Vérifier les préfixes valides pour le Sénégal
                const validPrefixes = ['77', '78', '76', '70', '75', '33', '30'];
                const prefix = localNumber.substring(0, 2);
                
                return validPrefixes.includes(prefix) && localNumber.length === 9;
            }
            
            // Si c'est un numéro de 9 chiffres sans le code pays
            if (digits.length === 9) {
                const validPrefixes = ['77', '78', '76', '70', '75', '33', '30'];
                const prefix = digits.substring(0, 2);
                
                return validPrefixes.includes(prefix);
            }
            
            return false;
        }

        // Valider le numéro de téléphone
        async function validatePhoneNumber(phone) {
            const validationDiv = document.getElementById('phoneValidation');
            
            // Enlever les espaces et caractères non numériques pour la validation
            const cleanPhone = phone.replace(/\D/g, '');
            
            // Vérifier la longueur minimale
            if (cleanPhone.length < 9) {
                validationDiv.classList.add('hidden');
                return;
            }

            // Validation côté client d'abord
            if (!isValidSenegalPhone(phone)) {
                validationDiv.classList.remove('hidden');
                validationDiv.className = 'text-sm mt-2 text-red-600';
                validationDiv.textContent = '✗ Format de numéro invalide pour le Sénégal';
                return;
            }

            // Si la validation côté client passe, afficher comme valide
            validationDiv.classList.remove('hidden');
            validationDiv.className = 'text-sm mt-2 text-green-600';
            validationDiv.textContent = '✓ Numéro valide';

            // Optionnel : validation côté serveur
            try {
                const response = await fetch('/api/validate/telephone', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `telephone=${encodeURIComponent(phone)}`
                });

                const result = await response.json();
                
                if (result.valid) {
                    validationDiv.className = 'text-sm mt-2 text-green-600';
                    validationDiv.textContent = '✓ ' + result.message;
                } else {
                    validationDiv.className = 'text-sm mt-2 text-red-600';
                    validationDiv.textContent = '✗ ' + result.message;
                }
            } catch (error) {
                console.error('Erreur validation serveur:', error);
                // Garder la validation côté client si le serveur ne répond pas
            }
        }

        // Gérer la soumission du formulaire
        async function handleFormSubmit(e) {
            e.preventDefault();
            
            if (isLoading) return;
            
            const phoneNumber = document.getElementById('phoneNumber').value;
            const initialBalance = document.getElementById('initialBalance').value;
            
            if (!phoneNumber) {
                // showNotification('Le numéro de téléphone est requis', 'error');
                return;
            }

            // Validation finale avant soumission
            if (!isValidSenegalPhone(phoneNumber)) {
                // showNotification('Format de numéro invalide', 'error');
                return;
            }

            setLoading(true);
            
            try {
                const response = await fetch('/api/compte/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        telephone: extractPhoneNumber(phoneNumber), // Envoyer le numéro nettoyé
                        solde: initialBalance
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    // showNotification(result.message, 'success');
                    document.getElementById('accountForm').reset();
                    document.getElementById('phoneValidation').classList.add('hidden');
                    loadAccounts(); // Recharger les comptes
                } else {
                    // showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Erreur création compte:', error);
                // showNotification('Erreur lors de la création du compte', 'error');
            } finally {
                setLoading(false);
            }
        }

        // Charger les comptes
        async function loadAccounts() {
            try {
                const response = await fetch('/api/compte/list');
                const result = await response.json();
                
                if (result.success) {
                    accounts = result.data;
                    displayAccounts();
                } else {
                    // showNotification('Erreur lors du chargement des comptes', 'error');
                }
            } catch (error) {
                console.error('Erreur chargement comptes:', error);
                // showNotification('Erreur lors du chargement des comptes', 'error');
            }
        }

        // Afficher les comptes
        function displayAccounts() {
            const grid = document.getElementById('accountsGrid');
            grid.innerHTML = '';

            accounts.forEach(account => {
                const accountCard = createAccountCard(account);
                grid.appendChild(accountCard);
            });
        }

        // Créer une carte de compte
        function createAccountCard(account) {
            const card = document.createElement('div');
            const isPrincipal = account.est_principal;
            
            card.className = `${isPrincipal ? 'bg-black text-white' : 'bg-white'} rounded-2xl p-6 shadow-xl`;
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm ${isPrincipal ? 'opacity-90' : 'text-gray-700'}">${formatPhoneDisplay(account.telephone)}</p>
                        <p class="text-3xl font-bold mt-2 ${isPrincipal ? '' : 'text-gray-800'}">${formatAmount(account.solde)}</p>
                    </div>
                    ${isPrincipal ? 
                        '<span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Principal</span>' : 
                        ''
                    }
                </div>
                <div class="space-y-3">
                    ${!isPrincipal ? 
                        `<button onclick="setPrincipal(${account.id})" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                            Définir comme principal
                        </button>` : 
                        ''
                    }
                    <button onclick="showTransactions(${account.id})" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200">
                        Consulter les transactions
                    </button>
                </div>
            `;
            
            return card;
        }

        // Définir un compte comme principal
        async function setPrincipal(accountId) {
            try {
                const response = await fetch('/api/compte/principal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `compte_id=${accountId}`
                });

                const result = await response.json();
                
                if (result.success) {
                    // showNotification(result.message, 'success');
                    loadAccounts();
                } else {
                    // showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Erreur définition principal:', error);
                // showNotification('Erreur lors de la définition du compte principal', 'error');
            }
        }

        // Afficher les transactions
        async function showTransactions(accountId) {
            try {
                const response = await fetch(`/api/compte/transactions?compte_id=${accountId}`);
                const result = await response.json();
                
                if (result.success) {
                    displayTransactions(result.data);
                    document.getElementById('transactionModal').classList.remove('hidden');
                } else {
                    // showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Erreur chargement transactions:', error);
                // showNotification('Erreur lors du chargement des transactions', 'error');
            }
        }

        // Afficher les transactions dans le modal
        function displayTransactions(transactions) {
            const container = document.getElementById('transactionsList');
            
            if (transactions.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-8">Aucune transaction trouvée</p>';
                return;
            }

            container.innerHTML = transactions.map(transaction => `
                <div class="flex justify-between items-center p-4 border-b border-gray-200 last:border-b-0">
                    <div>
                        <p class="font-medium text-gray-800">${transaction.description}</p>
                        <p class="text-sm text-gray-500">${formatDate(transaction.date_transaction)}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold ${transaction.type_transaction === 'DEPOT' ? 'text-green-600' : 'text-red-600'}">
                            ${transaction.type_transaction === 'DEPOT' ? '+' : '-'}${formatAmount(transaction.montant)}
                        </p>
                        <p class="text-sm text-gray-500">${transaction.type_transaction}</p>
                    </div>
                </div>
            `).join('');
        }

        // Fermer le modal des transactions
        function closeTransactionModal() {
            document.getElementById('transactionModal').classList.add('hidden');
        }

        // Utilitaires
        function formatPhoneDisplay(phone) {
            if (phone.length === 12) {
                return `+${phone.substring(0, 3)} ${phone.substring(3, 5)} ${phone.substring(5, 8)} ${phone.substring(8, 10)} ${phone.substring(10)}`;
            }
            return phone;
        }

        function formatAmount(amount) {
            return new Intl.NumberFormat('fr-FR').format(amount) + ' CFA';
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('fr-FR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }

        function setLoading(loading) {
            isLoading = loading;
            const submitButton = document.getElementById('submitButton');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');
            
            if (loading) {
                submitButton.disabled = true;
                submitText.style.display = 'none';
                submitLoading.classList.add('show');
            } else {
                submitButton.disabled = false;
                submitText.style.display = 'block';
                submitLoading.classList.remove('show');
            }
        }
    </script>
</body>
</html>