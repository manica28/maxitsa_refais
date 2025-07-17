
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
        <div class="w-75 bg-white-900 bg-opacity-95 glass-effect  p-5 overflow-y-auto transition-all relative" id="sidebar">
            <!-- <button class="absolute top-5 -right-4 bg-primary text-white border-none w-8 h-8 rounded-full cursor-pointer text-sm flex items-center justify-center shadow-lg hover:bg-secondary" onclick="toggleSidebar()">
                <span id="toggleIcon">◀</span>
            </button> -->
            
            <div class="text-center text-3xl font-bold text-primary mb-8 py-2" id="logoText">MAXITSA</div>
            
            <ul class="list-none">
                <li class="mb-3">
                    <a href="/accueil" class="flex items-center p-4 text-gray-300 no-underline rounded-2xl transition-all cursor-pointer bg-primary text-white shadow-lg shadow-orange-500/30" onclick="showScreen('dashboard')">
                        <span class="text-2xl mr-4 w-6 text-center">🏠</span>
                        <span class="nav-text">Tableau de bord</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/newsecondaire" class="flex items-center p-4 text-gray-300 no-underline rounded-2xl transition-all cursor-pointer hover:bg-primary hover:bg-opacity-20 hover:text-primary hover-slide" onclick="showScreen('accounts')">
                        <span class="text-2xl mr-4 w-6 text-center">💳</span>
                        <span class="nav-text">Mes comptes</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a href="/transactions" class="flex items-center p-4 text-gray-300 no-underline rounded-2xl transition-all cursor-pointer hover:bg-primary hover:bg-opacity-20 hover:text-primary hover-slide" onclick="showScreen('transactions')">
                        <span class="text-2xl mr-4 w-6 text-center">📊</span>
                        <span class="nav-text">Transactions</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a href="#" class="flex items-center p-4 text-gray-300 no-underline rounded-2xl transition-all cursor-pointer hover:bg-primary hover:bg-opacity-20 hover:text-primary hover-slide" onclick="showScreen('settings')">
                        <span class="text-2xl mr-4 w-6 text-center">⚙️</span>
                        <span class="nav-text">Paramètres</span>
                    </a>
                </li>
            </ul>
            
            <!-- Bouton de déconnexion -->
            <div class="absolute bottom-5 left-5 right-5">
               <a href="/deconnexion"> <button class="w-full flex items-center justify-center p-4 bg-red-500 text-white no-underline rounded-2xl transition-all cursor-pointer hover:bg-red-600 hover-lift-small shadow-lg">
                    <span class="nav-text font-medium">Déconnexion</span>
                </button></a>
            </div>
        </div>