<?php

namespace Core;

/**
 * View
 *
 * 
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            //echo "$file not found";
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            /* $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader); */
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);
          /*   $twig->addGlobal('session', $_SESSION); //add session like global variable */
           /*  $twig->addGlobal('is_logged_in', \App\Auth::isLoggedIn());  */
            $twig->addGlobal('current_user', \App\Auth::getUser()); 
            $twig->addGlobal('students', \App\Models\Student::getAll()); //students in super global variable
           /*  add global route for user whi is admin via user_id or some othr way */
          $twig->addGlobal('is_admin', \App\Auth::isAdmin());   
          $twig->addGlobal('is_nastavnik', \App\Auth::isNastavnik());  
           
        }

        echo $twig->render($template, $args);
    }
}