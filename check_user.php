<?php

class Check_user
{
    private $config;
    private $email;
    private $uri;

    private $flag = false;

    public function Register_User_Exists($config, $email)
    {
        $d = new Database($this->config);
        try {
            $query = "SELECT * from student_details";

            $statement = $d->connection->prepare($query);

            $execute = $statement->execute();

            if ($execute) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    if ($this->email === $row['email']) {
                        return 1;                           /// If User Founds With The Same Email-Id 
                    }
                }
                return 0;                                       // If User Is not Found
            } else {
                echo "Error fetching" . $statement->errorInfo()[2];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function Login_User_Exists($config, $email, $password)
    {
        $d = new Database($config);
        try {
            $query = "SELECT * from student_details WHERE email = :email";
            
            $statement = $d->connection->prepare($query);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);

            $execute = $statement->execute();
            echo $execute;
            if ($execute) {
                            
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                
                if($result != ""){
                    if ($password === $result["password"]) {
                        //setcookie("", $result["name"], time() + 10);
                        session_start();    
                       // if (!isset($_SESSION["user_name"])) {
                            
                            $_SESSION["username"] = $result["name"];
                            header("Location: controllers/home.php");
                          //  echo "User Logged In Successfully";
                            // $sessionSavePath = session_save_path(); // used to get the current session path
                            // echo "Current Session Save Path: $sessionSavePath";
                        // }else{
                        //     echo "Session Variable Is  Already set "; 
                        // }
                    } else {
                        echo "Incorrect Password";
                    }
                }else{
                    echo "First,please register your account";  
                }

            }else {
                echo "Error fetching" . $statement->errorInfo()[2];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}
// $c = new Check_user($config,$email="mihir@gmail.com"); // for testing
// $c->isUserExists();
?>