<?php

namespace App\Models;

use PDO;
use PDOException;

/**
 * Student model
 *
 * 
 */
class Student extends \Core\Model
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
  public function __construct($data)
  {
    foreach ($data as $key => $value) {      
      $this->$key = $value;
    };

  }

    /**
     * Get all the posts as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $host = 'localhost';
        $dbname = 'skola';
        $username = 'root';
        $password = '';
    
        try {
           /*  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                          $username, $password); */

           $db = static::getInstance();

            $stmt = $db->query('SELECT id, name, surname, image, email FROM student');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       /*      $results = $stmt->fetch(PDO::FETCH_OBJ); */ //return object
         

            return $results;
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


    public  function addStudent()

    {
        $this->validate();

        if(empty($this->errors))
        {
           /*   var_dump($this->errors);
             die(); */
            if(isset($_POST['submit'])){
 

                $moved         = false;                                        // Initialize
                $message       = '';                                           // Initialize
                $error         = '';                                           // Initialize
                $upload_path   = '../uploads/';                                   // Upload path
                $max_size      = 5242880;                                      // Max file size
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif',];    // Allowed file types
                $allowed_exts  = ['jpeg', 'jpg', 'png', 'gif',];               // Allowed file extensions
                
                function create_filename($filename, $upload_path)              // Function to make filename
                {
                    $basename   = pathinfo($filename, PATHINFO_FILENAME);      // Get basename
                    $extension  = pathinfo($filename, PATHINFO_EXTENSION);     // Get extension
                    $basename   = preg_replace('/[^A-z0-9]/', '-', $basename); // Clean basename
                    $filename   = $basename . '.' . $extension;                // Add extension to clean basename
                    $i          = 0;                                           // Counter
                    while (file_exists($upload_path . $filename)) {            // If file exists
                        $i        = $i + 1;                                    // Update counter 
                        $filename = $basename . $i . '.' . $extension;         // New filepath
                    }
                    return $filename;                                          // Return filename
                }
        
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {                    // If form submitted
                        $error = ($_FILES['file']['error'] === 1) ? 'too big ' : '';  // Check size error
                    
                        if ($_FILES['file']['error'] == 0) {                          // If no upload errors
                            $error  .= ($_FILES['file']['size'] <= $max_size) ? '' : 'too big '; // Check size
                            // Check the media type is in the $allowed_types array
                            $type   = mime_content_type($_FILES['file']['tmp_name']);        
                            $error .= in_array($type, $allowed_types) ? '' : 'wrong type ';
                            // Check the file extension is in the $allowed_exts array
                            $ext    = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                            $error .= in_array($ext, $allowed_exts) ? '' : 'wrong file extension ';
                    
                            // If there are no errors create the new filepath and try to move the file
                            if (!$error) {
                            $filename    = create_filename($_FILES['file']['name'], $upload_path);
                            $destination = $upload_path . $filename;
                            $moved       = move_uploaded_file($_FILES['file']['tmp_name'], $destination);
                            }

                            if($moved){

                                $name = $_POST['name'];
                                $surname = $_POST['surname'];
                                $email = $_POST['email'];
                                $razred_id = $_POST['razred_id'];

                                $sql = "INSERT INTO student (name, surname, image, email, razred_id) 
                                VALUES (?,?,?,?,?)";
                                
                                $db = static::getInstance();
                                $stmt = $db->prepare($sql);

                                $result =  $stmt->execute([$name,$surname, $filename,$email,$razred_id]); 
                                
                                return $result;
                            
                            }


                            }
                            if ($moved === true) {                                            // If it moved
                                $message = 'Uploaded:<br><img src="' . $destination . '">';   // Show image
                            } else {                                                          // Otherwise
                                $message = '<b>Could not upload file:</b> ' . $error;         // Show errors
                            }
                        }
         
     /*     $student = new Student($_POST); 
         echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";  die();   */
       

        }  //end   if(isset($_POST['submit'])

       }  // end  if(empty($this->errors))


    
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

          // Name
          if ($this->surname == '') {
            $this->errors[] = 'Surname is required';
        }

       // email address
       if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
           $this->errors[] = 'Invalid email';
       }
  

       //email exists allready
       if ($this->emailExists($this->email)) {
        $this->errors[] = 'email already taken';
       }

    
    }

          /**
     * See if a student record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    protected function emailExists($email)
    {
        $sql = 'SELECT * FROM student WHERE email = :email';   //selecting email matching argument in method, :email named parametaer

        $db = static::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch() !== false;  //PDO fetch() return false if record is not find
    }

      /**
     * Get one student in an associative array / we can change method fetch, in fetchObj so get object back
     *
     * @return array
     */

     public static function getOneStudent($id) //id is comming from $_GET['id'] when form is submitted student.index.blade.php
    
        {
    

           try {
           $db = static::getInstance();

            $stmt = $db->prepare('SELECT id, name, surname, image, email FROM student
                               WHERE id = ?');
           $stmt->execute([$id]);
        
           $results = $stmt->fetch(PDO::FETCH_ASSOC);  //return values as associative array
          
           
            return $results;
            
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function studentInRazred($id)
    {

        try {
            $db = static::getInstance();
 
             $stmt = $db->prepare("SELECT student.id, CONCAT (student.name, ' ', student.surname) AS name, student.image, student.email, student.razred_id, razred.id
                                    FROM student
                                    JOIN razred on student.razred_id = razred.id
                                    WHERE  student.razred_id = ? 
                                    AND   student.razred_id = razred.id");
                                   
            $stmt->execute([$id]);
         
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
           
          return $results;

         
    
             
             
         } catch (PDOException $e) {
             echo $e->getMessage();
         }


    }

    public static function obrisiStudenta($id)
    {
        try {
            $db = static::getInstance();
 
             $stmt = $db->prepare("DELETE from student WHERE id = ?");
                                   
             $results = $stmt->execute([$id]);
         
          return $results;

             
         } catch (PDOException $e) {
             echo $e->getMessage();
         }
        
    }


    
}