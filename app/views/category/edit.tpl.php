<a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modifier une catégorie: <?= $categorie->getName() ?></h2>
<?php
/**
 * Ici on fabrique la route, puis on lui ajoute "à la main" l'Id de notre catégorie
 * pour obtenir une route qui "match"
 */
?>
<form action="<?= $router->generate('category-update') ?><?= $categorie->getId() ?>" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Nom de la catégorie"
        value="<?= $categorie->getName() ?>"
        >
    </div>
    <div class="form-group">
        <label for="subtitle">Sous-titre</label>
        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Sous-titre" 
        value="<?= $categorie->getSubtitle() ?>" aria-describedby="subtitleHelpBlock">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            Sera affiché sur la page d'accueil comme bouton devant l'image
        </small>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" value="<?= $categorie->getPicture() ?>" aria-describedby="pictureHelpBlock">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>