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




}