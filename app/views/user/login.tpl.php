<!-- On pourrait mettre le header sans la navigation ICI -->
<h2>Page de connexion</h2>

<form action="<?= $router->generate('user-connect') ?>" method="POST" class="mt-5">
    <div class="form-group">
        <label for="email">email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="votre email">
    </div>
    <div class="form-group">
        <label for="password">mot de passe</label>
        <input type="password" class="form-control" name="password"  id="password" placeholder="mot de passe">
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>