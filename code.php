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
    <style>
    .swal2-popup {
      font-family: 'Roboto', sans-serif;
    }
  </style>
 </head>
 <body>
</body>
</html>
<?php 
session_start();
include ("db.php");

if(isset($_POST['zapisz'])) {
    $id = $_SESSION['id'];
    $nazwa = $_POST['nowa_nazwa'];
    $email = $_POST['nowy_email'];

    if (!empty($nazwa) && !empty($email)) {
        $query = "UPDATE user SET username='$nazwa', email='$email' WHERE id='$id' ";
    } elseif (!empty($nazwa)) {
        $query = "UPDATE user SET username='$nazwa' WHERE id='$id' ";
    } elseif (!empty($email)) {
        $query = "UPDATE user SET email='$email' WHERE id='$id' ";
    } 

    if(isset($query) && !empty($query)) {
        $query_run = mysqli_query($con, $query);

        if($query_run) 
        {
           ?>
            <script>
            Swal.fire({
                title:  "Pomyślnie zaaktualizowano dane i zaraz zostaniesz wylogowany",
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Rozumiem',
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire(
                    location.href = "logout.php"
                  )
                  
                }
              })
                  
                  </script>
                  <?php
        } else 
        {
            ?>
            <script>
            Swal.fire({
                title:  "Niepowodzenie",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Rozumiem',
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire(
                    location.href = "myaccount.php"
                  )
                  
                }
              })
                  
                  </script>
                  <?php
        }
    } else {
        ?>
            <script>
            Swal.fire({
                title:  "Nie dokonano żadnych zmian",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Rozumiem',
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire(
                    location.href = "myaccount.php"
                  )
                  
                }
              })
                  
                  </script>
                  <?php
    }
}

?>

 