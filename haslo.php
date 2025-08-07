<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Dodaj link do biblioteki SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
 </head>
 <body>
</body>
</html>
<?php 
session_start();
include ("db.php");
if(isset($_POST['zapisz1'])) {
    $id = $_SESSION['id'];
    $obecne_haslo = $_POST['obecne_haslo'];
    $nowe_haslo = $_POST['nowe_haslo'];
    $nowe_haslo2 = $_POST['nowe_haslo2'];
    $sql = "SELECT `password` from  user where id = '$id' ";
    $result = mysqli_query($con,$sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];
        
        if (password_verify($obecne_haslo, $stored_password)) {
            if ($nowe_haslo == $nowe_haslo2) {
                $password_hash = password_hash($nowe_haslo, PASSWORD_DEFAULT);
                $query = "UPDATE user SET password='$password_hash' WHERE id='$id' ";
            } else {
                $_SESSION['status'] = "Hasło nowe nie zgadza się";
                header("Location:myaccount.php");
                exit();
            }
        } else {
            $_SESSION['status'] = "Obecne hasło nie zgadza się";
            header("Location:myaccount.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Niepowodzenie z niewiadomych przyczyn";
        header("Location:myaccount.php");
        exit();
    }

    if(isset($query) && !empty($query)) {
        $query_run = mysqli_query($con, $query);
        if($query_run) {
            $_SESSION['status'] = "Pomyślnie zaaktualizowano hasło!";
            header("Location:myaccount.php");
            exit();
        } else {
            $_SESSION['status'] = "Błąd podczas aktualizowania hasła: " . mysqli_error($con);
            header("Location:myaccount.php");
            exit();
        }
    }
}
?>



