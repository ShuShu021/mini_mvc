<?php

// Ici je définit le namespace ou il y aura ma class
namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Product
{
    private $id;
    private $nom;
    private $description;
    private $prix;
    private $stock;
    private $image_url;
    private $categorie_id;

    // =====================
    // Getters / Setters
    // =====================

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getImageUrl()
    {
        return $this->image_url;
    }

    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }

    public function getCategorieId()
    {
        return $this->categorie_id;
    }

    public function setCategorieId($categorie_id)
    {
        $this->categorie_id = $categorie_id;
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les produits
     * @return array
     */
    public static function getAll(int $limit = 0)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * FROM produit ORDER BY id DESC";
        if ($limit > 0) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un produit par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère plusieurs produits par leurs IDs.
     * @param int[] $ids
     * @return array<int, array<string,mixed>>
     */
    public static function findManyByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM produit WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $indexed = [];
        foreach ($results as $row) {
            $indexed[(int)$row['id']] = $row;
        }
        return $indexed;
    }

    /**
     * Crée un nouveau produit
     * @return bool
     */
    public function save()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO produit (nom, description, prix, stock, image_url, categorie_id) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->nom,
            $this->description,
            $this->prix,
            $this->stock,
            $this->image_url,
            $this->categorie_id
        ]);
    }

    /**
     * Met à jour les informations d'un produit existant
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE produit SET nom = ?, description = ?, prix = ?, stock = ?, image_url = ?, categorie_id = ? WHERE id = ?");
        return $stmt->execute([
            $this->nom,
            $this->description,
            $this->prix,
            $this->stock,
            $this->image_url,
            $this->categorie_id,
            $this->id
        ]);
    }

    /**
     * Supprime un produit
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM produit WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    /**
     * Décrémente le stock si suffisant.
     */
    public static function decrementStock(int $productId, int $quantity): bool
    {
        $pdo = Database::getPDO();
        $check = $pdo->prepare('SELECT stock FROM produit WHERE id = ?');
        $check->execute([$productId]);
        $stock = $check->fetchColumn();
        if ($stock === false || (int)$stock < $quantity) {
            return false;
        }
        $stmt = $pdo->prepare('UPDATE produit SET stock = stock - ? WHERE id = ?');
        return $stmt->execute([$quantity, $productId]);
    }
}

