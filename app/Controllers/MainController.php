<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController {

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {

        // On récupère toutes les catégories de la home
        $categoryModel = new Category();
        $categories = $categoryModel->findAllHomepage();
        

        // On récupère tous les produits de la home
        $productModel = new Product();
        $products = $productModel->findAllHomepage();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', [
            "products" => $products,
            "categories" => $categories,
        ]);
    }
}
