<?php
 session_start();
 if((isset($_SESSION['logged in'])) && ($_SESSION['logged in']==true))
 {
  header('Location: myaccount.php');
  exit();
 }
?>
<!DOCTYPE html>
<html lang="pl">
<head> 
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login_styles.css" />
  <title>Strona logowania</title>
  <link rel="icon" href="img/logo.jpg" type="image/jpeg">
</head>
<body>
  <div class="bg" aria-hidden="true">
    <div class="bg__dot"></div>
    <div class="bg__dot"></div>
  </div>
  <form action="loginonsite.php" method="post" class="form" autocomplete="off">
    <div class="form__icon" aria-hidden="true"></div>
    <div class="form__input-container">
      <input aria-label="User" class="form__input" type="text" id="username" name="username" placeholder=" " required>
      <label class="form__input-label" for="username">Nazwa użytkownika</label>
    </div>
    <div class="form__input-container">
      <input aria-label="Password" class="form__input" type="password" id="password" name="password" placeholder=" " required>
      <label class="form__input-label" for="password">Hasło</label>
    </div>
    <?php
    if(isset($_SESSION['error']))
    echo $_SESSION['error'];
  ?>
    <div class="form__spacer" aria-hidden="true"></div>
    <button class="form__button">Zaloguj się</button>
    <a href="register.php" class="form__register-text"><br>Nie masz konta? Kliknij tutaj!</a>
  </form>
</body>
</html>
