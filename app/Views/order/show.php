<div class="container" style="max-width: 900px;">
    <h2>Commande #<?= htmlspecialchars($order['id']) ?></h2>
    <p>Total : <strong><?= number_format((float)$order['total'], 2, ',', ' ') ?> €</strong></p>
    <p>Statut : <?= htmlspecialchars($order['statut']) ?></p>

    <h3>Articles</h3>
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nom']) ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($item['quantite']) ?></td>
                    <td style="text-align:right;"><?= number_format((float)$item['prix_unitaire'], 2, ',', ' ') ?> €</td>
                    <td style="text-align:right;"><?= number_format((float)$item['prix_unitaire'] * $item['quantite'], 2, ',', ' ') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="mt-20">
        <a href="/orders">← Retour aux commandes</a>
    </div>
</div>

