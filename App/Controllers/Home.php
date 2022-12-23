<?php

namespace App\Controllers;

use App\Models\Student;
use \Core\View;

/**
 * Home controller
 *
 * 
 */
class Home extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        //echo "(before) ";
        //return false;
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo " (after)";
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
     
        $students = Student::getAll();

        View::renderTemplate('Home/index.html',[
           'students' => $students
    ]);
    }
}