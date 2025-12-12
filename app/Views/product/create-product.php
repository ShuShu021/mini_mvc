<!-- Formulaire pour créer un nouveau produit -->
<div class="container" style="max-width: 700px;">
    <h2>Ajouter un nouveau produit</h2>
    
    <!-- Message de succès ou d'erreur -->
    <?php if (isset($message)): ?>
        <div class="message <?= isset($success) && $success ? 'success' : 'error' ?>">
            <?= isset($success) && $success ? '✅ ' : '❌ ' ?><?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/products">
        <div class="form-group">
            <label for="nom">Nom du produit :</label>
            <input 
                type="text" 
                id="nom" 
                name="nom" 
                required 
                maxlength="150"
                value="<?= isset($old_values['nom']) ? htmlspecialchars($old_values['nom']) : '' ?>"
                placeholder="Entrez le nom du produit"
            >
        </div>
        
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                placeholder="Entrez la description du produit (optionnel)"
            ><?= isset($old_values['description']) ? htmlspecialchars($old_values['description']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="prix">Prix :</label>
            <input 
                type="number" 
                id="prix" 
                name="prix" 
                required 
                step="0.01"
                min="0"
                value="<?= isset($old_values['prix']) ? htmlspecialchars($old_values['prix']) : '' ?>"
                placeholder="0.00"
            >
        </div>
        
        <div class="form-group">
            <label for="stock">Stock :</label>
            <input 
                type="number" 
                id="stock" 
                name="stock" 
                required 
                min="0"
                value="<?= isset($old_values['stock']) ? htmlspecialchars($old_values['stock']) : '' ?>"
                placeholder="0"
            >
        </div>
        
        <div class="form-group">
            <label for="image_url">URL de l'image :</label>
            <input 
                type="url" 
                id="image_url" 
                name="image_url" 
                value="<?= isset($old_values['image_url']) ? htmlspecialchars($old_values['image_url']) : '' ?>"
                placeholder="https://exemple.com/image.jpg"
            >
            <small class="text-muted">Entrez l'URL complète de l'image (optionnel)</small>
        </div>
        
        <!-- Aperçu de l'image si une URL est fournie -->
        <?php if (!empty($old_values['image_url']) && filter_var($old_values['image_url'], FILTER_VALIDATE_URL)): ?>
            <div class="form-group">
                <label>Aperçu de l'image :</label>
                <img 
                    src="<?= htmlspecialchars($old_values['image_url']) ?>" 
                    alt="Aperçu" 
                    style="max-width: 100%; max-height: 300px; border: 1px solid #ccc; border-radius: 4px; object-fit: contain;"
                    onerror="this.style.display='none'"
                >
            </div>
        <?php endif; ?>
        
        <button type="submit" class="btn btn-primary" style="font-size: 16px;">
            Créer le produit
        </button>
    </form>
    
    <div class="gap-10 mt-20">
        <a href="/products">📋 Voir la liste des produits</a>
        <span class="text-muted">|</span>
        <a href="/">← Retour à l'accueil</a>
    </div>
</div>
