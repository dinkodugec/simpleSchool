<?php

namespace App\Models;

use PDO;
use App\Token;

/**
 * Example user model
 */
class User extends \Core\Model
{


    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];


    
  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data=[])
  {
    foreach ($data as $key => $value) {      //looping around array and setting key=>value pair as a property of new object
      $this->$key = $value;
    };
                    /*  convert array to object properties */
   /*  'name'=>'Dinko',                    $user->name= 'Dinko'
    'email'=>'dinko@gmail',             $user->email = 'dinko@gmail.com'
    'password'=>'secret'                 $user->password = 'secret'
       $data                                    $user */
  }


      /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
  
    
        try {
           /*  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                          $username, $password); */

           $db = static::getInstance();

            $stmt = $db->query('SELECT id, name, email, uloga FROM users');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       /*      $results = $stmt->fetch(PDO::FETCH_OBJ); */ //return object
         

            return $results;
        
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


  /**
   * Save the user model with the current property values
   *
   * @return void
   */
  public function save()
  {

    $this->validate();

    if(empty($this->errors)){
    
    $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (name, email, password_hash)
            VALUES (:name, :email, :password_hash)';

    $db = static::getInstance();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

      return  $stmt->execute();
     
     }
 
     return false;
}

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {
       // Name
       if ($this->name == '') {
           $this->errors[] = 'Name is required';
       }

       // email address
       if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
           $this->errors[] = 'Invalid email';
       }

       // Password
       if ($this->password != $this->password_confirmation) {
           $this->errors[] = 'Password must match confirmation';
       }

       //email exists allready
       if ($this->emailExists($this->email)) {
        $this->errors[] = 'email already taken';
    }

       if (strlen($this->password) < 6) {
           $this->errors[] = 'Please enter at least 6 characters for the password';
       }

       if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
           $this->errors[] = 'Password needs at least one letter';
       }

       if (preg_match('/.*\d+.*/i', $this->password) == 0) {
           $this->errors[] = 'Password needs at least one number';
       }
    }

      /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    protected function emailExists($email)
    {
        
        return static::findByEmail($email) !== false;

    }

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class()); //we change here so we now get object
                                      /*   namespace hardcoded 'App\Models\User' */
   
         $stmt->execute();
      
        return $stmt->fetch();//by default PDO fetch method return an array
    }

    /**
     * Authenticate a user by email and password.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password_hash)) {  //password_verify - Checks if the given hash matches the given options.
                return $user;
            }
        }

        return false;

    }

       /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

      /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean  True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();

       $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getInstance();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

        /*
   
    Admin user


    */
    public static function admin()
    {

        $email = 'dugecdinko@gmail.com'; //here I set Email for admin

        $sql = 'SELECT email FROM users WHERE email = :email';

        $db = static::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindValue('email', $email, PDO::PARAM_STR); 
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isAdmin($user)
    {
         $user = static::getInstance();

         return $user;
    }

            /*
         Nastavnik
    */
    public static function nastavnik()
    {

        $uloga = 'nastavnik';

        $sql = 'SELECT uloga FROM users WHERE uloga = :nastavnik';

        $db = static::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindValue('nastavnik', $uloga, PDO::PARAM_STR); 
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


     /*
        Promjeni usera u nastavnika
    */
    public static function promjeniUNastavnika($id)
    {

        $sql = "UPDATE users SET uloga = 'nastavnik' WHERE id = :id";

        $db = static::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }


}