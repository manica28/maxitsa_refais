<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXITSA - Historique des transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="p-4">
            <div class="flex-1 p-10 overflow-y-auto h-full bg-white bg-opacity-10 border-l border-orange-500 border-opacity-90">


    <div class="w-[1250px] mx-auto bg-white rounded-3xl shadow-2xl p-8 ">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-orange-500 mb-2">MAXITSA</h1>
            <p class="text-gray-600 text-lg font-bold">Historique des transactions</p>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div>
                <label class="block text-black text-sm font-medium mb-2">Date de début</label>
                <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
            </div>
            <div>
                <label class="block text-black text-sm font-medium mb-2">Date de fin</label>
                <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
            </div>
            <div>
                <label class="block text-black text-sm font-medium mb-2">Type de transaction</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black">
                    <option>Tous les types</option>
                    <option>Transfert</option>
                    <option>Paiement</option>
                    <option>Dépôt</option>
                    <option>Retrait</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-orange-500 hover:bg-orange-500 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                    Rechercher
                </button>
            </div>
        </div>

        <!-- Transaction List -->
        <div class="space-y-4">
            <!-- Transaction 1 -->
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition-colors duration-200">
                <div>
                    <h3 class="font-medium text-blue-600">Transfert - Dépôt</h3>
                    <p class="text-sm text-gray-600">08/07/2025, 14:30</p>
                </div>
                <div class="text-right">
                    <span class="text-green-600 font-semibold text-lg">+50 000 CFA</span>
                </div>
            </div>

            <!-- Transaction 2 -->
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition-colors duration-200">
                <div>
                    <h3 class="font-medium text-blue-600">Paiement</h3>
                    <p class="text-sm text-gray-600">07/07/2025, 10:15</p>
                </div>
                <div class="text-right">
                    <span class="text-red-600 font-semibold text-lg">-25 000 CFA</span>
                </div>
            </div>

            <!-- Transaction 3 -->
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition-colors duration-200">
                <div>
                    <h3 class="font-medium text-blue-600">Transfert - Retrait</h3>
                    <p class="text-sm text-gray-600">06/07/2025, 16:45</p>
                </div>
                <div class="text-right">
                    <span class="text-red-600 font-semibold text-lg">-10 000 CFA</span>
                </div>
            </div>

            <!-- Transaction 4 -->
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition-colors duration-200">
                <div>
                    <h3 class="font-medium text-blue-600">Paiement</h3>
                    <p class="text-sm text-gray-600">05/07/2025, 09:20</p>
                </div>
                <div class="text-right">
                    <span class="text-red-600 font-semibold text-lg">-15 000 CFA</span>
                </div>
            </div>

            <!-- Transaction 5 -->
            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition-colors duration-200">
                <div>
                    <h3 class="font-medium text-blue-600">Transfert - Dépôt</h3>
                    <p class="text-sm text-gray-600">04/07/2025, 13:10</p>
                </div>
                <div class="text-right">
                    <span class="text-green-600 font-semibold text-lg">+100 000 CFA</span>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8 space-x-2">
            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg font-medium">1</button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors duration-200">2</button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors duration-200">3</button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors duration-200">Suivant</button>
        </div>
    </div>
    </div>

    <script>
        // Search functionality
        document.querySelector('button').addEventListener('click', function() {
            alert('Recherche lancée !');
        });

        // Pagination
        document.querySelectorAll('button').forEach(button => {
            if (button.textContent === '2' || button.textContent === '3' || button.textContent === 'Suivant') {
                button.addEventListener('click', function() {
                    alert('Navigation vers la page : ' + this.textContent);
                });
            }
        });
    </script>
</body>
</html>