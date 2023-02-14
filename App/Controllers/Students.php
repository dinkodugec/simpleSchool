<?php

namespace App\Controllers;

use App\Models\Predmet;
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

            $oneStudent = Student::getOneStudent($id);
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
}