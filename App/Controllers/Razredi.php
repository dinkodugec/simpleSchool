<?php

namespace App\Controllers;

use App\Models\Nastavnik;
use App\Models\Razred;
use App\Models\Student;
use \Core\View;


/**
 * Student controller
 */
class Razredi extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $razredi = Razred::getAll();
      /*    var_dump($razredi); 
        die(); */
 
        
        View::renderTemplate('Razred/index.html', [
           'razredi' => $razredi,
           
         ]); 

    }

        /**
     * Create razred
     *
     * @return void
     */
    public function CreateNewAction()
    {
        /*   var_dump($_POST); 
            die();    */
     
        $razredi = new Razred($_POST); 

      /*   var_dump($razredi);
        die(); */
     
        if($razredi->save()){
          View::renderTemplate('Admin/Dashboard.html' , [  
            'razredi' => $razredi
          ]);
          
        } else {
            View::renderTemplate('Admin/addNewClassRoom.html');
        }

    }
    /**
     * Show the razred page
     *
     * @return void
     */

     public function showRazredAction()
     {

      /* var_dump($_SESSION['user_email']); die();yy */

       $id = $_GET['id'];

       $email = $_GET['email'];
     
    
       $nastavnikURazredu = Razred::nastavnikURazredu($id);
     /*   var_dump($nastavnikURazredu);
       die(); */

       $studentiURazredu = Student::studentInRazred($id);
      /*  print_r($studentiURazredu);
       die();     */

  
       View::renderTemplate('Razred/studentsInRazred.html', [
         'studentiURazredu' => $studentiURazredu,
         'nastavnikURazredu' => $nastavnikURazredu
       ]);
    
     }

     public function deleteRazredAction()
     {
 
      $id = $_GET['id']; 
 
      $razred = Razred::getOneRazred($id);
 
      if($razred){
         Razred::obrisiRazred($id);
 
         View::renderTemplate('Admin/Students.html');
      }
 
 
 
     }



   

}