# les recap de JD

## viewVars ?

- ```$viewVars``` : une variable dont la valeur est un tableau, cool on peut y stocker des infos (clé/valeur)…
- ```extract($viewVars)``` : une petite astuce de confort, pour se créer rapidos des variables précises en fonction des clés (c'est optionnel mais c'est joli)
- ```$viewVars``` est donc un « moyen de transport », ce qu'on met dedans c'est libre : des nombres, des chaînes de caractères, des booléens… des objets, why not!

## dans MainController#home, on a mis en place la logique suivante : 

1. je me demande ce que je veux afficher => tiens, pourquoi pas le nom d'un produit d'id ?!
2. il me faut donc récupérer les infos de ce produit => ça c'est le taf du modèle ```Product``` => c'est une classe, je l'instancie (et récupère donc un objet, « vide ») et j'utilise sa méthode ```find``` et ça me retourne une valeur bien concrète, à savoir un objet (== une autre instance de ```Product```, mais remplie avec des informations à propos du produit trouvé, cette fois)
3. cet objet qui représente, en PHP, les infos venant de la BDD MySQL, je le stocke dans une variable…
4. … ce qui me permet de manipuler comme je veux cet objet. En l'occurrence, je souhaite le fournir à la vue (home.tpl.php). Pour ce faire, j'utilise le mécanisme de transport intégré à la méthode ```show``` : ```$viewVars``` !
4bis. la méthode ```show``` est dispo dans MainController#home parce que MainController hérite de CoreController, qui lui possède la méthode ```show``` => c'est un outil que j'ai donc à disposition, je l'utilise (correctement). 

## Utiliser un serveur WEB

Lancer un serveur web gérer par PHP et non par APACHE, ce qui permet d'avoir une URL propre (ou si nous ne disposons pas de serveur APACHE)

```bash
php -S 0.0.0.0:8080 -t public
```

(Les zéros sont à changer en fonction de l'URL de la personne)

DE JD : pour faire simple (== je mens un peu en disant ça, mais osef) 0.0.0.0 est équivalent à localhost, qui est équivalent à 127.0.0.1

## Pourquoi ?

1. je suis dans mon contrôleur, j'ai besoin/envie de transmettre une info à ma vue
2. c'est la méthode ```show()``` qui déclenche l'affichage de la vue, donc c'est à cette méthode que je vais transmettre mon info en fait 
3. pour ce faire, vu que ```show()``` est techniquement une fonction, ben je vais lui envoyer mon info en argument 
4. petite subtilité : comme il est probable que j'ai besoin/envie d'envoyer plusieurs info, et bien je vais plutôt passer un tableau d'infos en argument 
5. la méthode ```show``` réceptionne ce tableau d'info et le met dans sa variable interne ```$viewVars``` (parce que.)
6. petite subtilité : on a posé comme convention que ce tableau est un tableau associatif, ie. il y a des clés explicites => ah cool, ```extract()``` permet de générer des variables à partir de ces clés !
7. et tout ça devient accessible dans la vue, puisque ```show()``` s'occupe de le require (== l'afficher)

En fait on passe autant d'infos qu'on veut, c'est ouf la gratuité totale !

Et ici, dans la vue, on récupérera ```$infosupplementaire``` automatiquement, « magique » (non, ```extract```)

## petit résumé sauvage, en terme de données qui circulent dans l'application :

1. dans le ```CategoryController```, on a récupéré un *tableau d'instances de la classe ```Category```* (grâce à la méthode statique ```Category::findAll()```) — on a mis ce tableau d'instances dans la variable ```$listeModel```
2. pour transmettre ce tableau d'instances à la vue, on a utilisé un autre tableau, ```$tableauDeVariable```. On y a mis une clé ```"maPinte"``` (qu'on pourrait renommer désormais) => *cette clé ```"maPinte"``` contient comme valeur le tableau d'instances de la classe ```Category```*
3. on a envoyé ce tableau de données ```$tableauDeVariable``` en argument à la méthode ```CoreController#show``` 
4. la méthode ```show``` réceptionne ce tableau d'infos, ```extract``` ses valeurs dans des variables en se basant sur le nom des clés, et met tout ça à disposition de la vue
5. dans la vue, on a réalisé un ```foreach``` sur ```$maPinte```, variable qui contient le tableau d'instances de la classe ```Category```
