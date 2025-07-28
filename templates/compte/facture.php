<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu d'Achat Woyofal - MAXITSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { font-size: 12px; }
            .no-print { display: none; }
            .print-only { display: block; }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        }
        
        .receipt-border {
            border: 2px dashed #e5e7eb;
            border-radius: 10px;
        }
        
        .qr-code {
            width: 80px;
            height: 80px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-2xl mx-auto">
            
            <!-- Header avec boutons d'action -->
            <div class="no-print mb-6 text-center space-x-4">
                <button onclick="window.print()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    🖨️ Imprimer
                </button>
                <button onclick="downloadPDF()" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                    📄 Télécharger PDF
                </button>
                <button onclick="sendSMS()" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                    📱 Envoyer par SMS
                </button>
                <a href="/home" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition inline-block">
                    🏠 Retour Dashboard
                </a>
            </div>

            <!-- Reçu principal -->
            <div class="bg-white shadow-2xl rounded-lg overflow-hidden receipt-border">
                
                <!-- En-tête -->
                <div class="gradient-bg text-white p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold">MAXITSA</h1>
                            <p class="text-sm opacity-90">Plateforme de Services Financiers</p>
                            <p class="text-xs opacity-75">Partenaire Officiel Senelec</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-white bg-opacity-20 px-3 py-1 rounded-lg">
                                <p class="text-xs font-semibold">REÇU OFFICIEL</p>
                                <p class="text-lg font-bold">#R<?= $data['reference'] ?? 'REF20240728123456' ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations transaction -->
                <div class="p-6 border-b border-gray-200">
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">🔋 ACHAT CODE WOYOFAL</h2>
                        <p class="text-sm text-gray-600">Transaction effectuée avec succès</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations client -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-gray-800 border-b pb-1">👤 Informations Client</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nom et Prénom:</span>
                                    <span class="font-semibold"><?= $data['client'] ?? 'Amadou Diop' ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Téléphone:</span>
                                    <span class="font-semibold"><?= $data['telephone'] ?? '+221 77 123 45 67' ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Compte MAXITSA:</span>
                                    <span class="font-semibold"><?= $data['compteMaxitsa'] ?? 'MAX001234567' ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Informations compteur -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-gray-800 border-b pb-1">⚡ Informations Compteur</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Numéro Compteur:</span>
                                    <span class="font-bold text-blue-600"><?= $data['compteur'] ?? 'CPT001234567' ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Client Senelec:</span>
                                    <span class="font-semibold"><?= $data['clientSenelec'] ?? 'Amadou Diop' ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tranche Tarifaire:</span>
                                    <span class="font-semibold text-green-600"><?= $data['tranche'] ?? 'Tranche 1 (Sociale)' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails de la transaction -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800 border-b pb-2 mb-4">💰 Détails de la Transaction</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Montant Payé:</span>
                                <span class="font-bold text-lg"><?= number_format($data['montantPaye'] ?? 5000, 0, ',', ' ') ?> FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Prix Unitaire kWh:</span>
                                <span class="font-semibold"><?= $data['prix'] ?? '79.99' ?> FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nombre de kWh:</span>
                                <span class="font-bold text-green-600"><?= $data['nbreKwt'] ?? '62.50' ?> kWh</span>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date Transaction:</span>
                                <span class="font-semibold"><?= $data['date'] ?? date('d/m/Y H:i:s') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Référence:</span>
                                <span class="font-semibold text-blue-600"><?= $data['reference'] ?? 'REF20240728123456' ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Statut:</span>
                                <span class="font-bold text-green-600">✅ SUCCÈS</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code de recharge -->
                <div class="p-6 bg-gradient-to-r from-green-50 to-blue-50 border-b border-gray-200">
                    <div class="text-center">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">🔑 CODE DE RECHARGE WOYOFAL</h3>
                        <div class="bg-white border-2 border-dashed border-green-400 rounded-lg p-4 my-4">
                            <div class="text-center">
                                <p class="text-xs text-gray-600 mb-1">Votre code de recharge:</p>
                                <p class="text-2xl font-mono font-bold text-green-600 tracking-wider">
                                    <?= $data['code'] ?? '12345678-87654321-11223344' ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Tapez ce code sur votre compteur Woyofal</p>
                            </div>
                        </div>
                        
                        <!-- Instructions d'utilisation -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4">
                            <h4 class="font-semibold text-yellow-800 text-sm mb-2">📋 Instructions d'utilisation:</h4>
                            <ol class="text-xs text-yellow-700 text-left space-y-1">
                                <li>1. Sur votre compteur, appuyez sur la touche "MENU"</li>
                                <li>2. Sélectionnez "RECHARGE" ou "TOKEN"</li>
                                <li>3. Saisissez le code de recharge ci-dessus</li>
                                <li>4. Confirmez en appuyant sur "ENTER" ou "OK"</li>
                                <li>5. Votre crédit sera ajouté automatiquement</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- QR Code (simulation) -->
                        <div class="text-center">
                            <h4 class="font-semibold text-gray-800 mb-2">📱 QR Code</h4>
                            <div class="qr-code mx-auto flex items-center justify-center">
                                <div class="w-16 h-16 bg-gray-300 rounded"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">Scannez pour voir les détails</p>
                        </div>

                        <!-- Récapitulatif système de tranches -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">📊 Système de Tranches</h4>
                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span>Tranche 1 (0-150 kWh):</span>
                                    <span class="text-green-600">Sociale</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tranche 2 (151-300 kWh):</span>
                                    <span class="text-orange-600">Normale</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tranche 3 (301+ kWh):</span>
                                    <span class="text-red-600">Élevée</span>
                                </div>
                                <p class="text-gray-500 text-xs mt-2 italic">
                                    Les tranches se remettent à zéro chaque 1er du mois
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations de contact et conditions -->
                <div class="p-6 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Support client -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">🎧 Support Client</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p>📞 Service Client: +221 33 123 45 67</p>
                                <p>📱 WhatsApp: +221 77 123 45 67</p>
                                <p>📧 Email: support@maxitsa.com</p>
                                <p>🕒 Horaires: 8h-20h, 7j/7</p>
                            </div>
                        </div>

                        <!-- Conditions -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">⚖️ Conditions Importantes</h4>
                            <div class="space-y-1 text-xs text-gray-600">
                                <p>• Ce reçu fait foi de votre achat</p>
                                <p>• Code valable 30 jours après achat</p>
                                <p>• Conservez ce reçu précieusement</p>
                                <p>• Aucun remboursement après utilisation</p>
                                <p>• Support disponible 24h/24</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="gradient-bg text-white p-4 text-center">
                    <div class="flex justify-between items-center text-xs">
                        <span>© 2024 MAXITSA - Tous droits réservés</span>
                        <span>Partenaire Officiel Senelec Woyofal</span>
                        <span>Transaction sécurisée SSL</span>
                    </div>
                </div>
            </div>

            <!-- Message de remerciement -->
            <div class="no-print mt-6 text-center">
                <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                    <h3 class="text-lg font-bold text-green-800">🎉 Merci pour votre confiance !</h3>
                    <p class="text-sm text-green-700">
                        Votre code Woyofal a été généré avec succès. 
                        N'hésitez pas à nous contacter si vous avez des questions.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour télécharger en PDF
        function downloadPDF() {
            window.print();
        }

        // Fonction pour envoyer par SMS
        function sendSMS() {
            const code = '<?= $data["code"] ?? "12345678-87654321-11223344" ?>';
            const compteur = '<?= $data["compteur"] ?? "CPT001234567" ?>';
            const telephone = '<?= $data["telephone"] ?? "+221771234567" ?>';
            
            if (confirm(`Envoyer le code de recharge par SMS au ${telephone} ?`)) {
                // Ici vous pouvez intégrer votre service SMS
                alert('SMS envoyé avec succès !');
            }
        }

        // Auto-print si paramètre présent
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            setTimeout(() => window.print(), 1000);
        }

        // Copier le code au clic
        document.addEventListener('click', function(e) {
            if (e.target.closest('.text-2xl.font-mono')) {
                const code = e.target.textContent;
                navigator.clipboard.writeText(code).then(() => {
                    alert('Code copié dans le presse-papiers !');
                });
            }
        });
    </script>
</body>
</html>