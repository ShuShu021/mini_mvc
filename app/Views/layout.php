<!doctype html>
<!-- Définit la langue du document -->
<html lang="fr">
<!-- En-tête du document HTML -->
<head>
    <!-- Déclare l'encodage des caractères -->
    <meta charset="utf-8">
    <!-- Configure le viewport pour les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Définit le titre de la page avec échappement -->
    <title><?= isset($title) ? htmlspecialchars($title) : 'App' ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<!-- Corps du document -->
<body>
<?php
// Détermine la page active pour la navigation
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isHome = ($currentPath === '/');
$isProducts = (str_starts_with($currentPath, '/products'));
$isCart = ($currentPath === '/cart');
$isOrders = str_starts_with($currentPath, '/orders');
$user = $user ?? ($_SESSION['user'] ?? null);
?>
<!-- En-tête de la page -->
<header class="site-header">
    <div class="header-inner">
        <h1 class="brand"><a href="/">ShoppyFun</a></h1>
        <nav>
            <ul class="nav-list">
                <li><a class="nav-link <?= $isHome ? 'active' : '' ?>" href="/"><h2>🏠 Accueil</h2></a></li>
                <li><a class="nav-link <?= $isProducts ? 'active' : '' ?>" href="/products"><h2>📦 Produits</h2></a></li>
                <li><a class="nav-link <?= $isCart ? 'active' : '' ?>" href="/cart"><h2>🛒 Panier</h2></a></li>
                <?php if ($user): ?>
                    <li><a class="nav-link <?= $isOrders ? 'active' : '' ?>" href="/orders"><h2>📑 Mes commandes</h2></a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="auth-actions">
            <?php if ($user): ?>
                <span class="auth-text">Bonjour <?= htmlspecialchars($user['nom']) ?></span>
                <form method="POST" action="/logout">
                    <button type="submit" class="btn btn-danger">Se déconnecter</button>
                </form>
            <?php else: ?>
                <a class="btn btn-outline" href="/login">Connexion</a>
                <a class="btn btn-primary" href="/register">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<!-- Zone de contenu principal -->
<main>
    <!-- Insère le contenu rendu de la vue -->
    <?= $content ?>
    
</main>
<!-- Fin du corps de la page -->
</body>
<!-- Fin du document HTML -->
</html>

