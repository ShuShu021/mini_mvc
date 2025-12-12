<div class="container" style="max-width: 900px;">
    <h2>Votre panier</h2>
    <?php if (empty($items)): ?>
        <p>Le panier est vide.</p>
        <a href="/products">← Continuer mes achats</a>
    <?php else: ?>
        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Qté</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product']['nom']) ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($item['quantity']) ?></td>
                        <td style="text-align:right;"><?= number_format((float)$item['product']['prix'], 2, ',', ' ') ?> €</td>
                        <td style="text-align:right;"><?= number_format((float)$item['line_total'], 2, ',', ' ') ?> €</td>
                        <td style="text-align:center;">
                            <form method="POST" action="/cart/remove">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['product']['id']) ?>">
                                <button type="submit" class="btn btn-danger">Retirer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="gap-10" style="margin-top:20px; justify-content: space-between; align-items:center;">
            <form method="POST" action="/cart/clear">
                <button type="submit" class="btn btn-secondary">Vider le panier</button>
            </form>
            <div style="font-size:20px;"><strong>Total : <?= number_format((float)$total, 2, ',', ' ') ?> €</strong></div>
        </div>
        <div class="gap-10 mt-20">
            <a href="/products" class="btn btn-outline">← Continuer mes achats</a>
            <?php if ($user): ?>
                <form method="POST" action="/checkout">
                    <button type="submit" class="btn btn-success">Valider la commande</button>
                </form>
            <?php else: ?>
                <a href="/login" class="btn btn-primary" style="background:#ffc107; color:#343a40; border-color:#ffc107;">Se connecter pour payer</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

