<?php

namespace App\Controllers\Admin;

use App\Models\Nastavnik;
use App\Models\Razred;
use App\Models\Student;
use \Core\View;


/**
 * Dashboard controller
 *
 * 
 */


class Dashboard extends \Core\Controller

{

 /**
     * Show the index page of Admin Panel
     *
     * @return void
     */
    public function indexAction()
    {
     
        View::renderTemplate('Admin/Dashboard.html', [
           
        ]);
    }

    public function baseAction()
    {
     
        View::renderTemplate('Admin/baseAdmin.html', [
           
        ]);
    }

      /**
   * Add a new Student
   *
   * @return void
   */
  public function addNewStudentAction()
  {

   $razredi = Razred::getAll();

     View::renderTemplate('Admin/addNewStudent.html' , [
      'razredi' =>  $razredi
   ]); 
   

  }

        /**
   * Add a new Student
   *
   * @return void
   */
  public function allStudentsAction()
  {

     View::renderTemplate('Admin/Students.html');

  }


          /**
   * Add a new Class Room
   *
   * @return void
   */
  public function addNewClassRoomAction()
  {

 
     $nastavnici =  Nastavnik::getAll();

     View::renderTemplate('Admin/addNewClassRoom.html', [
      'nastavnici' => $nastavnici
     ]);

  }





  


    
  








  
}


?>