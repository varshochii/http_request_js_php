

<?php 


if(isset($_POST['action']) && $_POST['action']){

    $errors = [];

    $error_log = false;

    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname  = htmlspecialchars($_POST['lastname']);
    $email     = htmlspecialchars($_POST['email']);
    $password  = htmlspecialchars($_POST['password']);

    if(empty($firstname)){
         $errors['firstname'] = 'firstname is required';
         $error_log = true;
    }

    if(empty($lastname)){
         $errors['lastname'] = 'lastname is required';
         $error_log = true;
    }

    if(empty($email)){
         $errors['email']= 'email is required';
         $error_log = true;
    }

    if(empty($password)){
         $errors['password']= 'password is required';
         $error_log = true;
    }

    if(isset($_FILES['file']['name'])){
 
         $allowed_type = ['image/jpeg','image/jpg','image/png'];

         if(!in_array($_FILES['file']['type'],$allowed_type)){
             
            $errors['file']= 'format is not allowed, you can use these formats: ' . implode(',',$allowed_type);
         }else{

              if($_FILES['file']['size'] > 3000000){

                 $errors['file']= 'file size is too large';

              }else{

                   $folder = 'uploads/';
                   $destination_image = $folder . time() . $_FILES['file']['name'];
                   move_uploaded_file($_FILES['file']['tmp_name'], $destination_image);

              }
         }

    }else{

        $errors['file']= 'file is required';
    }





    if(!empty($errors) && $error_log = true){

         $all_messages = array($errors,'error_log' => $error_log);
         echo json_encode($all_messages);

    }else{

          $error_log = false;

          ///////// then add to database if add proccess was successfull then add these below codes
          $all_messages = array('success' => 'data has been added successfully','error_log' => $error_log);
          echo json_encode($all_messages);
    }


}

