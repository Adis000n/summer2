
<?php 
 session_start();
 if(!isset($_SESSION['logged in']))
 {
    header('Location: login.php');
    exit();
 }
 
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Dodaj link do biblioteki SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="icon" href="img/logo.jpg" type="image/jpeg">
 </head>
 <body>


 <button type="button" class="btn btn-dark btn-lg" onclick="goBack()" id="back">Wróć</button>
 <div class="container light-style flex-grow-1 container-p-y">
    <?php 
        if(isset($_SESSION['status'])) {
                ?>
            <script>
            Swal.fire({
                title:  "<?php   echo $_SESSION['status']; ?>",
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
                unset($_SESSION['status']);
        }



        ?>

        <h4 class="font-weight-bold py-3 mb-4">
            Ustawienia użytkownika
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">Ogólne</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Zmiana hasła</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#Usuwanie">Usuwanie Konta</a>
                    </div>
                    
                   
                    
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="img/awatar.png"  width="30%" height="30%" alt
                                    class="d-block ui-w-80">
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                            <form  action="code.php" method="POST">
                                <div class="form-group">
                                    <label class="form-label">Aktualna nazwa użytkownika</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $_SESSION['user']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nowa nazwa użytkownika</label>
                                    <input type="text" class="form-control mb-1" name="nowa_nazwa">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Aktualny adres e-mail</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $_SESSION['Email']; ?>" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Nowy adres e-mail</label>
                                    <input type="text" class="form-control mb-1" name="nowy_email">
                                    <button type="submit" name="zapisz" class="btn btn-primary">Zapisz Zmiany</button>&nbsp;
</form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <form action="haslo.php" method="POST">
                                <div class="form-group">
                                    <label class="form-label"> Wpisz obecne hasło</label>
                                    <input type="password"  name="obecne_haslo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label"> Wpisz nowe hasło</label>
                                    <input type="password" name="nowe_haslo" class="form-control" maxlength="20" minlength="4">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Powtórz nowe hasło</label>
                                    <input type="password" name="nowe_haslo2" class="form-control" maxlength="20" minlength="4">
                                    <button type="submit" name="zapisz1" class="btn btn-primary" style="margin-top:10px;">Zapisz hasło</button>&nbsp;
</form>                         

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Usuwanie">
                            <form action="Usuwanie_konta.php" method="POST">
                        <div class="form-group">  
                        <button type="submit" name="Usun"  class="btn btn-danger btn-danger btn-lg" style="margin-top:10px;">Usuń Konto</button>&nbsp;
    </form>
                        </div>
                        </div>
                                    </label>
        <div class="text-right mt-3">
     
        

    
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
 function goBack(){
        location.href = "kalendarz.php";
    }

    </script>

 </body>


 <style>
        @media only screen and (max-width: 600px) {
    form {
        margin-top: 15%;
        width: 90%;
    }
    }
    #add{
        width: 100%;
    }
    #back{
        position: absolute;
        right: 2%;
        top: 2%;
    }
</style>
 </html>
