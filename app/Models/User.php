<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class User extends CoreModel
{
    /*
email	varchar(128)
password	varchar(60)
firstname	varchar(64) NULL
lastname	varchar(64) NULL
role	enum('admin','catalog-manager')
status	tinyint(3) unsigned [0]	1 => actif 2 => désactivé/bloqué
    */

    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $role;
    private $status;
    
    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstname = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastname = $lastName;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
    * /!\ implémentation par défault à cause du abstract
    * /!\ NE FAIT RIEN !!!
    */
    public static function find(int $id)
    {
        // ne fait rien mais est obligatoire pour implémenter 
        // la classe abstraite (abstract)
    }

    /**
     * Nous permet d'aller chercher l'utilisateur en base de donnée
     * à partir de son email
     *
     * @param string $email
     */
    public static function findByEmail($email)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        //? attention aux emojis :email: :D
        $sql = 'SELECT * FROM `app_user` WHERE `email` = :email';

        // exécuter notre requête
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        // $pdoStatement->bindParam(':email', $email, PDO::PARAM_STR);

        // VRAI si la requete c'est bien passé
        $requeteOk = $pdoStatement->execute();

        if ($requeteOk){
            // un seul résultat => fetchObject
            // Créer moi un objet à partir du résultat de la requete
            // que tu as précedement execute()
            $user = $pdoStatement->fetchObject('App\Models\User');
            // retourner le résultat
            return $user;
        }
        else {
            return false;
        }
    }
    /**
     * Récuperer la liste des utilisateurs
     */
    public static function findAll()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        $sql = "SELECT * FROM `app_user`";

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\User');
        
        return $results;
    }

    public function insert()
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // la requete que l'on a prit de adminer
        // on a enlevé created_at car la valeur par defaut nous convient
        // on a enlevé updated_at car la valeur par défaut est NULL et que ça nous convient
        $sql = '
        INSERT INTO `app_user` 
            (`email`, 
            `password`,
            `firstname`,
            `lastname`,
            `role`,
            `status`
            )
        VALUES (
            :email,
            :password,
            :firstname ,
            :lastname,
            :role, 
            :status
            );
        ';

        // On ne fait pas confiance au donnée d'un formulaire
        // on fait donc un prépare
        // avec les placeholder dans la requete
        $pdoStatement = $pdo->prepare($sql);
        
        // comme on a preparer la requete
        // on doit maintenant donner les valeurs à mettre à la place
        // des placeholder
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);

        // notre requete est prête, on a remplit tout les placeholder
        // on execute
        $requeteOk = $pdoStatement->execute();
        
        // on renvoit la valeur VRAI si tout c'est bien passé
        return $requeteOk;
    }
}