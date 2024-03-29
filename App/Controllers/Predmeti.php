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
     
        $predmeti = Predmet::getAll();

        View::renderTemplate('Predmet/show.html',[
          
    ]);

  
    }

             /**
     * Create new predmet
     *
     * @return void
     */
    public function createAction()
    {
       /* var_dump($_POST); */ //to see what is comming from post request in frim new.html 
   
       $predmet = new Predmet($_POST); //passing arguments like this will, when you creating new object will invoke __construct

       /* echo "<pre>"; 
        var_dump($predmet);
       echo "</pre>"; */

       if($predmet->save()) {

            $this->redirect('/public/index.php?admin/dashboard/index');

       } else{

        View::renderTemplate('/', [
          'predmet' => $predmet
        ]);  

       }

    }



}