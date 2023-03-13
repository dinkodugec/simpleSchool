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
      /*   var_dump($razredi); 
        die();
 */
        
        View::renderTemplate('Razred/index.html', [
           'razredi' => $razredi
         ]); 

 

    }


}