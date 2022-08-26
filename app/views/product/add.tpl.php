<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter une catégorie</h2>

<form action="<?= $router->generate('product-add') ?>" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Sous-titre" 
            aria-describedby="descriptionHelpBlock">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            La description du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur 
            <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="price">Prix</label>
        <input type="number" step="0.01" class="form-control" id="price"  name="price" placeholder="Prix" 
            aria-describedby="priceHelpBlock">
        <small id="priceHelpBlock" class="form-text text-muted">
            Le prix du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="rate">Note</label>
        <input type="text" class="form-control" id="rate" name="rate" placeholder="Note" 
            aria-describedby="rateHelpBlock">
        <small id="rateHelpBlock" class="form-text text-muted">
            Le note du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="status">Statut</label>
        <select class="custom-select" id="status" name="status" aria-describedby="statusHelpBlock">
            <option value="0">Inactif</option>
            <option value="1">Actif</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="category">Categorie</label>
        <select class="custom-select" id="category" name="category" aria-describedby="categoryHelpBlock">
            <option value="1">Détente</option>
            <option value="2">Au travail</option>
            <option value="3">Cérémonie</option>
        </select>
        <small id="categoryHelpBlock" class="form-text text-muted">
            La catégorie du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="brand">Marque</label>
        <select  class="custom-select" id="brand" name="brand" aria-describedby="brandHelpBlock">
            <option value="1">oCirage</option>
            <option value="2">BOOTstrap</option>
            <option value="3">Talonette</option>
        </select>
        <small id="brandHelpBlock" class="form-text text-muted">
            La marque du produit 
        </small>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <select class="custom-select" id="type" name="type" aria-describedby="typeHelpBlock">
            <option value="1">Chaussures de ville</option>
            <option value="2">Chaussures de sport</option>
            <option value="3">Tongs</option>
        </select>
        <small id="typeHelpBlock" class="form-text text-muted">
            Le type de produit 
        </small>
    </div>
    
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>