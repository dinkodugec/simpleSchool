<?php

namespace App\Controllers\Admin;

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

     View::renderTemplate('Admin/addNewStudent.html');

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





  


    
  








  
}


?>