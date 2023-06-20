<?php

namespace App\Models;

use PDO;

class Nastavnik extends \Core\Model

{

  /**
     * Get all the nastavnici as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
            
     
           $db = static::getInstance();

            $stmt = $db->query('SELECT id, ime_prezime_nastavnik, datum_rodenja, email FROM nastavnik');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        
            return $results;

  
    }

           /**
     * Get one nastavnik
     *
     * @return array
     */

     public static function getOneNastavnik($id) 
    
        {
    

           try {
           $db = static::getInstance();

            $stmt = $db->prepare('SELECT id, ime_prezime_nastavnik, datum_rodenja, email FROM nastavnik
                               WHERE id = ?');
           $stmt->execute([$id]);
        
           $results = $stmt->fetch(PDO::FETCH_ASSOC);  //return values as associative array
          
           
            return $results;

           
            
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

      /**
     * Obrisi Nastavnika
     */

    public static function obrisiNastavnika($id)
    {
        try {
            $db = static::getInstance();
 
             $stmt = $db->prepare("DELETE from nastavnik WHERE id = ?");
                                   
             $results = $stmt->execute([$id]);
         
          return $results;

             
         } catch (\PDOException $e) {
             echo $e->getMessage();
         }
        
    }



}