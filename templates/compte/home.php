
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXITSA - Interface Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = 
        {
            theme: 
            {
                extend: 
                {
                    colors: 
                    {
                        primary: '#f97316',
                        secondary: '#ea580c',
                        accent: '#fb923c',
                        success: '#28a745',
                        danger: '#dc3545'
                    },
                    backdropBlur: 
                    {
                        xs: '2px',
                    }
                }
            }
        }
    </script>
    <style>
        .bg-gradient-primary 
        {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        
        .bg-gradient-dark 
        {
            background: linear-gradient(135deg, #595a5c 0%, #111827 100%);
        }
        
        .bg-gradient-accent 
        {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        }
        
        .glass-effect 
        {
            backdrop-filter: blur(10px);
        }
        
        .transition-all 
        {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover 
        {
            transform: translateY(-5px);
        }
        
        .hover-slide:hover 
        {
            transform: translateX(5px);
        }
        
        .hover-lift-small:hover 
        {
            transform: translateY(-2px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .animate-fade {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .animate-slide {
            animation: slideIn 0.3s ease-in-out;
        }
        
        .animate-pulse-custom {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="font-sans bg-gradient-dark min-h-screen text-white">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <div class="w-70 bg-white-900 bg-opacity-95 glass-effect  border-opacity-60 p-5 overflow-y-auto transition-all relative" id="sidebar">
         
        <!-- Main Content -->
        <div class="flex-1 flex overflow-hidden">
            <!-- Dashboard Content -->
            <div class="flex-1 p-8 overflow-y-auto bg-white bg-opacity-10 border-l border-orange-500">
                <!-- Dashboard Screen -->
                <div id="dashboard" class="screen active">
                    <div class="flex justify-between items-center mb-8 text-white">
                        <div>
                            <h1 class="text-5xl font-light">Tableau de bord</h1>
                            <p class="text-xl opacity-90">Bienvenue sur votre espace MAXITSA</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center text-2xl text-white">👤</div>
                            <div>
                                <div class="font-semibold"><?php echo $comptes['nom'] . ' ' .  $comptes['prenom']; ?></div>
                                <div class="opacity-80"><?php echo $comptes['telephone']  ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-primary text-white text-center rounded-3xl p-6 shadow-lg hover-lift transition-all glass-effect">
                            <div class="opacity-90 text-lg">Solde du compte principal</div>
                            <div class="text-5xl font-bold my-4"><?php echo $comptes['solde']  ?></div>
                            <div class="opacity-90 text-lg">Compte numéro: <?php echo $comptes['numero']  ?></div>
                            <div class="flex gap-4 mt-5 flex-wrap">
                                <button class="flex-1 min-w-32 py-3 px-5 bg-white bg-opacity-20 border-none rounded-2xl text-white cursor-pointer transition-all font-medium hover:bg-opacity-30 hover-lift-small" onclick="showScreen('transfer')">
                                    💸 Transférer
                                </button>
                                <button class="flex-1 min-w-32 py-3 px-5 bg-white bg-opacity-20 border-none rounded-2xl text-white cursor-pointer transition-all font-medium hover:bg-opacity-30 hover-lift-small" onclick="showScreen('payment')">
                                    💰 Payer
                                </button>
                                <button class="flex-1 min-w-32 py-3 px-5 bg-white bg-opacity-20 border-none rounded-2xl text-white cursor-pointer transition-all font-medium hover:bg-opacity-30 hover-lift-small" onclick="showScreen('accounts')">
                                    💳 Comptes
                                </button>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-95 rounded-3xl p-6 shadow-lg hover-lift transition-all glass-effect">
                            <h3 class="mb-4 text-gray-800 text-xl font-semibold">📊 Statistiques</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-primary bg-opacity-10 rounded-xl">
                                    <div class="text-3xl font-bold text-primary"><?php echo count($comptes); ?></div>
                                    <div class="text-gray-600">Comptes</div>
                                </div>
                                <div class="text-center p-4 bg-success bg-opacity-10 rounded-xl">
                                    <div class="text-3xl font-bold text-success">24</div>
                                    <div class="text-gray-600">Transactions</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-95 rounded-3xl p-6 shadow-lg hover-lift transition-all glass-effect">
                            <h3 class="mb-4 text-gray-800 text-xl font-semibold">🎯 Actions rapides</h3>
                            <div class="grid gap-3">
                                <a href="/newsecondaire"><button class="w-full py-3 px-8 bg-primary text-white border-none rounded-full text-base font-medium cursor-pointer transition-all hover:bg-blue-600 hover-lift-small shadow-lg" onclick="showScreen('accounts')">
                                    Ajouter un compte
                                </button></a>
                                <button class="w-full py-3 px-8 bg-primary text-white border-none rounded-full text-base font-medium cursor-pointer transition-all hover:bg-blue-600 hover-lift-small shadow-lg" onclick="startScan()">
                                    Scanner un QR Code
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white bg-opacity-95 rounded-3xl p-6 mb-8 shadow-lg glass-effect">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-xl font-semibold text-gray-800">Dernières transactions</h3>
                            <a href="/transactions" class="text-primary no-underline font-medium py-2 px-4 rounded-2xl transition-all hover:bg-primary hover:bg-opacity-10" onclick="showScreen('transactions')">Voir tout</a>
                        </div>
                          <div class="max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hover:scrollbar-thumb-gray-400">
                                <?php if (isset($transactions) && !empty($transactions)): ?>
                                    <?php foreach ($transactions as $index => $transaction): ?>
                                        <div class="flex justify-between items-center p-4 <?= $index < count($transactions) - 1 ? 'border-b border-gray-200' : '' ?> transition-all hover:bg-primary hover:bg-opacity-5 hover:rounded-xl">
                                            <div class="flex items-center flex-1">
                                                <div class="text-2xl mr-4 w-10 h-10 rounded-full flex items-center justify-center bg-primary bg-opacity-10 text-primary">
                                                    <?php 
                                                    switch(strtolower($transaction['typetransaction'])) {
                                                        case 'depot': echo '📥'; break;
                                                        case 'retrait': echo '📤'; break;
                                                        case 'paiement': echo '💳'; break;
                                                        default: echo '💰';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-800 mb-1">
                                                        <?php 
                                                        switch(strtolower($transaction['typetransaction'])) {
                                                            case 'depot': echo 'Transfert - Dépôt'; break;
                                                            case 'retrait': echo 'Transfert - Retrait'; break;
                                                            case 'paiement': echo 'Paiement'; break;
                                                            default: echo ucfirst($transaction['typetransaction']);
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="text-gray-600 text-sm">
                                                        <?php 
                                                        $date = new DateTime($transaction['date']);
                                                        $now = new DateTime();
                                                        $diff = $now->diff($date);
                                                        
                                                        if ($diff->d == 0) {
                                                            echo "Aujourd'hui, " . $date->format('H:i');
                                                        } elseif ($diff->d == 1) {
                                                            echo "Hier, " . $date->format('H:i');
                                                        } elseif ($diff->d <= 7) {
                                                            echo $diff->d . " jour" . ($diff->d > 1 ? 's' : '') . ", " . $date->format('H:i');
                                                        } else {
                                                            echo $date->format('d/m/Y à H:i');
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="font-bold text-lg <?= strtolower($transaction['typetransaction']) === 'depot' ? 'text-success' : 'text-danger' ?>">
                                                <?= strtolower($transaction['typetransaction']) === 'depot' ? '+' : '-' ?><?= number_format($transaction['montant'], 0, ',', ' ') ?> CFA
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-8 text-gray-500">
                                        <div class="text-4xl mb-4">📊</div>
                                        <p class="text-lg">Aucune transaction récente</p>
                                        <p class="text-sm mt-2">Vos transactions apparaîtront ici</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const logoText = document.getElementById('logoText');
            const navTexts = document.querySelectorAll('.nav-text');
            
            if (sidebar.classList.contains('w-70')) {
                sidebar.classList.remove('w-70');
                sidebar.classList.add('w-20');
                toggleIcon.textContent = '▶';
                logoText.textContent = 'M';
                logoText.classList.add('text-xl');
                logoText.classList.remove('text-3xl');
                navTexts.forEach(text => text.style.display = 'none');
                
                // Center nav icons
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.classList.add('justify-center');
                    link.classList.remove('p-4');
                    link.classList.add('p-3');
                });
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-70');
                toggleIcon.textContent = '◀';
                logoText.textContent = 'MAXITSA';
                logoText.classList.remove('text-xl');
                logoText.classList.add('text-3xl');
                navTexts.forEach(text => text.style.display = 'block');
                
                // Reset nav links
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.classList.remove('justify-center');
                    link.classList.remove('p-3');
                    link.classList.add('p-4');
                });
            }
        }

        function showScreen(screenName) {
            // Remove active class from all nav links
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('bg-primary', 'text-white', 'shadow-lg');
                link.classList.add('text-gray-600');
            });
            
            // Add active class to clicked nav link
            event.target.closest('.nav-link').classList.add('bg-primary', 'text-white', 'shadow-lg');
            event.target.closest('.nav-link').classList.remove('text-gray-600');
            
            // Show the selected screen (for now, just the dashboard is implemented)
            console.log('Showing screen:', screenName);
        }

        function startScan() {
            console.log('Starting QR code scan...');
        }

        function logout() {
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                console.log('User logged out');
                // Ici vous pouvez ajouter la logique de déconnexion
                // Par exemple : window.location.href = '/login';
            }
        }
    </script>
</body>
</html>