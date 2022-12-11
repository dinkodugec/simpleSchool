<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * 
 */
class Student
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
            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                          $username, $password);

            $stmt = $db->query('SELECT id, name, surname, image, imgPath, email FROM student');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         

            return $results;
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}