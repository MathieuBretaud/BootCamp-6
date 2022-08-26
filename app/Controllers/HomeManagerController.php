<?php

namespace App\Controllers;

use App\Models\Category;

class HomeManagerController extends CoreController {

    /**
     * affichage du formulaire
     */
    public function update()
    {
        // pour dynamiser, récup des donnée mise à jour
        $categoriesHomePage = Category::findAllHomepage();

        // on donne notre liste au tableau de donnée pour la vue
        $tableauDeVariablePourLavue['categoriesHomePage'] = $categoriesHomePage;
        //dd($categoriesHomePage);

        // je récupère toute mes catégories
        // pour dynamiser mes listes déroulantes
        $allCategories = Category::findAll();

        // on donne notre liste au tableau de donnée pour la vue
        $tableauDeVariablePourLavue['allCategories'] = $allCategories;
        
        // affichage formulaire GET
        $this->show('homemanager/update', $tableauDeVariablePourLavue);
    }

    public function modify()
    {
        // récup du $_POST
        $listeEmplacement = $_POST['emplacement'];
        /* exemple : 
        $numeroEmplacement => $categoryId
                         1 => string '1' (length=1)
                         2 => string '2' (length=1)
                         3 => string '4' (length=1)
                         4 => string '5' (length=1)
                         5 => string '3' (length=1)
        */

        // mise à jour BDD
        // Category::updateAllHomeOrder( $listeEmplacement);

        /**
         * je veux faire table raze de tout les home_order
         * pour ne pas avoir de doublon dans la base
         * 
         * Je fais la version rapido de vendredi
         * 
         * je prend toutes les catégorie une à une 
         * et je leur met un home_order à 0
         */
        $allCategory = Category::findAll();
        foreach ($allCategory as $category)
        {
            $category->setHomeOrder(0);
            $category->update();
        }

        foreach($listeEmplacement as $numeroEmplacement => $categoryId)
        {
            //echo "numéro emplacement : ".$numeroEmplacement." / ID : ".$categoryId;
            $categorieAMettreAJour = Category::find($categoryId);

            // pas besoin de mettre +1 sur le numéro d'emplacement
            // merci à Armand :)
            // ça rime donc c'est vrai :D
            $categorieAMettreAJour->setHomeOrder($numeroEmplacement);
            
            // Mise à jour en BDD
            $categorieAMettreAJour->update();
        }
        
        // pour réutiliser la  dynamisation
        // on va relancer la function update()
        // qui affiche bien tout notre formulaire
        // $this->update();
        // OU
        // on redirige l'utilisateur sur la route d'affichage
        /// utilise le routeur, mais utiliser aussi global :'(
        global $router;
        

        header('Location: '. $router->generate('home-manager-update'));
    }
}