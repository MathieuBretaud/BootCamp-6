# Différence entre `bindValue` et `bindParam`

​
Rappel :
​
On utilisera une requête préparée dès lors qu'on a besoin, dans la requête SQL, d'utiliser une valeur saisie par l'utilisateur. Objectif : éviter les injections SQL !
​
![img](https://kourou.oclock.io/content/uploads/2020/11/query-exec-prepare.png)
​

## `bindValue`

​
[Documentation](https://www.php.net/manual/fr/pdostatement.bindvalue.php)
​
On relie notre token à la ***valeur*** de la variable utilisée dans `bindValue()`, au moment où elle est utilisée.
​
Par conséquent, si elle est modifiée par la suite, ça n'a pas d'impact sur la requête SQL réellement exécutée.
​
Ex :
​

```php
$email = 'toto@oclock.io'; // on déclare $email
$sql = 'SELECT * FROM `app_user` WHERE `email` = :email';
$pdoStatement = $pdo->prepare($sql);
$pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
$email = 'tata@oclock.io'; // on modifie $email
$pdoStatement->execute();
// ici, on exécute "SELECT * FROM `app_user` WHERE `email` = 'toto@oclock.io'"
// la modification de $email n'a eu aucun impact
```

## `bindParam`

​
[Documentation](https://www.php.net/manual/fr/pdostatement.bindparam.php)
​
Cette fois-ci, c'est la variable qu'on associe au token. La conséquence, c'est que si la valeur de cette variable est modifiée avant l'appel à la méthode `PDOStatement::execute()`, cela aura un impact sur la requête réellement exécutée.
​
Ex :
​

```php
$email = 'toto@oclock.io'; // on déclare $email
$sql = 'SELECT * FROM `app_user` WHERE `email` = :email';
$pdoStatement = $pdo->prepare($sql);
$pdoStatement->bindParam(':email', $email, PDO::PARAM_STR);
$email = 'tata@oclock.io'; // on modifie $email
$pdoStatement->execute();
// ici, on exécute "SELECT * FROM `app_user` WHERE `email` = 'tata@oclock.io'"
```
