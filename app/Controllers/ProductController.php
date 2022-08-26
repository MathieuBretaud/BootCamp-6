<?php

namespace App\Controllers;

use App\Models\Product;

/**
 * Controller dédié à l'affichage des produits.
 */
class ProductController extends CoreController {

    /**
     * Liste des produits
     *
     * @return void
     */
    public function list()
    {
        // on définit les roles qui ont le droit d'être là
        $rolesRequis[] = 'catalog-manager';
        $rolesRequis[] = 'admin';
        // pas besoin de tester le retour de la fonction
        // car elle vire les gens si c'est pas bon.
        $this->checkAuthorization($rolesRequis);
        
        // On récupère tous les produits
        $productModel = new Product();
        $products = $productModel->findAll();
        
        // On les envoie à la vue
        $this->show('product/list', [
            "products" => $products
        ]);
    }


    /**
     * Ajout d'un produit.
     *
     * @return void
     */
    public function add()
    {
        $this->show('product/add');
    }

    public function create()
    {
        // je dois récuperer les données dans $_POST
        // 1ere solution : $name = $_POST['name']
        // 2eme solution : $name = filter_input(INPUT_POST, 'name');
        // 3eme solution : $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
        //var_dump($_POST['brand']);
        $brand_id = filter_input(INPUT_POST, 'brand', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);

        // je creer un nouveau Model
        $nouveauProduit = new Product();
        $nouveauProduit->setName($name);
        $nouveauProduit->setDescription($description);
        $nouveauProduit->setPicture($picture);
        $nouveauProduit->setPrice($price);
        $nouveauProduit->setRate($rate);
        $nouveauProduit->setStatus($status);
        $nouveauProduit->setCategoryId($category_id);
        // var_dump($brand_id)
        $nouveauProduit->setBrandId($brand_id);
        $nouveauProduit->setTypeId($type_id);
        
        // on insere en base de données
        $nouveauProduit->insert();

        // redirige sur le HOME
        // header('Location: /');
        // utilise le routeur, mais utiliser aussi global :'(
        global $router;
        header('Location: '. $router->generate('product-list'));
    }
    /**
    * affiche le formulaire d'édition
    *
    * @param int $productId Identifiant du produit à modifier
    */
    public function edit(int $productId)
    {
        // où est mon ID ?
        // $productId doit être fournit par la route
        // dd($productId);

        // aller chercher le Product en base
        /**
         * Avant le static on faisait 
         * $productModel = new Product();
         * $productAModifier = $productModel->find($productId);
         */
        $productAModifier = Product::find($productId);
        //dd($productAModifier);
        $monTableauDeVariable['product'] = $productAModifier;
        // afficher le formulaire
        $this->show('product/edit', $monTableauDeVariable);
    }
    /**
    * Mets à jour les données en base
    */
    public function update($productId)
    {
        // où est mon ID ? 
        // il est fournit par la route : $productId

        // 1ere solution :
        // $productAModifier = new Product();
        // $productAModifier->setName($name);

        // 2eme solution :
        // on récupère les dernières infos à jour
        // $productAModifier = Product::find($productId);
        // $productAModifier->setName($name);
        
        $productAModifier = Product::find($productId);
        
        // récuperer les données de $_POST : filter_input()
        // on utilise le filter_input pour empecher les margoulins
        // de faire nawak avec notre BDD

        //? on assaini les données avec SANITIZE
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        
        //? on utilise le VALIDATE car on valide la construction de l'URL
        $picture  = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);

        //? on utilise le VALIDATE car on valide le type de données
        //? pas de besoin de l'assainir car on ne peut pas faire nawak avec, contrairement aux chaines de caractères
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

        // on récupère les données du form et on les modifie avec setName, etc !!
        $productAModifier->setName($name);
        $productAModifier->setDescription($description);
        $productAModifier->setPicture($picture);
        $productAModifier->setPrice($price);
        $productAModifier->setRate($rate);
        $productAModifier->setStatus($status);
        $productAModifier->setBrandId($brand_id);
        $productAModifier->setCategoryId($category_id);
        $productAModifier->setTypeId($type_id);

        // mettre à jour la base
        $productAModifier->update();

        // Rediriger vers le formulaire de mise à jour
        // utilise le routeur, mais utiliser aussi global :'(
        global $router;
        // en regardant la documentation de AlotRouteur on peut voir
        // que le generate peut prendre des paramètres supplémentaires
        // tel que l'ID de notre route

        //dd($router->generate('product-edit',["productId" => $productId]));
        
        header('Location: '. $router->generate('product-edit',
                                 ["productId" => $productAModifier->getId()]));
    }
}
