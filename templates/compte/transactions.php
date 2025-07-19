<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXITSA - Historique des transactions</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .transaction-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .filter-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .pagination-button.active {
            background: #f97316 !important;
            color: white !important;
            transform: scale(1.1);
        }
    </style>
</head>
<body class="p-4">
    <div class="flex-1 p-10 overflow-y-auto h-full bg-white bg-opacity-10 border-l border-orange-500 border-opacity-90">
        <div class="w-[1350px] mx-auto bg-white rounded-3xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-primary mb-2">MAXITSA</h1>
                <p class="text-gray-600 text-lg font-bold">Historique des transactions</p>
            </div>

            <!-- Filters -->
            <div class="filter-container rounded-2xl p-6 mb-8 shadow-lg">
                <form id="filtreForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Date de début</label>
                        <input type="date" id="dateDebut" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-700 transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Date de fin</label>
                        <input type="date" id="dateFin" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-700 transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Type de transaction</label>
                        <select id="typeTransaction" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-700 transition-all">
                            <option value="">Tous les types</option>
                            <option value="depot">Dépôt</option>
                            <option value="retrait">Retrait</option>
                            <option value="paiement">Paiement</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-primary hover:bg-secondary text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                            🔍 Rechercher
                        </button>
                        <button type="button" id="btnReinitialiser" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300">
                            🔄
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-success to-green-400 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg opacity-90">Total des dépôts</h3>
                            <p class="text-3xl font-bold" id="totalDepots">0 CFA</p>
                        </div>
                        <div class="text-4xl opacity-80">📥</div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-danger to-red-400 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg opacity-90">Total des retraits</h3>
                            <p class="text-3xl font-bold" id="totalRetraits">0 CFA</p>
                        </div>
                        <div class="text-4xl opacity-80">📤</div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-blue-400 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg opacity-90">Total des paiements</h3>
                            <p class="text-3xl font-bold" id="totalPaiements">0 CFA</p>
                        </div>
                        <div class="text-4xl opacity-80">💳</div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-primary to-accent rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg opacity-90">Nombre de transactions</h3>
                            <p class="text-3xl font-bold" id="nombreTransactions">0</p>
                        </div>
                        <div class="text-4xl opacity-80">📊</div>
                    </div>
                </div>
            </div>

            <!-- Transaction List -->
            <div class="bg-gray-50 rounded-2xl p-6 shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Transactions</h2>
                    <div class="text-sm text-gray-600" id="infoTransactions">
                        0 transaction(s)
                    </div>
                </div>
                
                <div class="max-h-96 overflow-y-auto scrollbar-thin" id="listeTransactions">
                    <!-- Les transactions seront chargées ici -->
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center gap-4 mt-8" id="pagination">
                <!-- Les boutons de pagination seront générés ici -->
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let pageActuelle = 1;
        const transactionsParPage = 5;
        let transactionsFiltrees = [];
        let toutesLesTransactions = [];

        // Récupération des données depuis PHP
        <?php if (isset($transactions) && is_array($transactions)): ?>
            toutesLesTransactions = <?= json_encode($transactions) ?>;
        <?php else: ?>
            toutesLesTransactions = [];
        <?php endif; ?>

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            transactionsFiltrees = [...toutesLesTransactions];
            afficherTransactions();
            mettreAJourStatistiques();
            genererPagination();
        });

        // Gestionnaires d'événements
        document.getElementById('filtreForm').addEventListener('submit', function(e) {
            e.preventDefault();
            pageActuelle = 1;
            rechercherTransactions();
        });

        document.getElementById('btnReinitialiser').addEventListener('click', function() {
            reinitialiserFiltres();
        });



        function rechercherTransactions() {
            const dateDebut = document.getElementById('dateDebut').value;
            const dateFin = document.getElementById('dateFin').value;
            const type = document.getElementById('typeTransaction').value;

            transactionsFiltrees = toutesLesTransactions.filter(transaction => {
                let correspond = true;

                if (dateDebut && new Date(transaction.date) < new Date(dateDebut)) {
                    correspond = false;
                }

                if (dateFin && new Date(transaction.date) > new Date(dateFin + ' 23:59:59')) {
                    correspond = false;
                }

                if (type) {
                    const typeTransaction = (transaction.typetransaction || transaction.type || '').toLowerCase();
                    if (typeTransaction !== type) {
                        correspond = false;
                    }
                }

                return correspond;
            });

            afficherTransactions();
            mettreAJourStatistiques();
            genererPagination();
        }

        function reinitialiserFiltres() {
            document.getElementById('dateDebut').value = '';
            document.getElementById('dateFin').value = '';
            document.getElementById('typeTransaction').value = '';
            
            transactionsFiltrees = [...toutesLesTransactions];
            pageActuelle = 1;
            
            afficherTransactions();
            mettreAJourStatistiques();
            genererPagination();
        }

        function afficherTransactions() {
            const conteneur = document.getElementById('listeTransactions');
            const debut = (pageActuelle - 1) * transactionsParPage;
            const fin = debut + transactionsParPage;
            const transactionsPage = transactionsFiltrees.slice(debut, fin);

            if (transactionsPage.length === 0) {
                conteneur.innerHTML = `
                    <div class="text-center py-12 text-gray-500">
                        <div class="text-6xl mb-4">📊</div>
                        <p class="text-xl font-medium">Aucune transaction trouvée</p>
                        <p class="text-sm mt-2">
                            Modifiez vos critères de recherche ou réinitialisez les filtres
                        </p>
                    </div>
                `;
                document.getElementById('infoTransactions').textContent = '0 transaction(s)';
                return;
            }

            conteneur.innerHTML = '';
            
            transactionsPage.forEach((transaction, index) => {
                const elementTransaction = creerElementTransaction(transaction, index);
                conteneur.appendChild(elementTransaction);
            });

            // Animation des éléments
            setTimeout(() => {
                const items = conteneur.querySelectorAll('.transaction-item');
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('animate-fade-in');
                    }, index * 100);
                });
            }, 50);

            const totalAffiches = fin > transactionsFiltrees.length ? transactionsFiltrees.length : fin;
            document.getElementById('infoTransactions').textContent = 
                `${debut + 1}-${totalAffiches} sur ${transactionsFiltrees.length} transaction(s)`;
        }

        function creerElementTransaction(transaction, index) {
            const div = document.createElement('div');
            div.className = 'transaction-item bg-white rounded-xl p-5 mb-4 shadow-md transition-all duration-300 hover:shadow-lg';
            div.style.animationDelay = `${index * 0.1}s`;

            // Gérer différents noms de champs
            const type = (transaction.typetransaction || transaction.type || '').toLowerCase();
            const montant = parseFloat(transaction.montant) || 0;
            
            let couleurFond, couleurTexte, icone, libelle;

            switch(type) {
                case 'depot':
                case 'dépôt':
                    couleurFond = 'bg-success bg-opacity-20 text-success';
                    couleurTexte = 'text-success';
                    icone = '📥';
                    libelle = 'Transfert - Dépôt';
                    break;
                case 'retrait':
                    couleurFond = 'bg-danger bg-opacity-20 text-danger';
                    couleurTexte = 'text-danger';
                    icone = '📤';
                    libelle = 'Transfert - Retrait';
                    break;
                case 'paiement':
                    couleurFond = 'bg-primary bg-opacity-20 text-primary';
                    couleurTexte = 'text-primary';
                    icone = '💳';
                    libelle = 'Paiement';
                    break;
                default:
                    couleurFond = 'bg-gray-200 text-gray-600';
                    couleurTexte = 'text-gray-600';
                    icone = '💰';
                    libelle = transaction.typetransaction || 'Transaction';
            }

            const dateFormatee = formaterDate(transaction.date);
            const montantFormate = formaterMontant(montant);
            const signe = (type === 'depot' || type === 'dépôt') ? '+' : '-';

            div.innerHTML = `
                <div class="flex justify-between items-center">
                    <div class="flex items-center flex-1">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center mr-4 text-2xl ${couleurFond}">
                            ${icone}
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-800 text-lg mb-1">
                                ${libelle}
                            </div>
                            <div class="text-gray-600 text-sm">
                                ${dateFormatee.relatif}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-xl mb-1 ${(type === 'depot' || type === 'dépôt') ? 'text-success' : 'text-danger'}">
                            ${signe}${montantFormate} CFA
                        </div>
                        <div class="text-xs text-gray-500">
                            ${dateFormatee.complet}
                        </div>
                    </div>
                </div>
            `;

            return div;
        }

        function formaterDate(dateString) {
            const date = new Date(dateString);
            const maintenant = new Date();
            const diff = maintenant - date;
            const jours = Math.floor(diff / (1000 * 60 * 60 * 24));

            let relatif;
            if (jours === 0) {
                relatif = `Aujourd'hui, ${date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;
            } else if (jours === 1) {
                relatif = `Hier, ${date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;
            } else if (jours <= 7) {
                relatif = `${jours} jour${jours > 1 ? 's' : ''}, ${date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;
            } else {
                relatif = date.toLocaleDateString('fr-FR') + ' à ' + date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            }

            return {
                relatif: relatif,
                complet: date.toLocaleDateString('fr-FR') + ' ' + date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
            };
        }

        function formaterMontant(montant) {
            // Vérifier si le montant est un nombre valide
            const nombre = parseFloat(montant);
            if (isNaN(nombre)) {
                return '0';
            }
            return new Intl.NumberFormat('fr-FR').format(nombre);
        }

        function mettreAJourStatistiques() {
            let totalDepots = 0;
            let totalRetraits = 0;
            let totalPaiements = 0;

            transactionsFiltrees.forEach(transaction => {
                // Gérer différents formats de montant (string ou number)
                let montant = parseFloat(transaction.montant) || 0;
                
                // Gérer différents noms de champs pour le type
                let type = (transaction.typetransaction || transaction.type || '').toLowerCase();
                
                switch(type) {
                    case 'depot':
                    case 'dépôt':
                        totalDepots += montant;
                        break;
                    case 'retrait':
                        totalRetraits += montant;
                        break;
                    case 'paiement':
                        totalPaiements += montant;
                        break;
                }
            });

            document.getElementById('totalDepots').textContent = formaterMontant(totalDepots) + ' CFA';
            document.getElementById('totalRetraits').textContent = formaterMontant(totalRetraits) + ' CFA';
            document.getElementById('totalPaiements').textContent = formaterMontant(totalPaiements) + ' CFA';
            document.getElementById('nombreTransactions').textContent = transactionsFiltrees.length;
        }

        function genererPagination() {
            const conteneurPagination = document.getElementById('pagination');
            const nombreTotalPages = Math.ceil(transactionsFiltrees.length / transactionsParPage);
            
            conteneurPagination.innerHTML = '';
            
            if (nombreTotalPages <= 1) {
                return;
            }

            // Bouton précédent
            if (pageActuelle > 1) {
                const btnPrecedent = creerBoutonPagination('‹ Précédent', pageActuelle - 1);
                conteneurPagination.appendChild(btnPrecedent);
            }

            // Calculer les pages à afficher
            let debut = Math.max(1, pageActuelle - 2);
            let fin = Math.min(nombreTotalPages, pageActuelle + 2);

            // Ajuster si on est près du début ou de la fin
            if (fin - debut < 4) {
                if (debut === 1) {
                    fin = Math.min(nombreTotalPages, debut + 4);
                } else if (fin === nombreTotalPages) {
                    debut = Math.max(1, fin - 4);
                }
            }

            // Première page si nécessaire
            if (debut > 1) {
                conteneurPagination.appendChild(creerBoutonPagination('1', 1));
                if (debut > 2) {
                    const ellipse = document.createElement('span');
                    ellipse.textContent = '...';
                    ellipse.className = 'px-3 py-3 text-gray-500';
                    conteneurPagination.appendChild(ellipse);
                }
            }

            // Pages principales
            for (let i = debut; i <= fin; i++) {
                const bouton = creerBoutonPagination(i, i);
                if (i === pageActuelle) {
                    bouton.classList.add('active');
                }
                conteneurPagination.appendChild(bouton);
            }

            // Dernière page si nécessaire
            if (fin < nombreTotalPages) {
                if (fin < nombreTotalPages - 1) {
                    const ellipse = document.createElement('span');
                    ellipse.textContent = '...';
                    ellipse.className = 'px-3 py-3 text-gray-500';
                    conteneurPagination.appendChild(ellipse);
                }
                conteneurPagination.appendChild(creerBoutonPagination(nombreTotalPages, nombreTotalPages));
            }

            // Bouton suivant
            if (pageActuelle < nombreTotalPages) {
                const btnSuivant = creerBoutonPagination('Suivant ›', pageActuelle + 1);
                conteneurPagination.appendChild(btnSuivant);
            }
        }

        function creerBoutonPagination(texte, page) {
            const bouton = document.createElement('button');
            bouton.textContent = texte;
            bouton.className = 'pagination-button bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-all transform hover:scale-105';
            
            bouton.addEventListener('click', function() {
                if (page !== pageActuelle) {
                    pageActuelle = page;
                    afficherTransactions();
                    genererPagination();
                    
                    // Faire défiler vers le haut de la liste
                    document.getElementById('listeTransactions').scrollTop = 0;
                }
            });

            return bouton;
        }
    </script>
</body>
</html>