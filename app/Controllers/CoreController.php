<?php

namespace App\Controllers;

class CoreController {
    
    /**
     * méthode de construction, appellé lors du NEW
     */
    public function __construct($checkACL = true)
    {

        // contient toutes les informations de la route
        // demandé par l'utilisateur
        // il vient de la page index.php
        global $match;
        
        /* exemple de $match
        ^ array:3 [▼
            "target" => array:2 [▼
                "method" => "list"
                "controller" => "\App\Controllers\CategoryController"
            ]
            "params" => []
            "name" => "category-list"
            ]
        */
        
         // category-list
        $match["name"];
        
        if (!$checkACL) return;

        // controlleur : CategoryController
        // method : list
        // ['catalog-manager','admin'];
        $acl = [
            // 'main-home'=>[], // accessible à toute personne AUTHENTIFE
            'user-login'=>[], // accessible à toute personne même si pas AUTHENTIFE
            // 'user-logout'=>[], // accessible à toute personne AUTHENTIFE
            'category-list'=>['catalog-manager', 'admin']
        ];
        
        // si l'utilisateur viens de la route 'category-list'
        // je peut utiliser la reoute comme clé du tableau
        // pour récupérer les droits associés
        //$acl['category-list']
        //? $acl[$match["name"]];
        /* exemple d'acl
        ^ array:2 [▼
            0 => "catalog-manager"
            1 => "admin"
            ]
        */
        // ça renvoit VRAI si la clé existe
        if (array_key_exists($match["name"], $acl))
        {
            $rolesRequis = $acl[$match["name"]];
        }
        else{
            $rolesRequis = []; // comportement par défaut : si pas d'ACL explicite alors c'est ouvert
        }
        
        $this->checkAuthorization($rolesRequis);
        //$this->isConnected();
    }
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewVars Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewVars = []) {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewVars est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewVars['currentPage'] = $viewName; 

        // définir l'url absolue pour nos assets
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewVars, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewVars);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewVars est disponible dans chaque fichier de vue
        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    /**
     * Méthode de vérification des droits d'entrée 
     * @param array $rolesRequis
     */
    protected function checkAuthorization($rolesRequis = [])
    {
        // un tableau vide signifie que c'est accès libre (pas de rôle spécifique requis)
        if ($rolesRequis == []) return;

        // ok, il y a un/des rôles requis => seul un utilisateur *loggué* peut avoir un rôle,
        // donc on va d'abord vérifier si l'utilisateur est loggué (et si oui, on trouvera son rôle)
        $this->isConnected();

        // qu'est ce que je doit vérifier ?
        // je doit vérifier si le role de l'utilisateur via $_SESSION
        // correspond aux droitsRequis par le controller, donné en paramètre
        
        // je récupère mon user
        $user = $_SESSION['userObject'];

        // exemple : catalog-manager
        $roleUser = $user->getRole();

        // exemple : admin seulement
        
        /* regarde si le $roleUser existe dans le tableau $rolesRequis
        if (in_array($roleUser, $rolesRequis))
        {
            return true;
        }
        */
        // parcours les roles
        foreach ($rolesRequis as $role) 
        {
            if ($roleUser === $role){
                return true;
            }
        }

        // qu'est ce que je fait si l'utilisateur n'a pas les droits ?
        // header('Location: ' . $router->generate('main-home'));
        //exit();

        $errorController = new ErrorController(false);
        $errorController->err403();
        
        // http_response_code(403);
        // $this->show('error/err403');
        
        exit();

    }
    /**
     * Vérifier que la personne est connecté
     *
     * @return boolean
     */
    public static function isConnected()
    {
        // if (isset($_SESSION['userObject']))
        // {
        //     // la personne est connecté
        //     return true;
        // }
        // else 
        // {
        //     return false;
        // }
        //? on vire la gens qui ne sont pas authentifier
        if (!isset($_SESSION['userObject']))
        {
            global $router;
            // il est rentré par la fenètre ???
            header('Location: ' . $router->generate('user-login'));
            // dire à PHP qu'il peut s'arreter, qu'il n'a plus rien à faire.
            exit();
            // a la difference du die() qui lui tue le processus de PHP sauvagement
        }
    }
}
