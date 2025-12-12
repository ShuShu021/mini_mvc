<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;

final class CartController extends Controller
{
    public function show(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        $products = Product::findManyByIds(array_keys($cart));

        $items = [];
        $total = 0.0;
        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) {
                continue;
            }
            $product = $products[$productId];
            $lineTotal = (float)$product['prix'] * $qty;
            $total += $lineTotal;
            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        $this->render('cart/show', [
            'title' => 'Panier',
            'items' => $items,
            'total' => $total,
            'user' => $this->currentUser(),
        ]);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/products');
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        $product = Product::findById($productId);
        if (!$product) {
            $this->redirect('/products');
        }

        if ($product['stock'] <= 0) {
            $this->redirect('/products/' . $productId);
        }

        $currentQty = $_SESSION['cart'][$productId] ?? 0;
        $newQty = min($product['stock'], $currentQty + $quantity);
        $_SESSION['cart'][$productId] = $newQty;

        $this->redirect('/cart');
    }

    public function remove(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart');
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        unset($_SESSION['cart'][$productId]);
        $this->redirect('/cart');
    }

    public function clear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart');
        }

        $_SESSION['cart'] = [];
        $this->redirect('/cart');
    }
}


