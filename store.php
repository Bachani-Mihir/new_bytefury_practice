<?php
    include '../database.php';
    include '../config.php';
    include 'check_user.php';

    $name = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $comments = $_POST['comments'];


$d = new Database($config);
try {
    $check = new Check_user(); // for 
                        
    if (!$check->Register_User_Exists($config,$email)) {

        $query = "INSERT INTO student_details (name, email, password, phone_number, gender, course, comments) VALUES(:name, :email, :password, :phone, :gender, :course, :comments)";

        $statement = $d->connection->prepare($query);

        $statement->bindParam(':name', $name);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':gender', $gender);
        $statement->bindParam(':course', $course);
        $statement->bindParam(':comments', $comments);

        $execute = $statement->execute();

        if ($execute) {
           // echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . $statement->errorInfo()[2];
        }
    } else {
       // echo "hie";
        require "check_user.php";
        $error_message = "Email ID is already registered.";
        echo $error_message;
    }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
      
?>
