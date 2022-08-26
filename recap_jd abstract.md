
# clarification vocabulaire : (Abstract)

- Model => une classe PHP qui représente / correspond à  une table de la BDD
- modèle => une classe PHP qui " sert de modèle " (de base) à  d'autres classes, via le système d'héritage => ```abstract``` permet de clarifier que telle ou telle classe PHP se comporte comme un modèle pour d'autres classes PHP
on parle aussi de contrat pour éviter de dire modèle, vu que à§a prête à  confusion
(pourquoi *abstract* ? parce qu'une classe marquée ```abstract``` ne pourra pas être instanciée, donc on ne pourra jamais en récupérer des instances/objets " concrets "â€¦ la classe reste " abstraite " quoi, et il faut en hériter pour *in fine* pouvoir la concrétiser)
EX : @Alex on pourrait dire que toi, tu es une instance bien concrète de la classe ```Alexandre```, classe qui hériterait de la classe " abstraite " ```EtreHumain``` => on ne peut pas instancier un ```EtreHumain``` directement, il faut passer par des classes spécialisées telle que la classe ```Alexandre```
c'est un choix, arbitraire
Autre EX : C'est un peu comme quand tu pars en colonie de vacances : ```abstract public function dentifrice();``` => il faut ramener votre dentifrice, peu importe lequel !
Aucun rapport à  la base entre CRUD et ```abstract``` => ```abstract``` c'est un outil de PHP, alors que CRUD c'est une approche de développement pour faire des applications web â€” il se trouve qu'ici vous utilisez les deux notions ensemble, mais c'est un cas particulier arbitraire.
De DADA : tu dis à  tes enfants, ```tu vas t'habiller en tshirt rouge avec pantalon bleu``` et s'ils essaient de sortir avec autre chose que à§a, bah tu fermes la porte !

## Définition :
- factoriser : j'ai plusieurs classes qui font la même chose (code dupliqué à  l'identique) => je peux mettre ce quelque chose dans une classe parente
- ```abstract``` : j'ai besoin que plusieurs classes fassent presque la même chose, mais avec à  chaque fois du code différent quand même => je définis une méthode abstraite dans la classe parente, et les classes enfants qui en héritent fournissent les implémentations