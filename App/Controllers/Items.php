<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Items controller (example)

 */
class Items extends \Core\Controller
{

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
  
    {
         $this->requireLogin();
    }
    /**
     * Items index
     *
     * @return void
     */
    public function indexAction()
    {
        $this->requireLogin();

        View::renderTemplate('Items/index.html');
    }
}