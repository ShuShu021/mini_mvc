<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Category
{
    private $id;
    private $nom;

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Récupère toutes les catégories.
     */
    public static function getAll(): array
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query('SELECT * FROM categorie ORDER BY nom ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


