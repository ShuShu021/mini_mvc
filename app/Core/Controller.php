<?php
// Active le mode strict pour les types
declare(strict_types=1);
// Espace de noms du noyau (Core)
namespace Mini\Core;
// Déclare une classe abstraite de contrôleur de base
class Controller
{
    // Méthode utilitaire pour rendre une vue avec des paramètres
    protected function render(string $view, array $params = []): void
    {
        // Extrait les paramètres en variables locales, sans écraser les existantes
        extract(array: $params);
        // Construit le chemin du fichier de vue
        $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
        // Construit le chemin du layout principal
        $layoutFile = dirname(__DIR__) . '/Views/layout.php';

        // Démarre la temporisation de sortie pour capturer le rendu de la vue
        ob_start();
        // Inclut la vue spécifique
        require $viewFile;
        
        // Récupère le contenu rendu et nettoie le tampon
        $content = ob_get_clean();

        // Inclut le layout qui utilise la variable $content
        require $layoutFile;
    }

    /**
     * Retourne l'utilisateur connecté (données stockées en session) ou null.
     */
    protected function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Redirige vers une URL et termine le script.
     */
    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    /**
     * Exige un utilisateur connecté, sinon redirige vers /login.
     */
    protected function requireAuth(): array
    {
        $user = $this->currentUser();
        if (!$user) {
            $this->redirect('/login');
        }
        return $user;
    }
}


