<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\User;

/**
 * Login controller
 */
class Login extends \Core\Controller
{
    /**
     * Show the login page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Login/new.html');
    }

     /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
        //here we have email and password comming from the form and we can start authenticate user
        /* echo($_REQUEST['email'] . ', ' . $_REQUEST['password']); */ //output the content of request to see what happend

       /*  $user = User::findByEmail($_POST['email']); */

        $user = User::authenticate($_POST['email'], $_POST['password']);

      /*   var_dump($_POST); */

      $remeber_me = isset($_POST['remember_me']);

        if ($user) {

            Auth::login($user,'');

            Auth::login($user, $remeber_me);

        /*   header('Location: http://' . $_SERVER['HTTP_HOST'] . '/public/index.php', true, 303);
          exit; */

          //REMBER the login will be here

          
          $this->redirect('/public/index.php');

      } else {

          View::renderTemplate('Login/new.html', [
            'email' => $_POST['email'], // when form is redisplayed when authenticate is failed, we can pass email address when render template
            'remember_me' => $remeber_me
            ]);
      
    }
  }

   /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/public/index.php');      
    }
}