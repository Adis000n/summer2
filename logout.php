!!! potem do dodania w ustawieniach konta "wyloguj się" i bedzie okok
<?php
 session_start();
 session_unset();
 header('Location: login.php');
?>
