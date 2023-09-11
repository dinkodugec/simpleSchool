<?php

namespace App\Controllers;

use App\Models\User;
use \Core\View;


/**
 * User controller
 */
class Users extends \Core\Controller
{

    /**
     * Show all users
     *
     * @return void
     */
    public function indexAction()
    {
        $users = User::getAll();

        
        View::renderTemplate('Users/index.html', [
           'users' => $users
         ]); 

    }

        /**
     * Show all users
     *
     * @return void
     */
    public function promjeniUNastavnikaAction()
    {
         $id = $_GET['id'];

         User::promjeniUNastavnika($id);

         $users = User::getAll();
      
         View::renderTemplate('Users/index.html', [
          'users' => $users
        ]); 

    }

  }