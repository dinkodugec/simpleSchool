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

         /**
   * Save the razred 
   *
   * @return void
   */
  public function save()
  {

  /*   $this->validate(); */

        $naziv = $_POST['naziv'];
        $ime_ucitelj = $_POST['ime_ucitelj'];
        $prezime_ucitelj = $_POST['prezime_ucitelj'];
   
        $sql = "INSERT INTO razred (naziv,ime_ucitelj,prezime_ucitelj)
        VALUES (:naziv, :ime_ucitelj, :prezime_ucitelj)";

      $db = static::getInstance();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':naziv',  $naziv, PDO::PARAM_STR);
      $stmt->bindValue(':ime_ucitelj', $ime_ucitelj, PDO::PARAM_STR);
      $stmt->bindValue(':prezime_ucitelj', $prezime_ucitelj, PDO::PARAM_STR);

      $result = $stmt->execute();

      return $result;

   

   
 
 
    }
            
     





}