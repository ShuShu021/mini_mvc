<div class="container">
    <h2 class="section-title">Derniers produits</h2>
    <?php if (empty($products)): ?>
        <p>Aucun produit pour le moment.</p>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <?php if (!empty($product['image_url'])): ?>
                        <div class="center" style="margin-bottom: 10px;">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['nom']) ?>" style="max-height: 180px; object-fit: contain;" onerror="this.style.display='none'">
                        </div>
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($product['nom']) ?></h3>
                    <p class="text-muted" style="min-height: 40px;"><?= htmlspecialchars(substr($product['description'] ?? '', 0, 80)) ?>...</p>
                    <div class="gap-10" style="justify-content: space-between;">
                        <strong class="price"><?= number_format((float)$product['prix'], 2, ',', ' ') ?> €</strong>
                        <a class="btn btn-outline" href="/products/<?= htmlspecialchars($product['id']) ?>">Voir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
