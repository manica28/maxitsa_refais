<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXITSA - Authentification</title>
    <script src="https://cdn.tailwindcss.com"></script>
   
</head>
<body class="bg-gray-100" >
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-7xl min-h-[800px] bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Left side - Form -->
                <div class="lg:w-1/2 p-10 lg:p-12 mt-3 ">
                    <!-- Logo and welcome text -->
                    <div class="mb-8 bg- p-6 rounded-lg shadow-lg bg-gray-100">
                        <div class="flex items-center mb-2 ">
                           
                            <img src="/images/uploads/logb.png" alt="logo" class="w-15 h-12 ">
                            <span class="text-2xl font-bold text-gray-700">MAXITSA</span>
                        </div>
                        <p class="text-gray-600 text-sm ">Bienvenue chez vous</p>
                    </div>

                    <!-- Form -->
                    <form action="/inscription/store" method="POST" enctype="multipart/form-data" class="space-y-6">
                   
                        <div>
                            <input
                                type="text"
                                name="nom"
                                placeholder="Nom"
                                value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-700"
                            />
                            <?php if (!empty($errors['nom'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= $errors['nom'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <input
                                type="text"
                                name="prenom"
                                placeholder="Prénom"
                                value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-700"
                            />
                            <?php if (!empty($errors['prenom'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= $errors['prenom'] ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- Phone number -->
                        <div>
                            <input
                                type="tel"
                                name="numero"
                                placeholder="Numéro téléphonique"
                                value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-700"
                            />
                            <?php if (!empty($errors['numero'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= $errors['numero'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- ID card number -->
                        <div>
                            <input
                                type="text"
                                name="cni"
                                placeholder="Numéro carte d'identité"
                                value="<?= htmlspecialchars($_POST['cni'] ?? '') ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-gray-700"
                            />
                            <?php if (!empty($errors['cni'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= $errors['cni'] ?></p>
                            <?php endif; ?>
                        </div>

                       
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2"></label>
                            <div id="drop-recto" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition-colors">
                                <input type="file" name="recto" id="recto" accept="image/*" class="hidden" />
                                <span id="recto-label">Déposez une image ou cliquez pour sélectionner Recto CNI</span>
                            </div>
                            <?php if (!empty($errors['recto'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= $errors['recto'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Verso CNI -->
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2"></label>
                            <div id="drop-verso" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition-colors">
                                <input type="file" name="verso" id="verso" accept="image/*" class="hidden" />
                                <span id="verso-label">Déposez une image ou cliquez pour sélectionner Verso CNI</span>
                            </div>
                            <?php if (!empty($errors['verso'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?= $errors['verso'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Global error message -->
                        <?php if (!empty($errors['global'])): ?>
                            <div class="text-red-500 text-center mb-4"><?= $errors['global'] ?></div>
                        <?php endif; ?>

                        <!-- Login link -->
                        <div class="text-center">
                            <p class="text-gray-600 text-sm">
                                Déjà un compte ? 
                                <a href="<?php  $requestUri = $_SERVER['REQUEST_URI']?>connexion" class="text-orange-500 hover:text-orange-600 ml-1">
                                    Se connecter
                                </a>
                            </p>
                        </div>

                        <!-- Confirm button -->
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Confirmer
                        </button>
                    </form>
                </div>

                <!-- Right side - Illustration -->
                    <!-- Main illustration image -->
                    <img src="/images/uploads/otp.gif" alt="OTP Illustration" class="h-[700px] w-600px " />

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
function setupDropZone(dropId, inputId, labelId) {
    const dropZone = document.getElementById(dropId);
    const input = document.getElementById(inputId);
    const label = document.getElementById(labelId);

    dropZone.addEventListener('click', () => input.click());
    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('border-orange-500');
    });
    dropZone.addEventListener('dragleave', e => {
        e.preventDefault();
        dropZone.classList.remove('border-orange-500');
    });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-orange-500');
        input.files = e.dataTransfer.files;
        label.textContent = input.files[0].name;
    });
    input.addEventListener('change', () => {
        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        }
    });
}
setupDropZone('drop-recto', 'recto', 'recto-label');
setupDropZone('drop-verso', 'verso', 'verso-label');
</script>
<<!-- ?php
use App\Core\Session;

// Assuming $code_pin is defined somewhere in your code
Session::getInstance()->set('last_code_pin', $code_pin);
?> -->

?php  $requestUri = $_SERVER['REQUEST_URI']?>inscription
</body>
</html>