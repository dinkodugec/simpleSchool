<?php

namespace App;

use App\Models\User;
use App\Models\RememberedLogin;

/**
 * Authentication

 */
class Auth
{
    /**
     * Login the user
     *
     * @param User $user The user model
     * @param boolean $remember_me Remember the login if true
     *
     * @return void
     */
    public static function login($user, $remember_me)
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email; 
        $_SESSION['nastavnik'] = $user->uloga; 

        if ($remember_me) {

            if($user->rememberLogin()){
              setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/'); //set a cookie
            }

        }
    }

    /**
     * Logout the user
     *
     * @return void
     */
    public static function logout()
    {
       // Unset all of the session variables
       $_SESSION = [];

       // Delete the session cookie
       if (ini_get('session.use_cookies')) {
           $params = session_get_cookie_params();

           setcookie(
               session_name(),
               '',
               time() - 42000,
               $params['path'],
               $params['domain'],
               $params['secure'],
               $params['httponly']
           );
       }

       // Finally destroy the session
       session_destroy();

       Auth::forgetLogin();
    }

   

    /**
     * Remember the originally-requested page in the session
     *
     * @return void
     */
    public static function rememberRequestedPage()
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI']; //url from requested page
    }

    /**
     * Get the originally-requested page to return to after requiring login, or default to the homepage
     *
     * @return void
     */
    public static function getReturnToPage()
    {
        return $_SESSION['return_to'] ?? '/public/index.php';
    }

    /**
     * Get the current logged-in user, from the session or the remember-me cookie
     *
     * @return mixed The user model or null if not logged in
     */
    public static function getUser()
    {
        if (isset($_SESSION['user_id'])) {

            return User::findByID($_SESSION['user_id']);
        }else{
            return static::loginFromRememberCookie();
        }
    }

      /**
     * Login the user from a remembered login cookie
     *
     * @return mixed The user model if login cookie found; null otherwise
     */
    protected static function loginFromRememberCookie()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);

            if ($remembered_login && ! $remembered_login->hasExpired()) {

                $user = $remembered_login->getUser();

                static::login($user, false);

                return $user;
            }
        }
    }

    
    /**
     * Forget the remembered login, if present
     *
     * @return void
     */
    public static function forgetLogin()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);  //if there is coresonding  record for this token

            if ($remembered_login) {

                $remembered_login->delete();

            }

            setcookie('remember_me', '', time() - 3600);  // set to expire in the past
        }
    }

          /**
     * Return indicator of whether a user is admin in or not
     *
     * @return boolean
     */

    public static  function isAdmin()
     {
               $admin = User::admin();
 
                 if($admin['email'] === ($_SESSION['user_email'])){
 
                         return true;
 
                     } else {
 
                     return false;
 
                     }
 
     }  

     
          /**
     * Return indicator of whether a user is nastavnik
     *
     * @return boolean
     */

    public static  function isNastavnik()
    {
              $nastavnik = User::nastavnik();

                if($nastavnik['uloga'] === $_SESSION['nastavnik'] ){

                        return true;

                    } else {

                    return false;

                    }

    }  
 

 
}