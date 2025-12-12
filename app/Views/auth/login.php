<div class="container" style="max-width: 420px;">
    <h2>Connexion</h2>
    <?php if (!empty($errors ?? [])): ?>
        <div class="message error">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/login">
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <div class="mt-20">
        <a href="/register">Créer un compte</a>
    </div>
</div>

