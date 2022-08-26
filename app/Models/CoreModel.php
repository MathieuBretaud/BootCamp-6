<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
abstract class CoreModel {
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    /**
     * Contrat Abstract
     * doit avoir une méthode find()
     * doit avoir une méthode findAll()
     * doit avoir une méthode insert()
     * doit avoir une méthode update()
     * doit avoir une méthode delete()
     */

     /**
      * méthode à implémenter pour faire une recherche par ID
      *
      * @param integer $id
      */
      abstract public static function find(int $id);
      //abstract public function delete();

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */ 
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */ 
    public function getUpdatedAt() : string
    {
        if($this->updated_at === null)
        {
            return "";
        }
        
        return $this->updated_at;
    }
}
