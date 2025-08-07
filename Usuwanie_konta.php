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

if(isset($_POST['Usun'])) 
{
    $id = $_SESSION['id'];

    // Delete associated rows in daty_nauki table
    $query1 = "DELETE FROM daty_nauki WHERE wydarzenie_id IN (SELECT id FROM wydarzenia WHERE user_id='$id')";
    $query_run1 = mysqli_query($con, $query1);

    // Delete associated rows in wydarzenia table
    $query2 = "DELETE FROM wydarzenia WHERE user_id='$id'";
    $query_run2 = mysqli_query($con, $query2);

    // Now delete the user
    $query3 = "DELETE FROM user WHERE id='$id' ";
    $query_run3 = mysqli_query($con, $query3);

    if($query_run3){

        $_SESSION['status'] = "Usunięto twoje konto";
        ?>
        <script>
             Swal.fire({
                title:  "Usunięto twoje konto",
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
    } else  {
        
        $_SESSION['status'] = "Błąd w usuwaniu konta";
        header("Location:myaccount.php");
    }

}
?>