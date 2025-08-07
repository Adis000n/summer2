<!-- !!! To co sprawdza czy wszystko G -->
<?php
 session_start();
 if((!isset($_POST['username'])) || (!isset($_POST['password'])))
 {
    header('Location: login.php');
    exit();
 }
 require_once "connect.php";
 $connect = @new mysqli($host,$db_user,$db_password,$db_name);
 if($connect->connect_errno!=0)
    {
        echo "Error:".$connect->connect_errno;
    }
    else 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $username=htmlentities($username,ENT_QUOTES,"UTF-8"); 
        if($result = @$connect->query(
            sprintf("SELECT * FROM user WHERE username='%s'",
            mysqli_real_escape_string($connect,$username))))
        {
            $how_many_users = $result->num_rows;
            if($how_many_users>0)
            {
                $row = $result->fetch_assoc();
                if(password_verify($password,$row['password']))
                {
                    $_SESSION['logged in'] = true;

                    
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['user'] = $row['username'];
                    $_SESSION['Email'] = $row['email'];
                    unset($_SESSION['error']);
                    $result->close();
                    header('Location: kalendarz.php');  
                }
                else 
                {
                    $_SESSION['error'] = '<span class="fe">Niepoprawna nazwa użytkonika lub hasło!</span>';
                    header('Location:login.php');
                }      
            } else 
            {
                $_SESSION['error'] = '<span class="fe">Niepoprawna nazwa użytkonika lub hasło!</span>';
                header('Location:login.php');
            }

        }                   
        $connect->close();
    }   
?>
