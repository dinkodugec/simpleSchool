<?php

namespace App\Controllers;


use App\Models\Student;
use \Core\View;
use App\Models\Predmet;



class Predmeti extends \Core\Controller
{

   /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
     
        $studenti = Student::getAll();

        View::renderTemplate('Predmet/show.html',[
          
    ]);

  
    }





}