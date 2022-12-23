<?php

namespace App\Controllers;
use App\Models\Student;
use \Core\View;


/**
 * Student controller
 */
class Students extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $students = Student::getAll();

        
        View::renderTemplate('Student/index.html', [
           'students' => $students
         ]); 

        var_dump($students);  

    }

    /**
     * Show the add new page
     *
     * @return void
     */
    public function CreateNewAction()
    {
   
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
          }
          if ($moved === true) {                                            // If it moved
              $message = 'Uploaded:<br><img src="' . $destination . '">';   // Show image
          } else {                                                          // Otherwise
              $message = '<b>Could not upload file:</b> ' . $error;         // Show errors
          }
      }
       
     /*   $student = new Student($_POST); 
       echo "<pre>";
      var_dump($_FILES);
      echo "</pre>";  die();  */
     
     
    }
}