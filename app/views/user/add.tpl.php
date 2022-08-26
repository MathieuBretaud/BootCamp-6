<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter un utilisateur</h2>

<form action="<?= $router->generate('user-create') ?>" method="POST" class="mt-5">

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Adresse mail">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe (temporaire car l'utilisateur va devoir le changer)</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" 
            aria-describedby="passwordHelpBlock">
    </div>

    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" aria-describedby="firstnameHelpBlock">
    </div>

    <div class="form-group">
        <label for="lastname">Nom</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom" aria-describedby="lastnameHelpBlock">
    </div>
             
    <div class="form-group">
        <label for="role">Rôle</label>
        <select class="custom-select" id="role" name="role" aria-describedby="roleHelpBlock">
            <option value="catalog-manager">Catalog-manager</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="status">Statuts</label>
        <select class="custom-select" id="status" name="status" aria-describedby="statusHelpBlock">
            <option value="-1">-</option>
            <option value="1">Actif</option>
            <option value="2">Désactivé</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>