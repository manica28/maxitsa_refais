<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Auchan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#1a1a1a',
                        'darker-bg': '#0f0f0f',
                        'green-accent': '#4ade80',
                        'green-hover': '#22c55e',
                        'gray-field': '#2a2a2a',
                        'gray-text': '#9ca3af'
                    }
                }
            }
        }
    </script>
</head>
<body >

     <?php   require_once '../templates/layout/partial/header.php'; ?>

<main class="p-6">
 <?php echo  $contentForLayout ?>

</body> 

</html>