<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 */
class User extends \Core\Model
{

  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data)
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    };
                    /*  convert array to object properties */
   /*  'name'=>'Dinko',                    $user->name= 'Dinko'
    'email'=>'dinko@gmail',             $user->email = 'dinko@gmail.com'
    'password'=>'secret'                 $user->password = 'secret'
       $data                                    $user */
  }

  /**
   * Save the user model with the current property values
   *
   * @return void
   */
  public function save()
  {
    $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (name, email, password_hash)
            VALUES (:name, :email, :password_hash)';

    $db = static::getInstance();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

    $stmt->execute();
  }
}