<?php

namespace App\Controllers;

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
           'razredi' => $razredi
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

      $id = $_GET['id'];

      $studentiURazredu = Student::studentInRazred($id);

    /*     var_dump($studentiURazredu);
      die();  */ 
 
      View::renderTemplate('Razred/studentsInRazred.html', [
        'studentiURazredu' => $studentiURazredu
      ]);
   
      

      
    }


}