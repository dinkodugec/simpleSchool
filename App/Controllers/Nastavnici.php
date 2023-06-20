<?php

namespace App\Controllers;

use App\Models\Nastavnik;
use Core\View;

class Nastavnici extends \Core\Controller

{




  public function deleteNastavnikAction()
  {

   $id = $_GET['id']; 
   
   $nastavnik = Nastavnik::getOneNastavnik($id);
 /*    var_dump($nastavnik); die(); */

   if($nastavnik){
      Nastavnik::obrisiNastavnika($id);
      
      View::renderTemplate('Admin/Dashboard.html');
   }



  }

              /**
     * Napravi novog nastavnika
     *
     * @return void
     */
    public function createAction()
    {
      /*  var_dump($_POST);  */
   
       $nastavnik = new Nastavnik($_POST); //passing arguments like this will, when you creating new object will invoke __construct

    
   /*     echo "<pre>"; 
       var_dump($nastavnik);
      echo "</pre>";  */

       if($nastavnik->saveNastavnik()) {

     
          $this->redirect('/public/index.php?admin/dashboard/index'); 

       } /* else{

        View::renderTemplate('/');  

       } */

    }





}