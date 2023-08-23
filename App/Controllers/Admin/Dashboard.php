<?php

namespace App\Controllers\Admin;

use App\Auth;
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

      if( !Auth::isAdmin()){
         $this->redirect('/public/index.php');
       } 
     
        View::renderTemplate('Admin/Dashboard.html', [
           'studentCount' => count(\App\Models\Student::getAll()),
           'razredCount' => count(\App\Models\Razred::getAll()),
           'nastavnikCount' => count(\App\Models\Nastavnik::getAll()),
           'userCount' => count(\App\Models\User::getAll())
          
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
   * All a new Student
   *
   * @return void
   */
  public function allStudentsAction()
  {

      $students = Student::getAll();

     View::renderTemplate('Admin/Students.html', [
      'students' => $students
     ]);

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

  
          /**
   * Svi Razredi
   *
   * @return void
   */
  public function sviRazrediAction()
  {

 
     $nastavnici =  Nastavnik::getAll();

     View::renderTemplate('Admin/addNewClassRoom.html', [
      'nastavnici' => $nastavnici
     ]);

  }

        /**
     * Prikaz razreda s nastavnikom
     *
     * @return void
     */
    public function razrediInastavnikAction()
    {

      $razrediSNastavnikom = Razred::razredi();

      View::renderTemplate('Admin/razrediSNastavnikom.html', [
        'razrediSNastavnikom' => $razrediSNastavnikom
      ]);


    }

    
    public static function sviRazredi()
    {

     $razredi = Razred::getAll();

     View::renderTemplate('Admin/sviRazredi.html', [
          'razredi' => $razredi
     ]);

     

    }

            /**
     * Prikaz svih nastavnika
     *
     * @return void
     */
    public function sviNastavniciAction()
    {

      $sviNastavniciAction = Nastavnik::getAll();

      View::renderTemplate('Admin/sviNastavnici.html', [
        'sviNastavniciAction' => $sviNastavniciAction
      ]);


    }

            /**
     * Prikaz za dodaj nastavnika
     *
     * @return void
     */
    public function dodajNastavnikaAction()
    {

       View::renderTemplate('Admin/dodajNastavnika.html');

    }









  


    
  








  
}


?>