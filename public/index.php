<?php

// POINT D'ENTRÉE UNIQUE : 
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

// on démarre la session pour permettre la connexion utilisteur
session_start();

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va 
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
}
// sinon
else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter, afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);
//==============================
// PRODUCT
//==============================

// Liste des produits
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

// Ajout produit
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);
// modification en base
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-create'
);
// affichage de la modification
$router->map(
    'GET',
    // pour démontrer le changement d'environnement
    // on nomme la variable différement de celle de la function 'edit'
    '/product/update/[i:productId]', 
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-edit'
);
// modification en base
$router->map(
    'POST',
    '/product/update/[i:productId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-update'
);


//==============================
// CATEGORY
//==============================

// Liste des categories
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

// Ajout catégorie
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add'
);
// Route de création de catégorie
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-create'
);
// affichage de la modification
$router->map(
    'GET',
    // pour démontrer le changement d'environnement
    // on nomme la variable différement de celle de la function 'edit'
    '/category/update/[i:tagada]', 
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-edit'
);
// modification en base
$router->map(
    'POST',
    '/category/update/[i:categoryId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update'
);
$router->map(
    'GET',
    '/category/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-delete'
);
/* -------------
---   USER   ---
--------------*/
$router->map(
    'GET',
    '/user/login', // connexion
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login'
);
// reception du formulaire
$router->map(
    'POST',
    '/user/login',
    [
        'method' => 'connect',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-connect'
);
// déconnexion
$router->map(
    'GET',
    '/user/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-logout'
);
// liste
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-list'
);
// formulaire d'ajout
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add'
);
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-create'
);

$router->map(
    'GET',
    '/homemanager/update',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\HomeManagerController'
    ],
    'home-manager-update'
);
$router->map(
    'POST',
    '/homemanager/update',
    [
        'method' => 'modify',
        'controller' => '\App\Controllers\HomeManagerController'
    ],
    'home-manager-modify'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();
//dd($match);

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();