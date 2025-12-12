<div class="container" style="max-width: 520px;">
    <h2>Créer un compte</h2>
    <?php if (!empty($errors ?? [])): ?>
        <div class="message error">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/register">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input id="nom" name="nom" type="text" required value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required minlength="6">
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input id="password_confirm" name="password_confirm" type="password" required minlength="6">
        </div>
        <button type="submit" class="btn btn-primary">Créer mon compte</button>
    </form>
    <div class="mt-20">
        <a href="/login">Déjà un compte ? Connexion</a>
    </div>
</div>

