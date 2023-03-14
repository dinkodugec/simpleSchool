<?php

namespace App\Models;

use PDO;

class Razred extends \Core\Model

{

  /**
     * Get all the razredi as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
            
     
           $db = static::getInstance();

            $stmt = $db->query('SELECT id, naziv, ime_ucitelj, prezime_ucitelj FROM razred');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        
            return $results;

  
    }
            
     





}