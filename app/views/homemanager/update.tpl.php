<form action="" method="POST" class="mt-5">
    <div class="row">
        <?php for ($numeroEmplacement = 1; $numeroEmplacement <=5; $numeroEmplacement++): ?>
        <div class="col">
            <div class="form-group">
                <label for="emplacement<?= $numeroEmplacement ?>">Emplacement #<?= $numeroEmplacement ?></label>
                <select class="form-control" id="emplacement<?= $numeroEmplacement ?>" name="emplacement[<?= $numeroEmplacement ?>]">
                    <option value="">choisissez :</option>
                    <?php foreach($allCategories as $category) : ?>
                        <option value="<?= $category->getId() ?>"
                        <?php 
                        // on met l'attribut selected si le home_order de la catégorie
                        // est celui de l'emplacement en cours
                            if ($category->getHomeOrder() == $numeroEmplacement) {
                                echo " selected ";
                            }
                        ?>
                        ><?= $category->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php endfor; ?>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>
