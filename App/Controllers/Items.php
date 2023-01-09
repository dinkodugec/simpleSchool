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
     * Items index
     *
     * @return void
     */
    public function indexAction()
    {
        if (! Auth::isLoggedIn()) {
            Auth::rememberRequestedPage();
            $this->redirect('/public/index.php?login');
        }

        View::renderTemplate('Items/index.html');
    }
}