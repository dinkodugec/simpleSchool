<?php

namespace App\Models;

use PDO;
use PDOException;

class Predmet extends \Core\Model
{

    /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data)
  {
    foreach ($data as $key => $value) {      
      $this->$key = $value;
    };

  }

   /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $host = 'localhost';
        $dbname = 'skola';
        $username = 'root';
        $password = '';
    
        try {
           /*  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                          $username, $password); */

           $db = static::getInstance();

            $stmt = $db->query('SELECT id, naziv, ocjena, student_id FROM predmet');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       /*      $results = $stmt->fetch(PDO::FETCH_OBJ); */ //return object
         

            return $results;
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

}