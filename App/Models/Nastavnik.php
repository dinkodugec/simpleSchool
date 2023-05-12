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



}