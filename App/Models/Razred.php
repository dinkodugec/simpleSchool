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

          /**
     * Get one razred in an associative array 
     *
     * @return array
     */

     public static function getOneRazred($id) 
    
        {
    

           try {
           $db = static::getInstance();

            $stmt = $db->prepare('SELECT id, naziv, nastavnik_id FROM razred
                               WHERE id = ?');
           $stmt->execute([$id]);
        
           $results = $stmt->fetch(PDO::FETCH_ASSOC);  //return values as associative array
          
           
            return $results;
            
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

      /**
     * Svi razredi s nastavnicima u njima
     *
     * @return array
     */
    public static function razredi()
    
      {

        $db = static::getInstance();

        $stmt = $db->query(

          "SELECT r.id, r.naziv, r.nastavnik_id, n.ime_prezime_nastavnik, n.email
                  FROM razred r 
                  inner join nastavnik n
                   on r.nastavnik_id=n.id");

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    
        return $results;
        
      }

        /**
     * Nastavnik u razredu
     *
     * @return array
     */
    public static function nastavnikURazredu($id)
    {

         /*  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);  */
     
           $db = static::getInstance();

            $stmt = $db->prepare("SELECT r.id, r.naziv, r.nastavnik_id, n.ime_prezime_nastavnik, n.email
            FROM razred r 
            inner join nastavnik n
             on r.nastavnik_id=n.id
             WHERE r.nastavnik_id = ?
             AND   r.nastavnik_id = n.id");

            $stmt->execute([$id]);
                      
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            return $results;

  
    }

    public static function obrisiRazred($id)
    {
        try {
            $db = static::getInstance();

             $stmt = $db->prepare("DELETE from razred WHERE id = ?");

             $results = $stmt->execute([$id]);

          return $results;


         } catch (\PDOException $e) {
             echo $e->getMessage();
         }

    }

            /**
     * Nastavnik u razredu via email like auth user is a techer also in sql query find by email
     *
     * @return array
     */
    public static function nastavnikURazreduViaEmail($emailNastavnik)
    {

         /*  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);  */
     
           $db = static::getInstance();

            $stmt = $db->prepare("SELECT r.id, r.naziv, r.nastavnik_id, n.ime_prezime_nastavnik, n.email
            FROM razred r 
            inner join nastavnik n
             on r.nastavnik_id=n.id
             WHERE n.email = ?
             AND   r.nastavnik_id = n.id");

            $stmt->execute([$emailNastavnik]);
                      
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            return $results;

  
    }



            
     





}