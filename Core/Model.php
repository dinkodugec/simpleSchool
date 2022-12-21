<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 *
 * 
 */
 class Model
{

    protected static $instance;


    private static $dsn = 'mysql:host=localhost;dbname=skola';
    
    private static $username = 'root';
    
    private static $password = '';
    
    private function __construct() {
    try {
    self::$instance = new PDO(self::$dsn, self::$username, self::$password);
    } catch (\PDOException $e) {
    echo "MySql Connection Error: " . $e->getMessage();
    }
    }
    
    
    
    public static function getInstance() 
    {
              if (!self::$instance) {
              new Model();
          }
    
          return self::$instance;
    
    }
}

/*  http://giuffre.github.io/PHP-Mysql-how-to-optimize-a-connection/  */