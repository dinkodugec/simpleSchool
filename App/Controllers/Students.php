<?php

namespace App\Controllers;

use App\Models\Predmet;
use App\Models\Razred;
use App\Models\Student;
use \Core\View;


/**
 * Student controller
 */
class Students extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $students = Student::getAll();

        
        View::renderTemplate('Student/index.html', [
           'students' => $students
         ]); 

    /*     var_dump($students);   */

    }

    /**
     * Show the add new page
     *
     * @return void
     */
    public function CreateNewAction()
    {
     /*    var_dump($_POST); 
          die(); */
     
        $student = new Student($_POST); 
    
        if($student->addStudent()){
          View::renderTemplate('Admin/success.html');
        } else {
            View::renderTemplate('Admin/addNewStudent.html', [
              
                'student' => $student //passing user model
            ]);
        }

  
    }

    public function showStudentAction()
    {
            $id = $_GET['id'];

            $email = $_GET['email'];

            $oneStudent = Student::getOneStudent($email);
           /*  echo "<pre>"; 
            var_dump( $oneStudent);
           echo "</pre>";  */

            $predmeti = Predmet::getPredmetByStudentId($id);
          /*   echo "<pre>"; 
            var_dump( $predmeti);
           echo "</pre>"; */

           $prosjeci = Predmet::prosjekByStudent($id);
         /*    echo "<pre>"; 
             var_dump( $prosjeci);
             die();
            echo "</pre>";   


          /*   array(1) {
              ["AVG(ocjena)"]=>
              string(6) "4.6667" */

            View::renderTemplate('Student/index.html', [
                'student' => $oneStudent,
                'predmeti' => $predmeti,
                'prosjeci' => $prosjeci
              ]);
        
    }

    public function deleteStudentAction()
    {
 
     $id = $_GET['id']; 
     
     $student = Student::getOneStudent($id);
 
     if($student){
        Student::obrisiStudenta($id);
        
        View::renderTemplate('Admin/Students.html');
     }
 

 
    }

    public function showStudentInRazredAction()
    {
            $id = $_GET['id'];

            $email = $_GET['email'];

            $oneStudent = Student::getOneStudent($email);
           /*  echo "<pre>"; 
            var_dump( $oneStudent);
           echo "</pre>";  */

      

            View::renderTemplate('Student/studentInRazred.html', [
                'student' => $oneStudent,
               
              ]);
        
    }

}