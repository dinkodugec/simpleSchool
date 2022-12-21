<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Signup controller
 */
class Signup extends \Core\Controller
{
  /**
   * Show the signup page
   *
   * @return void
   */
  public function newAction()
  {
      View::renderTemplate('Signup/new.html');
  }

  /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        var_dump($_POST); //dumping content of $_POST array

        $user = new User($_POST);

      $user->save();

      View::renderTemplate('Signup/success.html');
    }
}