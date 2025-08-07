<?php
 session_start();
 if(isset($_POST['email']))
 {
  $everything_okay = true;
  $username = $_POST['username'];
  if((strlen($username)<3) || (strlen($username)>20))
  {
    $everything_okay=false;
    $_SESSION['error_username'] ="Nazwa użytkownika musi mieć od 3 do 20 znaków";
  }
  if(ctype_alnum($username)==false)
  {
    $everything_okay=false;
    $_SESSION['error_username']="Nazwa użytkownika może składać się wyłącznie z liter i cyfr!";
  }
  $email = $_POST['email'];
  $emailS = filter_var($email,FILTER_SANITIZE_EMAIL);
  if((filter_var($emailS,FILTER_VALIDATE_EMAIL)==false)||($emailS!=$email))
  {
    $everything_okay=false;
    $_SESSION['error_email']="Proszę wpisać poprawny adres e-mail!";
  }
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  if((strlen($password)<4)||(strlen($password)>20))
  {
    $everything_okay=false;
    $_SESSION['error_password']="Hasło musi mieć od 8 do 20 znaków!";
  }
  if($password!=$confirm_password)
  {
    $everything_okay=false;
    $_SESSION['error_password']="Podane hasła nie są takie same!";
  }
  $password_hash = password_hash($password,PASSWORD_DEFAULT);
  if(!isset($_POST['rules']))
  {
    $everything_okay=false;
    $_SESSION['error_rules']="Zaakceptuj regulamin!";
  }
  require_once"connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);
  try
  {
    $connect = new mysqli($host,$db_user,$db_password,$db_name);
    if($connect->connect_errno!=0)
    {
      throw new Exception(mysqli_connect_errno());
    }
    else
    {
      $result = $connect->query("SELECT id FROM user WHERE email='$email'");
      
      
      if(!$result) throw new Exception($connect->error);
      $how_many_emails = $result->num_rows;
      
      
      
      
      if($how_many_emails>0)
     
      {
        $everything_okay=false;
        $_SESSION['error_email']="Z tym adresem e-mail jest już powiązane konto!";
      }
      
      $result = $connect->query("SELECT id FROM user WHERE username='$username'");
      
      
      if(!$result) throw new Exception($connect->error);
      $how_many_usernames = $result->num_rows;
      
      
      if($how_many_usernames>0)
      
      
      {
        $everything_okay=false;
        $_SESSION['error_username']="Istnieje już użytkownik o tej nazwie!";
      }
      
      
      if($everything_okay==true) 
      
      
      {
        if($connect->query("INSERT INTO user VALUES (NULL,'$username','$password_hash','$email')"))
        {
          $_SESSION['successfull_registration']=true;
          header('Location:login.php');
        }
        else
        {
          throw new Exception($connect->error);
        }
      }
      $connect->close();
    }
  }
  catch(Exception $error)
  {
    echo '<span class= "bladserwera">Błąd serwera! Spróbuj ponownie później!</span>';
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login_styles.css" />
  <title>Rejestracja</title>
</head>
<body>
  <body>
    <div class="bg" aria-hidden="true">
      <div class="bg__dot"></div>
      <div class="bg__dot"></div>
    </div>
    <form class="form" method="post">
      <div class="form__icon" aria-hidden="true"></div>
      <?php
        if(isset($_SESSION['error_username']))
        {
          echo'<div class="fe">'.$_SESSION['error_username'].'</div>';
          unset($_SESSION['error_username']);
        }
      ?>
      <div class="form__input-container">
        <input aria-label="User" class="form__input" type="text" id="username" name="username" placeholder=" " required>
        <label class="form__input-label" for="username">Nazwa użytkownika</label>
      </div>
      <?php
        if(isset($_SESSION['error_email']))
        {
          echo'<div class="fe">'.$_SESSION['error_email'].'</div>';
          unset($_SESSION['error_email']);
        }
      ?>
      <div class="form__input-container">
        <input aria-label="E-mail" class="form__input" type="text" id="email" name="email" placeholder=" " required>
        <label class="form__input-label" for="email">E-mail</label>
      </div>
      <?php
        if(isset($_SESSION['error_password']))
        {
          echo'<div class="fe">'.$_SESSION['error_password'].'</div>';
          unset($_SESSION['error_password']);
        }
      ?>
      <div class="form__input-container">
        <input aria-label="Password" class="form__input" type="password" id="password" name="password" placeholder=" " required>
        <label class="form__input-label" for="password">Hasło</label>
      </div>
      <div id="message" class="pass-check">Podane hasło jest <span id="strenght"></span></div>
      <script>
        var pass = document.getElementById("password");
        var msg = document.getElementById("message");
        var str = document.getElementById("strenght");
        msg.style.display = "none";
        pass.addEventListener('input',() => {
            if(pass.value.length > 0){
                msg.style.display = "block";
            } else {
                msg.style.display = "none";
            } if(pass.value.length <6) {
                str.innerHTML = "słabe";
                pass.style.borderColor = "#ff5925";
                msg.style.color = "#ff5925";
            } if(pass.value.length >=6 && pass.value.length<8) {
                str.innerHTML = "średnie";
                pass.style.borderColor = "yellow";
                msg.style.color = "yellow";
            }if(pass.value.length >=8) {
                str.innerHTML = "silne";
                pass.style.borderColor = "#036e2c";
                msg.style.color = "#036e2c";
            }
        })
      </script>
      <div class="form__input-container">
        <input aria-label="Confirm Password" class="form__input" type="password" id="confirm password" name="confirm password" placeholder=" " required>
        <label class="form__input-label" for="confirm password">Powtórz Hasło</label>
      </div>
      <?php
        if(isset($_SESSION['error_rules']))
        {
          echo'<div class="fe">'.$_SESSION['error_rules'].'</div>';
          unset($_SESSION['error_rules']);
        }
      ?>
      <label class="container">
        <input class="checkbox" type="checkbox" name="rules"> Akceptuję <a href="regulamin.html">regulamin</a>
        <span class="checkmark"></span>
      </label>
       <div class="form__spacer"></div>
      <button class="form__button" type="submit">Zarejestruj się</button>
      <a href="login.php" class="form__register-text"><br>Masz już konto? Kliknij tutaj!</a>
    </form>
</body>
</html>
