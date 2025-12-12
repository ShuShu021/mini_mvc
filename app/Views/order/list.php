<div class="container" style="max-width: 900px;">
    <h2>Mes commandes</h2>
    <?php if (empty($orders)): ?>
        <p>Aucune commande pour le moment.</p>
        <a href="/products">Parcourir les produits</a>
    <?php else: ?>
        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= number_format((float)$order['total'], 2, ',', ' ') ?> €</td>
                        <td><?= htmlspecialchars($order['statut']) ?></td>
                        <td><a href="/orders/<?= htmlspecialchars($order['id']) ?>">Détails</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

