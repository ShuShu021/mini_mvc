<?php

declare(strict_types=1);

session_start();

require dirname(path: __DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;
use Mini\Controllers\HomeController;
use Mini\Controllers\ProductController;
use Mini\Controllers\AuthController;
use Mini\Controllers\CartController;
use Mini\Controllers\OrderController;

// Table des routes minimaliste
$routes = [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/products', [ProductController::class, 'listProducts']],
    ['GET', '/products/create', [ProductController::class, 'showCreateProductForm']],
    ['POST', '/products', [ProductController::class, 'createProduct']],
    ['GET', '/products/{id}', [ProductController::class, 'show']],

    // Authentification
    ['GET', '/register', [AuthController::class, 'showRegisterForm']],
    ['POST', '/register', [AuthController::class, 'register']],
    ['GET', '/login', [AuthController::class, 'showLoginForm']],
    ['POST', '/login', [AuthController::class, 'login']],
    ['POST', '/logout', [AuthController::class, 'logout']],

    // Panier
    ['GET', '/cart', [CartController::class, 'show']],
    ['POST', '/cart/add', [CartController::class, 'add']],
    ['POST', '/cart/remove', [CartController::class, 'remove']],
    ['POST', '/cart/clear', [CartController::class, 'clear']],

    // Commandes
    ['POST', '/checkout', [OrderController::class, 'checkout']],
    ['GET', '/orders', [OrderController::class, 'list']],
    ['GET', '/orders/{id}', [OrderController::class, 'show']],
];
// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);