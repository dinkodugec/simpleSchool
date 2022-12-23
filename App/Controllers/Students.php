<?php

namespace App\Controllers;
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

            
        }

    
     
     
    }
}