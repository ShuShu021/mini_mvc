<!-- Liste des produits -->
<div class="container">
    <div class="gap-10" style="justify-content: space-between; align-items: center;">
        <h2>Liste des produits</h2>
        <a href="/products/create" class="btn btn-primary">➕ Ajouter un produit</a>
    </div>
    
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <p style="font-size: 18px;" class="text-muted">Aucun produit disponible.</p>
            <a href="/products/create">Créer le premier produit</a>
        </div>
    <?php else: ?>
        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <?php if (!empty($product['image_url'])): ?>
                        <div class="center" style="margin-bottom: 15px;">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['nom']) ?>" style="max-height: 200px; object-fit: contain;" onerror="this.style.display='none'">
                        </div>
                    <?php else: ?>
                        <div class="empty-state" style="padding: 20px;">
                            <span class="text-small">Aucune image</span>
                        </div>
                    <?php endif; ?>
                    
                    <h3><?= htmlspecialchars($product['nom']) ?></h3>
                    
                    <?php if (!empty($product['description'])): ?>
                        <p class="text-muted"><?= htmlspecialchars($product['description']) ?></p>
                    <?php endif; ?>
                    
                    <div class="gap-10" style="justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                        <div>
                            <div class="price"><?= number_format((float)$product['prix'], 2, ',', ' ') ?> €</div>
                            <div class="text-small">Stock: <?= htmlspecialchars($product['stock']) ?></div>
                        </div>
                    </div>
                    
                    <div class="text-small" style="margin-top: 10px;">
                        ID: <?= htmlspecialchars($product['id']) ?>
                    </div>
                    <div class="gap-10" style="margin-top: 10px;">
                        <a href="/products/<?= htmlspecialchars($product['id']) ?>" class="btn btn-outline">Voir</a>
                        <?php if (($product['stock'] ?? 0) > 0): ?>
                            <form method="POST" action="/cart/add" style="margin:0;">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="mt-30 center">
        <a href="/">← Retour à l'accueil</a>
    </div>
</div>

