<div class="container product-detail">
    <div class="card center">
        <?php if (!empty($product['image_url'])): ?>
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['nom']) ?>" onerror="this.style.display='none'">
        <?php else: ?>
            <div class="empty-state" style="padding: 60px 0;">Aucune image</div>
        <?php endif; ?>
    </div>
    <div>
        <h2><?= htmlspecialchars($product['nom']) ?></h2>
        <p class="text-muted" style="line-height:1.6;"><?= nl2br(htmlspecialchars($product['description'] ?? '')) ?></p>
        <div style="margin: 15px 0;">
            <strong class="price"><?= number_format((float)$product['prix'], 2, ',', ' ') ?> €</strong>
            <div class="text-muted" style="margin-top:5px;">Stock : <?= htmlspecialchars($product['stock']) ?></div>
        </div>
        <?php if (($product['stock'] ?? 0) > 0): ?>
            <form method="POST" action="/cart/add" class="gap-10">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                <label>Quantité</label>
                <input type="number" name="quantity" value="1" min="1" max="<?= htmlspecialchars($product['stock']) ?>" style="width:80px;">
                <button type="submit" class="btn btn-success">Ajouter au panier</button>
            </form>
        <?php else: ?>
            <p class="text-muted" style="color:#dc3545; font-weight:bold;">Rupture de stock</p>
        <?php endif; ?>
        <div class="mt-20">
            <a href="/products">← Retour aux produits</a>
        </div>
    </div>
</div>

