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

    
     /**
   * Save the predmet  with the current property values
   *
   * @return void
   */
  public function save()
  {

  /*   $this->validate(); */


         
        $student_id =$_POST['id'];
        $naziv = $_POST['naziv'];
        $ocjena = $_POST['ocjena'];
        $ocjena_naziv = $_POST['ocjena_naziv'];
   
        $sql = "INSERT INTO predmet (naziv,ocjena,ocjena_naziv,student_id)
        VALUES (?,?,?,?)";

      $db = static::getInstance();
      $stmt = $db->prepare($sql);

      $result =  $stmt->execute([$naziv, $ocjena, $ocjena_naziv, $student_id]);

      var_dump($result);
      die();

      return $result;
   
 
 
    }

    
    public static function getPredmetByStudentId($student_id)
    {

          $db = static::getInstance();

          $stmt = $db->prepare('SELECT id, naziv, ocjena, ocjena_naziv, student_id FROM predmet WHERE 
          student_id = ?');

           $stmt ->execute([$student_id]);

           /* $results = $stmt->fetchAll(PDO::FETCH_OBJ); here is object*/
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         /*    var_dump($results);
           die;  */

          return $results;

    }

 

}