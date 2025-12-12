<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Core\Database;
use Mini\Models\Product;
use PDO;

final class OrderController extends Controller
{
    public function checkout(): void
    {
        $user = $this->requireAuth();

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $this->redirect('/cart');
        }

        $products = Product::findManyByIds(array_keys($cart));
        if (empty($products)) {
            $this->redirect('/cart');
        }

        $pdo = Database::getPDO();
        $pdo->beginTransaction();

        try {
            $total = 0.0;
            foreach ($cart as $productId => $qty) {
                if (!isset($products[$productId])) {
                    throw new \RuntimeException('Produit manquant');
                }
                $product = $products[$productId];
                if ((int)$product['stock'] < $qty) {
                    throw new \RuntimeException('Stock insuffisant');
                }
                $total += (float)$product['prix'] * $qty;
            }

            $stmt = $pdo->prepare('INSERT INTO commande (user_id, total, statut) VALUES (?, ?, ?)');
            $stmt->execute([$user['id'], $total, 'payee']);
            $orderId = (int)$pdo->lastInsertId();

            $itemStmt = $pdo->prepare('INSERT INTO commande_item (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)');
            $stockStmt = $pdo->prepare('UPDATE produit SET stock = stock - ? WHERE id = ?');

            foreach ($cart as $productId => $qty) {
                $product = $products[$productId];
                $itemStmt->execute([$orderId, $productId, $qty, $product['prix']]);
                $stockStmt->execute([$qty, $productId]);
            }

            $pdo->commit();
            $_SESSION['cart'] = [];
            $this->redirect('/orders/' . $orderId);
        } catch (\Throwable $e) {
            $pdo->rollBack();
            $this->redirect('/cart');
        }
    }

    public function list(): void
    {
        $user = $this->requireAuth();
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM commande WHERE user_id = ? ORDER BY id DESC');
        $stmt->execute([$user['id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('order/list', [
            'title' => 'Mes commandes',
            'orders' => $orders,
            'user' => $user,
        ]);
    }

    public function show(string $id): void
    {
        $user = $this->requireAuth();
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare('SELECT * FROM commande WHERE id = ? AND user_id = ?');
        $stmt->execute([(int)$id, $user['id']]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$order) {
            http_response_code(404);
            echo 'Commande introuvable';
            return;
        }

        $itemsStmt = $pdo->prepare('SELECT ci.*, p.nom FROM commande_item ci JOIN produit p ON p.id = ci.produit_id WHERE ci.commande_id = ?');
        $itemsStmt->execute([(int)$id]);
        $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('order/show', [
            'title' => 'Commande #' . $id,
            'order' => $order,
            'items' => $items,
            'user' => $user,
        ]);
    }
}


