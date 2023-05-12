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

            $stmt = $db->query('SELECT id, naziv, nastavnik_id FROM razred');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        
            return $results;

  
    }

         /**
   * Save the razred 
   *
   * @return void
   */
  public function save()
  {

  /*   $this->validate(); */

 
        $naziv = $_POST['naziv'];
        $nastavnik_id = $_POST['nastavnik_id'];
        
   
        $sql = "INSERT INTO razred (naziv, nastavnik_id)
        VALUES (:naziv, :nastavnik_id)";

      $db = static::getInstance();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':naziv',  $naziv, PDO::PARAM_STR);
      $stmt->bindValue(':nastavnik_id', $nastavnik_id, PDO::PARAM_STR);
     

      $result = $stmt->execute();

      return $result;

   

   
 
 
    }
            
     





}