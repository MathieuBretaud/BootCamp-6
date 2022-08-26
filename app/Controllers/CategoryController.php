<?php

namespace App\Controllers;

use App\Models\Category;

/**
 * Controller dédié à l'affichage des catégories.
 */
class CategoryController extends CoreController {

    /**
     * Liste des catégories.
     *
     * @return void
     */
    public function list()
    {
        // On récupère toutes les catégories
        $categories = Category::findAll();
                    
        // On les envoie à la vue
        $this->show('category/list', [
            "categories" => $categories
        ]);
    }

    /**
     * Ajout d'une catégorie.
     *
     * @return void
     */
    public function add()
    {
        // on définit les roles qui ont le droit d'être là
        $rolesRequis[] = 'catalog-manager';
        $rolesRequis[] = 'admin';
        // pas besoin de tester le retour de la fonction
        // car elle vire les gens si c'est pas bon.
        $this->checkAuthorization($rolesRequis);

        $this->show('category/add');
    }
    /**
     * Création d'une catégorie
     * 
     * @return void
     */
    public function create()
    {
        // on définit les roles qui ont le droit d'être là
        $rolesRequis[] = 'catalog-manager';
        $rolesRequis[] = 'admin';
        // pas besoin de tester le retour de la fonction 
        // car elle vire les gens si c'est pas bon.
        $this->checkAuthorization($rolesRequis);

        // je dois récuperer les données dans $_POST
        // 1ere solution : $name = $_POST['name']
        // 2eme solution : $name = filter_input(INPUT_POST, 'name');
        // 3eme solution : $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture',FILTER_SANITIZE_URL);

        // je dois créer un nouveau model et lui donner les infos
        $nouvelleCategory = new Category();
        $nouvelleCategory->setName($name);
        $nouvelleCategory->setSubtitle($subtitle);
        $nouvelleCategory->setPicture($picture);

        // je dois inserer mon model en base
        $nouvelleCategory->insert();

        //dd($_POST);
        // redirige sur la liste des catégorie
        // utilise le routeur, mais utiliser aussi global :'(
        global $router;
        

        header('Location: '. $router->generate('category-list'));
    }
    /**
    * affiche le fomulaire d'édition
    *
    * @param int $categoryId Identifiant de la catégorie à modifier
    */
    public function edit(int $categoryId)
    {
        // où est mon ID ?
        // $categoryId doit être fournit par la route
        // dd($categoryId);

        // aller chercher la catégorie en base
        /**
         * Avant le static on faisait 
         * $categoryModel = new Category();
         * $categorieAModifier = $categoryModel->find($categoryId);
         */
        $categorieAModifier = Category::find($categoryId);

        $monTableauDeVariable['categorie'] = $categorieAModifier;
        // afficher le formulaire
        $this->show('category/edit', $monTableauDeVariable);
    }
    /**
    * Mets à jour les données en base
    */
    public function update($categoryId)
    {
        // où est mon ID ? 
        // il est fournit par la route : $categoryId

        // 1ere solution :
        // $categorieAModifier = new Category();
        // $categorieAModifier->setName($name);

        // 2eme solution :
        // on récupère les dernières infos à jour
        // $categorieAModifier = Category::find($categoryId);
        // $categorieAModifier->setName($name);
        
        $categorieAModifier = Category::find($categoryId);
        
        // récuperer les données de $_POST : filter_input()
        // on utilise le filter_input pour empecher les margoulins
        // de faire nawak avec notre BDD

        //? on assaini les données avec SANITIZE
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);

        //? on utilise le VALIDATE car on valide la construction de l'URL
        $picture  = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);

        // on récupère les données du form et on les modifie avec setName, etc !!
        $categorieAModifier->setName($name);
        $categorieAModifier->setSubtitle($subtitle);
        $categorieAModifier->setPicture($picture);

        // mettre à jour la base
        $categorieAModifier->update();

        // Rediriger vers le formulaire de mise à jour
        // utilise le routeur, mais utiliser aussi global :'(
        global $router;
        // en regardant la documentation de AlotRouteur on peut voir
        // que le generate peut prendre des paramètres supplémentaires
        // tel que l'ID de notre route

        //dd($router->generate('category-edit',["tagada" => $categoryId]));
        
        header('Location: '. $router->generate('category-edit',
                                 ["tagada" => $categorieAModifier->getId()]));
    }

    public function delete($categoryId) {
        global $router;
        $category = Category::find($categoryId);

        if ($category) {
            $category->delete();
            header("Location: {$router->generate('category-list')}");
        } else {
            http_response_code(404);
        }
    }
}
