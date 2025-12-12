<?php

// Active le mode strict pour la vérification des types
declare(strict_types=1);
// Déclare l'espace de noms pour ce contrôleur
namespace Mini\Controllers;
// Importe la classe de base Controller du noyau
use Mini\Core\Controller;
use Mini\Models\User;
use Mini\Models\Product;

// Déclare la classe finale HomeController qui hérite de Controller
final class HomeController extends Controller
{
    // Déclare la méthode d'action par défaut qui ne retourne rien
    public function index(): void
    {
        $products = Product::getAll(6); // derniers produits

        $this->render('home/index', params: [
            'title' => 'Boutique',
            'products' => $products,
            'user' => $this->currentUser(),
        ]);
    }

    // Les anciennes routes JSON utilisateurs sont supprimées du router,
    // on conserve le controller minimal.
}