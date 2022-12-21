<?php

namespace App\Models;

use PDO;

/**
 * Student model
 *
 * 
 */
class Student extends \Core\Model
{

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

            $stmt = $db->query('SELECT id, name, surname, image, imgPath, email FROM student');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       /*      $results = $stmt->fetch(PDO::FETCH_OBJ); */ //return object
         

            return $results;
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}