<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">       
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css"> 
    <title>Kalendarz</title>
    <link rel="icon" href="img/logo.jpg" type="image/jpeg">
</head>
<?php 
include ("db.php");
session_start();
if(!isset($_SESSION['logged in']))
{
   header('Location: login.php');
   exit();
}
 ?>
<body onClick="collapseAll()">
   <div class="web"> 
   <button onclick="topFunction()" id="goUpBtn" title="Go to top">Do Góry!</button>
    <div class="menu">
        <button class="menu_btn" onclick="goToDodawanie()">➕ Dodaj&nbsp;</button>
        <button  class="menu_btn" onclick="goto1()" style="background-color:rgba(47, 204, 255, 1)">widok1</button>
        <button  class="menu_btn" onclick="goto2()">widok2</button>
        <button  class="menu_btn" onclick="goto3()">widok3</button>       
        
        <button class="menu_btn" type="button">
          <img src="img/awatar.png" width="20% "  height="auto"> 
    <?php 
       $id = $_SESSION['id'];
      
       $nameQ = mysqli_query($con,"SELECT `username` FROM `user` WHERE id =$id;");
     
       while ($row = $nameQ->fetch_assoc()) {
        $name = implode($row);         
      }

      echo '<div class="nick"><div class="nickN">'.$_SESSION['user'].'</div></div>';
    ?>
        </button>        
                       
        <div class="list_Menu">
        <button type="button" class="l_Btn" data-bs-toggle="modal" data-bs-target="#exampleModal">📈 Statystyki</button>
          <button class="l_Btn" onclick="document.location='myaccount.php'">⚙️ Ustawienia profilu&nbsp;</button>
          <button class="l_Btn" onclick="alert()">⚠️ Wyloguj się&nbsp;</button>
        </div>
      <?php
       
      ?>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Statystyki z ostatniego tygodnia</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php
            $q_sprawdzian_pods = "SELECT * FROM wydarzenia WHERE typ = 'sprawdzian' AND user_id = $id AND data BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY) AND DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
            $result_sprawdzian_pods = mysqli_query($con, $q_sprawdzian_pods);
            $count_sprawdzian_pods = mysqli_num_rows($result_sprawdzian_pods);
            
            $q_kartkowka_pods = "SELECT * FROM wydarzenia WHERE typ = 'kartkowka' AND user_id = $id AND data BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY) AND DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
            $result_kartkowka_pods = mysqli_query($con, $q_kartkowka_pods);
            $count_kartkowka_pods = mysqli_num_rows($result_kartkowka_pods);
            
            $q_zadanie_pods = "SELECT * FROM wydarzenia WHERE typ = 'zadanie' AND user_id = $id AND data BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY) AND DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
            $result_zadanie_pods = mysqli_query($con, $q_zadanie_pods);
            $count_zadanie_pods = mysqli_num_rows($result_zadanie_pods);
            
            $q_obowiazek_pods = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND user_id = $id AND data BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY) AND DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
            $result_obowiazek_pods = mysqli_query($con, $q_obowiazek_pods);
            $count_obowiazek_pods = mysqli_num_rows($result_obowiazek_pods);
            
            function displayEventCount($count, $type) {
                $typeText = '';
            
                // Define the event type text based on the provided $type
                switch ($type) {
                    case 'primary':
                        $typeText = 'sprawdzianów';
                        break;
                    case 'success':
                        $typeText = 'kartkówek';
                        break;
                    case 'info':
                        $typeText = 'zadań';
                        break;
                    case 'warning':
                        $typeText = 'obowiązków';
                        break;
                    default:
                        $typeText = 'wydarzeń';
                }
            
                if ($count > 0) {
                    echo "<h2>W tym tygodniu miałeś: $count <a class='text-$type' style='text-decoration: none;'>$typeText</a></h2>";
                } else {
                    echo "<h2>W tym tygodniu nie ukończyłeś jeszcze żadnych <a class='text-$type' style='text-decoration: none;'>$typeText</a></h2>";
                }
            }
            
            displayEventCount($count_sprawdzian_pods, 'primary');
            displayEventCount($count_kartkowka_pods, 'success');
            displayEventCount($count_zadanie_pods, 'info');
            displayEventCount($count_obowiazek_pods, 'warning');
            
            
            $total = $count_sprawdzian_pods + $count_kartkowka_pods + $count_zadanie_pods + $count_obowiazek_pods;
            if ($total > 0) {
                echo '<div class="progress-stacked">
                    <div class="progress" role="progressbar" aria-label="Sprawdzian" aria-valuenow="' . $count_sprawdzian_pods . '" aria-valuemin="0" aria-valuemax="' . $total . '" style="width: ' . ($count_sprawdzian_pods / $total) * 100 . '%">
                        <div class="progress-bar">' . round(($count_sprawdzian_pods / $total) * 100) . '%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Kartkowka" aria-valuenow="' . $count_kartkowka_pods . '" aria-valuemin="0" aria-valuemax="' . $total . '" style="width: ' . ($count_kartkowka_pods / $total) * 100 . '%">
                        <div class="progress-bar bg-success">' . round(($count_kartkowka_pods / $total) * 100) . '%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Zadanie" aria-valuenow="' . $count_zadanie_pods . '" aria-valuemin="0" aria-valuemax="' . $total . '" style="width: ' . ($count_zadanie_pods / $total) * 100 . '%">
                        <div class="progress-bar bg-info">' . round(($count_zadanie_pods / $total) . 100) . '%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Obowiazek" aria-valuenow="' . $count_obowiazek_pods . '" aria-valuemin="0" aria-valuemax="' . $total . '" style="width: ' . ($count_obowiazek_pods / $total) * 100 . '%">
                        <div class="progress-bar bg-warning">' . round(($count_obowiazek_pods / $total) * 100) . '%</div>
                    </div>
                </div>';
            }
            
            ?>
        </div>
        </div>
    </div>
    </div>
    <!--  -->

    </div>
    <div class="calendar">Wydarzenia w tym Tygodniu:
        
    
        <?php
          $id = $_SESSION['id'];
          $nameDays = array(" ","Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota","Niedziela"); // od 0 zaczyna sie array!
          $rawDate = date("Y-m-d");
          $learnDates = $rawDate; // data do "DO ZROBIENIA"
          // $learnDatesInLoop = $rawDate;
          $learnDatesInLoop = date('Y-m-d',strtotime('Today'));
          
          $today = date('N', strtotime($rawDate)); 
          $i = 1;
          $k =1; // przypisuje id 
          $m = 0; // dodaje do daty
          $idInDB =1;
         
          $empty = 0; // 1 coś jest 0 pusto

          
            while($i <= 7){
             
              if($i==1){  // TU JEST IF ----------------------------------------------------------------------------------------------------------------
                    // NAUKA
                      echo "<div class='container'><div class='nameDay'>Dzisiaj&nbsp;".$learnDatesInLoop."</div>
                                <div class='toDo'>
                                  <div class='toDoW'>Do zrobienia</div>";        
                                
                                $j = 0; // liczni wykonanych informacji/komentarzy 
                                $addDay = 0;
                               
                                // $m = 0;
                                $info = mysqli_query($con,"SELECT `nazwa` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");
                                $startDate = mysqli_query($con,"SELECT `data_nauki` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");
                                
                                $comment = mysqli_query($con,"SELECT `komentarz` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");
                                $typ = mysqli_query($con,"SELECT `typ` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");
                                $importance = mysqli_query($con,"SELECT `waznosc` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");
                                $idDB = mysqli_query($con,"SELECT d.id FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");
                                $isMade= mysqli_query($con,"SELECT d.zrobione FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE();");

                                while($result = mysqli_fetch_row($idDB)){
                                  if(is_null($result)){
                                    $idDBT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $idDBT[] = implode($result);
                                  $empty = 1;
                                  
                                  
                                  }             
                                }
                                
                                
                                
                                while($result = mysqli_fetch_row($isMade)){
                                  if(is_null($result)){
                                    $isMadeT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $isMadeT[] = implode($result);
                                  $empty = 1;
                                  
                                  
                                  }             
                                }
                               
                               
                                while($result = mysqli_fetch_row($importance)){
                                  if(is_null($result)){
                                    $importanceT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $importanceT[] = implode($result);
                                  $empty = 1;
                                  
                                  
                                  }             
                                }
                          
                                
                                while($result = mysqli_fetch_row($typ)){
                                  if(is_null($result)){
                                    $typT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $typT[] = implode($result);
                                  $empty = 1;
                                  // print_r($typT);
                                  
                                  }             
                                }

                                $empty = 0;


                                while($result = mysqli_fetch_row($startDate)){
                                  if(is_null($result)){
                                    $sDateT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $sDateT[] = implode($result);
                                  $empty = 1;
                                  // print_r($sDateT);
                                  
                                  }             
                                }

                              

                                while($result = mysqli_fetch_row($info)){ 
                      
                                  if(is_null($result)){
                                    $infoT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $infoT[] = implode($result);
                                  $empty = 1;
                                  // print_r($infoT);
                                  
            
                                  }             
                                                 
                                                    
                                }
                                while($result = mysqli_fetch_row($comment)){ 
                                  
                                  if(is_null($result)){
                                     $commentT[] = '';
                                     $empty = 0; 
                                  }else{
                                  $commentT[] = implode($result);
                                  // print_r($commentT);
                                  $empty = 1;
                                  }      
                                                    
                                }
                             
                                if($empty == 1){
                                  $counter = count($infoT);
                                  // echo $counter;
                                }else{
                                  $counter = 0;
                                }
                                
                                  
                                    $j = 0;
                                   
                                    while($counter > $j){
                                      if($learnDatesInLoop == $sDateT[$j] ){
                                        $event_id = null;
                                        $updateQuery = null; 
                                      
                                        if($importanceT[$j] == "bardzo"){
                                          echo "<div class='infoB' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/red.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white;'>".$typT[$j]."</a></a>";
                                          
                                          if ($isMadeT[$j] == 0) {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                            echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                            echo '</form>';
                                        } else {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                            echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                            echo '</form>';
                                        }                        
                                                          // Check if the form has been submitted to mark an event as done
                                                          
                                            if (isset($_POST['mark_as_done'.$k])) {
                                            // Retrieve the event ID from the submitted form data
                                            $event_id = $_POST['event_id'];
              
                                            // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                            $updateQuery = "UPDATE daty_nauki SET zrobione = 1 WHERE id = $event_id ";
              
                                            // Execute the update query
                                            if (mysqli_query($con, $updateQuery)) {
                                                // The record has been updated successfully
                                                // You can add a success message or redirect the user as needed
                                                // Replace 'your_page.php' with the URL of the page you want to redirect to
                                                echo '<script>location.href = "kalendarz.php";</script>';
                                                exit;
                                            } else {
                                                // Handle any errors that may occur during the update
                                                echo "Error updating record: " . mysqli_error($con);
                                            }
                                        }
              
                                        // Check if the form has been submitted to mark an event as undone
                                        if (isset($_POST['mark_as_undone'.$k])) {
                                            // Retrieve the event ID from the submitted form data
                                            $event_id = $_POST['event_id'];
              
                                            // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                            $updateQuery = "UPDATE daty_nauki SET zrobione = 0 WHERE id = $event_id ";
              
                                            // Execute the update query
                                            if (mysqli_query($con, $updateQuery)) {
                                                // The record has been updated successfully
                                                // You can add a success message or redirect the user as needed
                                                echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                                exit;
                                            } else {
                                                // Handle any errors that may occur during the update
                                                echo "Error updating record: " . mysqli_error($con);
                                            }
                                        }
              
              
              
                                          
                                          echo " <div class='break'></div>
                                          <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                                          <div class='break'></div>
                                          <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                                        </div>";
                                        
                                        }
              
                                        // sredni
              
                                        if($importanceT[$j] == "srednio"){
                                          echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/yellow.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                                          
                                          if ($isMadeT[$j] == 0) {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                            echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                            echo '</form>';
                                        } else {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                            echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                            echo '</form>';
                                        }                        
                                       
                                        // Check if the form has been submitted to mark an event as done
                                          if (isset($_POST['mark_as_done'.$k])) {
                                            // Retrieve the event ID from the submitted form data
                                            $event_id = $_POST['event_id'];
              
                                            // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                            $updateQuery = "UPDATE daty_nauki SET zrobione = 1 WHERE id = $event_id ";
              
                                            // Execute the update query
                                            if (mysqli_query($con, $updateQuery)) {
                                                // The record has been updated successfully
                                                // You can add a success message or redirect the user as needed
                                                // Replace 'your_page.php' with the URL of the page you want to redirect to
                                                echo '<script>location.href = "kalendarz.php";</script>';
                                                // echo 'tst';
                                                exit;
                                            } else {
                                                // Handle any errors that may occur during the update
                                                echo "Error updating record: " . mysqli_error($con);
                                            }
                                        }
              
                                        // Check if the form has been submitted to mark an event as undone
                                        if (isset($_POST['mark_as_undone'.$k])) {
                                            // Retrieve the event ID from the submitted form data
                                            $event_id = $_POST['event_id'];
              
                                            // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                            $updateQuery = "UPDATE daty_nauki SET `zrobione` = 0 WHERE `id` = $event_id ";
              
                                            // Execute the update query
                                            if (mysqli_query($con, $updateQuery)) {
                                                // The record has been updated successfully
                                                // You can add a success message or redirect the user as needed
                                                echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                                // echo 'test';
                                                exit;
                                            } else {
                                                // Handle any errors that may occur during the update
                                                echo "Error updating record: " . mysqli_error($con);
                                            }
                                        }
              
              
              
                                          
                                          echo " <div class='break'></div>
                                          <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                                          <div class='break'></div>
                                          <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                                        </div>";
                                        
                                        }
              
                                        // malo
              
                                        if($importanceT[$j] == "malo"){
                                          echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/green.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                                          
                                          if ($isMadeT[$j] == 0) {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                            echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                            echo '</form>';
                                        } else {
                                            echo '<form method="post">';
                                            echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                            echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                            echo '</form>';
                                        }                        
                                       
                                        // Check if the form has been submitted to mark an event as done
                                          if (isset($_POST['mark_as_done'.$k])) {
                                            // Retrieve the event ID from the submitted form data
                                            $event_id = $_POST['event_id'];
              
                                            // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                            $updateQuery = "UPDATE daty_nauki SET `zrobione` = 1 WHERE `id` = $event_id ";
              
                                            // Execute the update query
                                            if (mysqli_query($con, $updateQuery)) {
                                                // The record has been updated successfully
                                                // You can add a success message or redirect the user as needed
                                                // Replace 'your_page.php' with the URL of the page you want to redirect to
                                                echo '<script>location.href = "kalendarz.php";</script>';
                                                exit;
                                            } else {
                                                // Handle any errors that may occur during the update
                                                echo "Error updating record: " . mysqli_error($con);
                                            }
                                        }
              
                                        // Check if the form has been submitted to mark an event as undone
                                        if (isset($_POST['mark_as_undone'.$k])) {
                                            // Retrieve the event ID from the submitted form data
                                            $event_id = $_POST['event_id'];
              
                                            // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                            $updateQuery = "UPDATE daty_nauki SET zrobione = 0 WHERE id = $event_id ";
              
                                            // Execute the update query
                                            if (mysqli_query($con, $updateQuery)) {
                                                // The record has been updated successfully
                                                // You can add a success message or redirect the user as needed
                                                echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                                exit;
                                            } else {
                                                // Handle any errors that may occur during the update
                                                echo "Error updating record: " . mysqli_error($con);
                                            }
                                        }
              
              
              
                                          
                                          echo " <div class='break'></div>
                                          <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                                          <div class='break'></div>
                                          <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                                        </div>";
                                        
                                        }
                                      }
              
                                    
                                    $idInDB++;
                                    $k++;
                                    $j++;
                                    
                                   }
                                     
                              
                             echo   "</div> <div class='events'>
                                <div class='eventsW'>Wydarzenia</div>";
                    // WYDARZENIA-------------------------------------------------------------------------------------------
                    
                    $empty =0;
                    $infoT = null;
                    $commentT =null;
                    $counter = null;                   
                      $importance = null;
                    $importanceT = null;
                    $idInDB = 1;
                    $typ = null;
                    $typT = null;
                    $isMade = null; 
                    $isMadeT = null;
                    $idDB = null;
                    $idDBT=null; 
                    $j = 0; // liczni wykonanych informacji/komentarzy (licznik do while)
                    $addDay = 0;
                    $info = mysqli_query($con,"SELECT nazwa from wydarzenia WHERE user_id = $id AND `data` = CURDATE()+$addDay  AND `typ` NOT LIKE 'obowiazek' ;");                    
                    $comment = mysqli_query($con,"SELECT `komentarz` FROM `wydarzenia` WHERE `user_id` = $id AND `data` = CURDATE()+$addDay  AND `typ` NOT LIKE 'obowiazek' ;");
                    $typ = mysqli_query($con,"SELECT `typ` FROM `wydarzenia` WHERE user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay;");
                    $importance = mysqli_query($con,"SELECT `waznosc` FROM `wydarzenia` WHERE user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay ;");
                    $isMade = mysqli_query($con,"SELECT `zrobione` FROM `wydarzenia` WHERE user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay;");
                    $idDB = mysqli_query($con,"SELECT `id` from `wydarzenia` WHERE `user_id` = $id AND `data` = CURDATE()+$addDay AND `typ` NOT LIKE 'obowiazek';");
                    
                    while($result = mysqli_fetch_row($idDB)){
                      if(is_null($result)){
                      $idDBT[] = '';
                      $empty = 0;                        
                        }else{
                         $idDBT[] = implode($result);
                         $empty = 1;
                                    // print_r($idDBT);     
                                         
                         }             
                     }
                   
                   
                   
                    while($result = mysqli_fetch_row($isMade)){
                      if(is_null($result)){
                      $isMadeT[] = '';
                      $empty = 0;                        
                        }else{
                         $isMadeT[] = implode($result);
                         $empty = 1;
                                         
                                         
                         }             
                     }
                    
                      while($result = mysqli_fetch_row($importance)){
                           if(is_null($result)){
                           $importanceT[] = '';
                           $empty = 0;                        
                             }else{
                              $importanceT[] = implode($result);
                              $empty = 1;
                                              
                                              
                              }             
                          }

                          
                                
                                while($result = mysqli_fetch_row($typ)){
                                  if(is_null($result)){
                                    $typT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $typT[] = implode($result);
                                  $empty = 1;
                                  // print_r($typT);
                                  
                                  }             
                                }

                                $empty = 0;
                                                            
                    // $counter=mysql_fetch_assoc($infoCounter);                                 
                   
                    while($result = mysqli_fetch_row($info)){ 
                      
                      if(is_null($result)){
                        $infoT[] = '';
                        $empty = 0;
                        

                      }else{
                      $infoT[] = implode($result);
                     
                      $empty = 1;

                      }             
                                     
                                        
                    }
                    while($result = mysqli_fetch_row($comment)){ 
                      
                      if(is_null($result)){
                         $commentT[] = '';
                         $empty = 0; 
                         
                      }else{
                      $commentT[] = implode($result);
                      
                      $empty = 1;
                      }      
                                        
                    }
                 
                    if($empty == 1){
                      $counter = count($infoT);
                    }else{
                      $counter = 0;
                    }
                     

                    while($counter > $j){
                        $event_id = null; // PAMIETAJ ------------------------------------------------------------------------------------------------------------
                          
                          if($importanceT[$j] == "bardzo"){
                            echo "<div class='infoB' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/red.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                            
                            if ($isMadeT[$j] == 0) {
                              echo '<form method="post">';
                              echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                              echo '<button class="readyBtn" name="mark_as_done" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                              echo '</form>';
                          } else {
                              echo '<form method="post">';
                              echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                              echo '<button class="readyBtn" name="mark_as_undone" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                              echo '</form>';
                          }                        
                                            // Check if the form has been submitted to mark an event as done
                                            
                              if (isset($_POST['mark_as_done'])) {
                              // Retrieve the event ID from the submitted form data
                              $event_id = $_POST['event_id'];

                              // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                              $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";

                              // Execute the update query
                              if (mysqli_query($con, $updateQuery)) {
                                  // The record has been updated successfully
                                  // You can add a success message or redirect the user as needed
                                  // Replace 'your_page.php' with the URL of the page you want to redirect to
                                  echo '<script>location.href = "kalendarz.php";</script>';
                                  exit;
                              } else {
                                  // Handle any errors that may occur during the update
                                  echo "Error updating record: " . mysqli_error($con);
                              }
                          }

                          // Check if the form has been submitted to mark an event as undone
                          if (isset($_POST['mark_as_undone'])) {
                              // Retrieve the event ID from the submitted form data
                              $event_id = $_POST['event_id'];

                              // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                              $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";

                              // Execute the update query
                              if (mysqli_query($con, $updateQuery)) {
                                  // The record has been updated successfully
                                  // You can add a success message or redirect the user as needed
                                  echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                  exit;
                              } else {
                                  // Handle any errors that may occur during the update
                                  echo "Error updating record: " . mysqli_error($con);
                              }
                          }



                            
                            echo " <div class='break'></div>
                            <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                            <div class='break'></div>
                            <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                          </div>";
                          
                          }

                          // sredni

                          if($importanceT[$j] == "srednio"){
                            echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/yellow.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                            
                            if ($isMadeT[$j] == 0) {
                              echo '<form method="post">';
                              echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                              echo '<button class="readyBtn" name="mark_as_done" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                              echo '</form>';
                          } else {
                              echo '<form method="post">';
                              echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                              echo '<button class="readyBtn" name="mark_as_undone" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                              echo '</form>';
                          }                        
                         
                          // Check if the form has been submitted to mark an event as done
                            if (isset($_POST['mark_as_done'])) {
                              // Retrieve the event ID from the submitted form data
                              $event_id = $_POST['event_id'];

                              // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                              $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";

                              // Execute the update query
                              if (mysqli_query($con, $updateQuery)) {
                                  // The record has been updated successfully
                                  // You can add a success message or redirect the user as needed
                                  // Replace 'your_page.php' with the URL of the page you want to redirect to
                                  echo '<script>location.href = "kalendarz.php";</script>';
                                  exit;
                              } else {
                                  // Handle any errors that may occur during the update
                                  echo "Error updating record: " . mysqli_error($con);
                              }
                          }

                          // Check if the form has been submitted to mark an event as undone
                          if (isset($_POST['mark_as_undone'])) {
                              // Retrieve the event ID from the submitted form data
                              $event_id = $_POST['event_id'];

                              // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                              $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";

                              // Execute the update query
                              if (mysqli_query($con, $updateQuery)) {
                                  // The record has been updated successfully
                                  // You can add a success message or redirect the user as needed
                                  echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                  exit;
                              } else {
                                  // Handle any errors that may occur during the update
                                  echo "Error updating record: " . mysqli_error($con);
                              }
                          }



                            
                            echo " <div class='break'></div>
                            <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                            <div class='break'></div>
                            <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                          </div>";
                          
                          }

                          // malo

                          if($importanceT[$j] == "malo"){
                            echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/green.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                            
                            if ($isMadeT[$j] == 0) {
                              echo '<form method="post">';
                              echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                              echo '<button class="readyBtn" name="mark_as_done" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                              echo '</form>';
                          } else {
                              echo '<form method="post">';
                              echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                              echo '<button class="readyBtn" name="mark_as_undone" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                              echo '</form>';
                          }                        
                         
                          // Check if the form has been submitted to mark an event as done
                            if (isset($_POST['mark_as_done'])) {
                              // Retrieve the event ID from the submitted form data
                              $event_id = $_POST['event_id'];

                              // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                              $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";

                              // Execute the update query
                              if (mysqli_query($con, $updateQuery)) {
                                  // The record has been updated successfully
                                  // You can add a success message or redirect the user as needed
                                  // Replace 'your_page.php' with the URL of the page you want to redirect to
                                  echo '<script>location.href = "kalendarz.php";</script>';
                                  exit;
                              } else {
                                  // Handle any errors that may occur during the update
                                  echo "Error updating record: " . mysqli_error($con);
                              }
                          }

                          // Check if the form has been submitted to mark an event as undone
                          if (isset($_POST['mark_as_undone'])) {
                              // Retrieve the event ID from the submitted form data
                              $event_id = $_POST['event_id'];

                              // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                              $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";

                              // Execute the update query
                              if (mysqli_query($con, $updateQuery)) {
                                  // The record has been updated successfully
                                  // You can add a success message or redirect the user as needed
                                  echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                  exit;
                              } else {
                                  // Handle any errors that may occur during the update
                                  echo "Error updating record: " . mysqli_error($con);
                              }
                          }



                            
                            echo " <div class='break'></div>
                            <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                            <div class='break'></div>
                            <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                          </div>";
                          
                          }


                      
                      $idInDB++;
                      $k++;
                      $j++;
                      
                     }
                
              echo  "</div>
                </div>";

                $i++;
                $addDay = 1;
              
                
        
              }         // w else reszta ------------------------------------------------------------------------------------------------
              else{
                $learnDatesInLoop = date('Y-m-d', strtotime("+".$m." day"));
                // echo $learnDatesInLoop;
                $j = 0;
                $idInDB = 1;
                $empty =0;
                $infoT = null;
                $commentT =null;
                $counter = null;
                $sDateT = null;
                $eDateT = null;
                $typ = null;
                $typT = null;
                $importanceT = null;
                $importance = null;
                $isMadeT = null;
                $idDBT = null;


                echo "<div class='container'><div class='nameDay'>".$nameDays[$today]."&nbsp;".$learnDatesInLoop."</div>
                    <div class='toDo'>
                      <div class='toDoW'>Do zrobienia</div>";         
                     
                           
                      $j = 0; // liczni wykonanych informacji/komentarzy (licznik do while)
                      
                     
                 
                      
                      $info = mysqli_query($con,"SELECT `nazwa` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");
                      $startDate = mysqli_query($con,"SELECT `data_nauki` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");
                      // $endDate = mysqli_query($con,"SELECT `data` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek';");
                      $comment = mysqli_query($con,"SELECT `komentarz` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");
                      $typ = mysqli_query($con,"SELECT `typ` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");
                      $importance = mysqli_query($con,"SELECT `waznosc` FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");
                      $idDB = mysqli_query($con,"SELECT d.id FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");
                      $isMade= mysqli_query($con,"SELECT d.zrobione FROM `daty_nauki` d ,`wydarzenia` w WHERE d.wydarzenie_id=w.id AND user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data_nauki` = CURDATE()+$addDay;");

                      while($result = mysqli_fetch_row($idDB)){
                        if(is_null($result)){
                          $idDBT[] = '';
                          $empty = 0;
  
                        }else{
                        $idDBT[] = implode($result);
                        $empty = 1;
                        
                        
                        }             
                      }
                      
                      
                      
                      while($result = mysqli_fetch_row($isMade)){
                        if(is_null($result)){
                          $isMadeT[] = '';
                          $empty = 0;
  
                        }else{
                        $isMadeT[] = implode($result);
                        $empty = 1;
                        
                        
                        }             
                      }
                    
                  
                                  while($result = mysqli_fetch_row($importance)){
                                    if(is_null($result)){
                                      $importanceT[] = '';
                                      $empty = 0;
              
                                    }else{
                                    $importanceT[] = implode($result);
                                    $empty = 1;
                                    
                                    
                                    }             
                                  }
                                
                          
                                
                                while($result = mysqli_fetch_row($typ)){
                                  if(is_null($result)){
                                    $typT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $typT[] = implode($result);
                                  $empty = 1;
                                  // print_r($typT);
                                  
                                  }             
                                }

                                $empty = 0;
                    
                      while($result = mysqli_fetch_row($startDate)){
                        if(is_null($result)){
                          $sDateT[] = '';
                          $empty = 0;
  
                        }else{
                        $sDateT[] = implode($result);
                        $empty = 1;
                        // print_r($sDateT);
                        
                        }             
                      }

                      // while($result = mysqli_fetch_row($endDate)){
                      //   if(is_null($result)){
                      //     $eDateT[] = '';
                      //     $empty = 0;
  
                      //   }else{
                      //   $eDateT[] = implode($result);
                      //   $empty = 1;
                      //   // print_r($eDateT);
                        
                      //   }             
                      // }

                      while($result = mysqli_fetch_row($info)){ 
            
                        if(is_null($result)){
                          $infoT[] = '';
                          $empty = 0;
  
                        }else{
                        $infoT[] = implode($result);
                        $empty = 1;
                        // print_r($infoT);
                        
  
                        }             
                                       
                                          
                      }
                      while($result = mysqli_fetch_row($comment)){ 
                        
                        if(is_null($result)){
                           $commentT[] = '';
                           $empty = 0; 
                        }else{
                        $commentT[] = implode($result);
                        // print_r($commentT);
                        $empty = 1;
                        }      
                                          
                      }
                   
                      if($empty == 1){
                        $counter = count($infoT);
                        // echo $counter;
                      }else{
                        $counter = 0;
                      }
                      
                        
                          $j = 0;
                         

                            
                           
                              // echo '<br>'.$learnDates;
                              while($counter > $j){
                           
                                if(!empty($sDateT[$j])){
                                  if($learnDatesInLoop == $sDateT[$j]){
                                    
                                    $event_id = null;
                                    $updateQuery = null; 
                                  
                                    if($importanceT[$j] == "bardzo"){
                                      echo "<div class='infoB' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/red.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                                      
                                      if ($isMadeT[$j] == 0) {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                        echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                        echo '</form>';
                                    } else {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                        echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                        echo '</form>';
                                    }                        
                                                      // Check if the form has been submitted to mark an event as done
                                                      
                                        if (isset($_POST['mark_as_done'.$k])) {
                                        // Retrieve the event ID from the submitted form data
                                        $event_id = $_POST['event_id'];
          
                                        // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                        $updateQuery = "UPDATE daty_nauki SET zrobione = 1 WHERE id = $event_id ";
          
                                        // Execute the update query
                                        if (mysqli_query($con, $updateQuery)) {
                                            // The record has been updated successfully
                                            // You can add a success message or redirect the user as needed
                                            // Replace 'your_page.php' with the URL of the page you want to redirect to
                                            echo '<script>location.href = "kalendarz.php";</script>';
                                            exit;
                                        } else {
                                            // Handle any errors that may occur during the update
                                            echo "Error updating record: " . mysqli_error($con);
                                        }
                                    }
          
                                    // Check if the form has been submitted to mark an event as undone
                                    if (isset($_POST['mark_as_undone'.$k])) {
                                        // Retrieve the event ID from the submitted form data
                                        $event_id = $_POST['event_id'];
          
                                        // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                        $updateQuery = "UPDATE daty_nauki SET zrobione = 0 WHERE id = $event_id ";
          
                                        // Execute the update query
                                        if (mysqli_query($con, $updateQuery)) {
                                            // The record has been updated successfully
                                            // You can add a success message or redirect the user as needed
                                            echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                            exit;
                                        } else {
                                            // Handle any errors that may occur during the update
                                            echo "Error updating record: " . mysqli_error($con);
                                        }
                                    }
          
          
          
                                      
                                      echo " <div class='break'></div>
                                      <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                                      <div class='break'></div>
                                      <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                                    </div>";
                                    
                                    }
          
                                    // sredni
          
                                    if($importanceT[$j] == "srednio"){
                                      echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/yellow.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                                      
                                      if ($isMadeT[$j] == 0) {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                        echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                        echo '</form>';
                                    } else {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                        echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                        echo '</form>';
                                    }                        
                                   
                                    // Check if the form has been submitted to mark an event as done
                                      if (isset($_POST['mark_as_done'.$k])) {
                                        // Retrieve the event ID from the submitted form data
                                        $event_id = $_POST['event_id'];
          
                                        // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                        $updateQuery = "UPDATE daty_nauki SET zrobione = 1 WHERE id = $event_id ";
          
                                        // Execute the update query
                                        if (mysqli_query($con, $updateQuery)) {
                                            // The record has been updated successfully
                                            // You can add a success message or redirect the user as needed
                                            // Replace 'your_page.php' with the URL of the page you want to redirect to
                                            echo '<script>location.href = "kalendarz.php";</script>';
                                            // echo 'tst';
                                            exit;
                                        } else {
                                            // Handle any errors that may occur during the update
                                            echo "Error updating record: " . mysqli_error($con);
                                        }
                                    }
          
                                    // Check if the form has been submitted to mark an event as undone
                                    if (isset($_POST['mark_as_undone'.$k])) {
                                        // Retrieve the event ID from the submitted form data
                                        $event_id = $_POST['event_id'];
          
                                        // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                        $updateQuery = "UPDATE daty_nauki SET `zrobione` = 0 WHERE `id` = $event_id ";
          
                                        // Execute the update query
                                        if (mysqli_query($con, $updateQuery)) {
                                            // The record has been updated successfully
                                            // You can add a success message or redirect the user as needed
                                            echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                            // echo 'test';
                                            exit;
                                        } else {
                                            // Handle any errors that may occur during the update
                                            echo "Error updating record: " . mysqli_error($con);
                                        }
                                    }
          
          
          
                                      
                                      echo " <div class='break'></div>
                                      <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                                      <div class='break'></div>
                                      <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                                    </div>";
                                    
                                    }
          
                                    // malo
          
                                    if($importanceT[$j] == "malo"){
                                      echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/green.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                                      
                                      if ($isMadeT[$j] == 0) {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                        echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                        echo '</form>';
                                    } else {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                        echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                        echo '</form>';
                                    }                        
                                   
                                    // Check if the form has been submitted to mark an event as done
                                      if (isset($_POST['mark_as_done'.$k])) {
                                        // Retrieve the event ID from the submitted form data
                                        $event_id = $_POST['event_id'];
          
                                        // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                        $updateQuery = "UPDATE daty_nauki SET `zrobione` = 1 WHERE `id` = $event_id ";
          
                                        // Execute the update query
                                        if (mysqli_query($con, $updateQuery)) {
                                            // The record has been updated successfully
                                            // You can add a success message or redirect the user as needed
                                            // Replace 'your_page.php' with the URL of the page you want to redirect to
                                            echo '<script>location.href = "kalendarz.php";</script>';
                                            exit;
                                        } else {
                                            // Handle any errors that may occur during the update
                                            echo "Error updating record: " . mysqli_error($con);
                                        }
                                    }
          
                                    // Check if the form has been submitted to mark an event as undone
                                    if (isset($_POST['mark_as_undone'.$k])) {
                                        // Retrieve the event ID from the submitted form data
                                        $event_id = $_POST['event_id'];
          
                                        // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                        $updateQuery = "UPDATE daty_nauki SET zrobione = 0 WHERE id = $event_id ";
          
                                        // Execute the update query
                                        if (mysqli_query($con, $updateQuery)) {
                                            // The record has been updated successfully
                                            // You can add a success message or redirect the user as needed
                                            echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                            exit;
                                        } else {
                                            // Handle any errors that may occur during the update
                                            echo "Error updating record: " . mysqli_error($con);
                                        }
                                    }
          
          
          
                                      
                                      echo " <div class='break'></div>
                                      <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                                      <div class='break'></div>
                                      <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                                    </div>";
                                    
                                    }
                                    
                                  }
                                }
                                $k++;
                                $j++;                                
                                $idInDB++;
                              }
                            // $learnDates = date('Y-m-d', strtotime("+1 day"));
                            // echo $learnDates;
          
                      // wydarzenia ------------------------------------------------------------------------------------------------------
                   echo   "</div> <div class='events'>
                      <div class='eventsW'>Wydarzenia</div>";
                      $j = 0;
                      $jII = 0;
                      $idInDB = 1;                      
                      $empty =0;
                      $infoT = null;
                      $commentT =null;
                      $counter = null;
                      $sDateT = null;
                      // $eDateT = null;
                      $importanceT = null;
                      $importance = null;
                      $typT  =null;
                      $typ = null;
                      $idDB = null;
                      $idDBT = null;
                      $isMade = null;
                      $isMadeT = null;
                      $event_id = null;
                      // echo $addDay;
                          $info = mysqli_query($con,"SELECT nazwa from wydarzenia WHERE user_id = $id AND `data` = CURDATE()+$addDay AND `typ` NOT LIKE 'obowiazek';");                    
                          $comment = mysqli_query($con,"SELECT `komentarz` FROM `wydarzenia` WHERE `user_id` = $id AND `data` = CURDATE()+$addDay AND `typ` NOT LIKE 'obowiazek';");
                          $typ = mysqli_query($con,"SELECT `typ` FROM `wydarzenia` WHERE user_id = $id AND `typ` NOT LIKE 'obowiazek'AND `data` = CURDATE()+$addDay;");
                          $importance = mysqli_query($con,"SELECT `waznosc` FROM `wydarzenia` WHERE user_id = $id AND `typ` NOT LIKE 'obowiazek' AND 
                          `data` = CURDATE()+$addDay ;");
                            $isMade = mysqli_query($con,"SELECT `zrobione` FROM `wydarzenia` WHERE user_id = $id AND `typ` NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay;");
                            $idDB = mysqli_query($con,"SELECT `id` from `wydarzenia` WHERE `user_id` = $id AND `data` = CURDATE()+$addDay AND `typ` NOT LIKE 'obowiazek';");
                            
                            while($result = mysqli_fetch_row($idDB)){
                              if(is_null($result)){
                              $idDBT[] = '';
                              $empty = 0;                        
                                }else{
                                 $idDBT[] = implode($result);
                                 $empty = 1;
                                            // print_r($idDBT);     
                                                 
                                 }             
                             }
                           
                           
                           
                            while($result = mysqli_fetch_row($isMade)){
                              if(is_null($result)){
                              $isMadeT[] = '';
                              $empty = 0;                        
                                }else{
                                 $isMadeT[] = implode($result);
                                 $empty = 1;
                                  // print_r($isMadeT);
                                                 
                                 }             
                             }
                                                     
                            
                          while($result = mysqli_fetch_row($importance)){
                               if(is_null($result)){
                               $importanceT[] = '';
                               $empty = 0;                        
                                 }else{
                                  $importanceT[] = implode($result);
                                  $empty = 1;
                                  
                                                  
                                                  
                                  }             
                              }
                          
                                
                                while($result = mysqli_fetch_row($typ)){
                                  if(is_null($result)){
                                    $typT[] = '';
                                    $empty = 0;
            
                                  }else{
                                  $typT[] = implode($result);
                                  $empty = 1;
                                  // print_r($typT);
                                  
                                  }             
                                }

                                $empty = 0;
                                                                  
                          // $counter=mysql_fetch_assoc($infoCounter);                                 
                        
                          
                          while($result = mysqli_fetch_row($info)){ 
                      
                            if(is_null($result)){
                              $infoT[] = '';
                              $empty = 0;
      
                            }else{
                            $infoT[] = implode($result);
                            $empty = 1;
      
                            }             
                                           
                                              
                          }
                          while($result = mysqli_fetch_row($comment)){ 
                            
                            if(is_null($result)){
                               $commentT[] = '';
                               $empty = 0; 
                            }else{
                            $commentT[] = implode($result);
                            $empty = 1;
                            }      
                                              
                          }
                       
                          if($empty == 1){
                            $counter = count($infoT);
                          }else{
                            $counter = null;
                          }
                          
                          while($counter > $j){
                           
                            
                            $event_id = null;
                            $updateQuery = null; 
                          
                            if($importanceT[$j] == "bardzo"){
                              echo "<div class='infoB' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/red.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                              
                              if ($isMadeT[$j] == 0) {
                                echo '<form method="post">';
                                echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                echo '</form>';
                            } else {
                                echo '<form method="post">';
                                echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                echo '</form>';
                            }                        
                                              // Check if the form has been submitted to mark an event as done
                                              
                                if (isset($_POST['mark_as_done'.$k])) {
                                // Retrieve the event ID from the submitted form data
                                $event_id = $_POST['event_id'];
  
                                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";
  
                                // Execute the update query
                                if (mysqli_query($con, $updateQuery)) {
                                    // The record has been updated successfully
                                    // You can add a success message or redirect the user as needed
                                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                                    echo '<script>location.href = "kalendarz.php";</script>';
                                    exit;
                                } else {
                                    // Handle any errors that may occur during the update
                                    echo "Error updating record: " . mysqli_error($con);
                                }
                            }
  
                            // Check if the form has been submitted to mark an event as undone
                            if (isset($_POST['mark_as_undone'.$k])) {
                                // Retrieve the event ID from the submitted form data
                                $event_id = $_POST['event_id'];
  
                                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";
  
                                // Execute the update query
                                if (mysqli_query($con, $updateQuery)) {
                                    // The record has been updated successfully
                                    // You can add a success message or redirect the user as needed
                                    echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                    exit;
                                } else {
                                    // Handle any errors that may occur during the update
                                    echo "Error updating record: " . mysqli_error($con);
                                }
                            }
  
  
  
                              
                              echo " <div class='break'></div>
                              <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                              <div class='break'></div>
                              <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                            </div>";
                            
                            }
  
                            // sredni
  
                            if($importanceT[$j] == "srednio"){
                              echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/yellow.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                              
                              if ($isMadeT[$j] == 0) {
                                echo '<form method="post">';
                                echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                echo '</form>';
                            } else {
                                echo '<form method="post">';
                                echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                echo '</form>';
                            }                        
                           
                            // Check if the form has been submitted to mark an event as done
                              if (isset($_POST['mark_as_done'.$k])) {
                                // Retrieve the event ID from the submitted form data
                                $event_id = $_POST['event_id'];
  
                                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";
  
                                // Execute the update query
                                if (mysqli_query($con, $updateQuery)) {
                                    // The record has been updated successfully
                                    // You can add a success message or redirect the user as needed
                                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                                    echo '<script>location.href = "kalendarz.php";</script>';
                                    // echo 'tst';
                                    exit;
                                } else {
                                    // Handle any errors that may occur during the update
                                    echo "Error updating record: " . mysqli_error($con);
                                }
                            }
  
                            // Check if the form has been submitted to mark an event as undone
                            if (isset($_POST['mark_as_undone'.$k])) {
                                // Retrieve the event ID from the submitted form data
                                $event_id = $_POST['event_id'];
  
                                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                $updateQuery = "UPDATE `wydarzenia` SET `zrobione` = 0 WHERE `id` = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";
  
                                // Execute the update query
                                if (mysqli_query($con, $updateQuery)) {
                                    // The record has been updated successfully
                                    // You can add a success message or redirect the user as needed
                                    echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                    // echo 'test';
                                    exit;
                                } else {
                                    // Handle any errors that may occur during the update
                                    echo "Error updating record: " . mysqli_error($con);
                                }
                            }
  
  
  
                              
                              echo " <div class='break'></div>
                              <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                              <div class='break'></div>
                              <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                            </div>";
                            
                            }
  
                            // malo
  
                            if($importanceT[$j] == "malo"){
                              echo "<div class='infoS' id='Info".$k."' onclick=\" infomation('Info".$k."'); comment('".$k."')\"><img src='img/green.png' width='30vw' height='auto'><a class='text1'>".$infoT[$j]."<a class='text' style='color:white; '>".$typT[$j]."</a></a>";
                              
                              if ($isMadeT[$j] == 0) {
                                echo '<form method="post">';
                                echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                echo '<button class="readyBtn" name="mark_as_done'.$k.'" type="submit" id="form">Niezrobione&nbsp;<img src="img/cross.png" width="30vw" height="auto"></button>';
                                echo '</form>';
                            } else {
                                echo '<form method="post">';
                                echo '<input type="hidden" name="event_id" value="'.$idDBT[$j].'">';
                                echo '<button class="readyBtn" name="mark_as_undone'.$k.'" type="submit" id="form">Zrobione&nbsp;<img src="img/check.png" width="30vw" height="auto"></button>';
                                echo '</form>';
                            }                        
                           
                            // Check if the form has been submitted to mark an event as done
                              if (isset($_POST['mark_as_done'.$k])) {
                                // Retrieve the event ID from the submitted form data
                                $event_id = $_POST['event_id'];
  
                                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                                $updateQuery = "UPDATE `wydarzenia` SET `zrobione` = 1 WHERE `id` = $event_id AND `typ` NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";
  
                                // Execute the update query
                                if (mysqli_query($con, $updateQuery)) {
                                    // The record has been updated successfully
                                    // You can add a success message or redirect the user as needed
                                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                                    echo '<script>location.href = "kalendarz.php";</script>';
                                    exit;
                                } else {
                                    // Handle any errors that may occur during the update
                                    echo "Error updating record: " . mysqli_error($con);
                                }
                            }
  
                            // Check if the form has been submitted to mark an event as undone
                            if (isset($_POST['mark_as_undone'.$k])) {
                                // Retrieve the event ID from the submitted form data
                                $event_id = $_POST['event_id'];
  
                                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 0 for the specified event
                                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id AND typ NOT LIKE 'obowiazek' AND `data` = CURDATE()+$addDay";
  
                                // Execute the update query
                                if (mysqli_query($con, $updateQuery)) {
                                    // The record has been updated successfully
                                    // You can add a success message or redirect the user as needed
                                    echo '<script>location.href = "kalendarz.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                                    exit;
                                } else {
                                    // Handle any errors that may occur during the update
                                    echo "Error updating record: " . mysqli_error($con);
                                }
                            }
  
  
  
                              
                              echo " <div class='break'></div>
                              <a style='font-size:1.7vh; color:white; margin-left:0.5vh;'>Kliknij, aby schować/pokazać komentarz</a>             
                              <div class='break'></div>
                              <div class='comment' id='".$k."'>Komentarz:&nbsp;".$commentT[$j]."</div>                                              
                            </div>";
                            
                            }
  
                           
                      
                      $idInDB++;
                      $k++;
                      $j++;
                      // $jII++;
                           
                           }
                        echo  "</div>
                          </div>";
           
                        $i++;
                        $j = 0;
                        $addDay++;
                
              } 

            $today++;
            $m++;
   
            if($today >= 8){
             $today = 1;
            }
    
            // $i++;
            }
 
        ?>
       
        </div>          
    
      </div>  
      <footer></footer>
      
      </body>
<script>
  let szerokoscOkna = window.innerWidth;
  monitorujISkorygujSzerokoscOkna();
  window.addEventListener('resize', monitorujISkorygujSzerokoscOkna);
  
  let width = 0;
 let timer;
 let active =0;
 
 
 let dd; // zmienna przechowywująca danego kafelka;
 let oDd;
 
    // let id = 0;
    
 let mybutton = document.getElementById("goUpBtn");
 document.onmousemove = function() {

 

  // document.getElementById('myBtn').style.display = "block";

  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
     mybutton.style.visibility = "visible";
     mybutton.style.opacity = "1";
     // console.log(timer);
     clearTimeout(timer);
     
   } 
   else {
     mybutton.style.visibility = "hidden";   
     mybutton.style.opacity = "0";           
   }

timer = setTimeout(function() {
//  console.log("timer")
 mybutton.style.visibility = "hidden";   
 mybutton.style.opacity = "0"; 
}, 2600);
};


 function topFunction() {
   document.body.scrollTop = 0;
   document.documentElement.scrollTop = 0;
 }
 
 
 //funkcja od wylogowywania sie

function alert(){
    Swal.fire({
  title: 'Jesteś pewien?',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Tak',
  cancelButtonText: 'Nie'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      location.href = "logout.php"
    )
    
  }
})
    }
document.getElementById('normalny').addEventListener('click',function(){
    alert('Alert zwykly')
})




        function goToDodawanie(){
        location.href = "dodawanie.php";
    }
   
  function goto2(){
    location.href = "kalendarz2.php";
  }
  function goto1(){
    location.href = "kalendarz.php";
  }
  function goto3(){
    location.href = "kalendarz3.php";
  }

  function monitorujISkorygujSzerokoscOkna() {
  szerokoscOkna = window.innerWidth;
  console.log('Aktualna szerokość okna: ' + szerokoscOkna + ' pikseli');
}

// Wywołanie funkcji na początku


// Dodanie obsługi zdarzenia 'resize'



  function comment(i){
      console.log(i);
      
     if (active==0)
     {
      document.getElementById(i).style.visibility='visible';
      document.getElementById(i).style.opacity='1';
      
 
       
       window.event.stopPropagation();
       dd = i;
       active = 1;
    }
    else{
      
     if(szerokoscOkna >= 900){
      document.getElementById(dd).style.visibility='hidden';
      document.getElementById(dd).style.opacity='0'; 
      document.getElementById(`Info${dd}`).style.maxHeight="12vh";
     }else{

      document.getElementById(dd).style.visibility='hidden';
      document.getElementById(dd).style.opacity='0'; 
      document.getElementById(`Info${dd}`).style.maxHeight="31vh";

     } 
    
       
      // active = 0;
      
      // document.getElementById(`Info${dd}`).style.height="10vh";
      
      if(dd != i){
        dd = i;
      }else{
        dd = null;
      }
      
      active = 0;
      // console.log('ELSE');
      // console.log(i);     
      
      commentAfter();
      
      
      
      
      
      
    }
  }
     

     function commentAfter(){
      
      
     if (active==0)
     {
      
      window.event.stopPropagation();
      document.getElementById(dd).style.visibility='visible';
      document.getElementById(dd).style.opacity='1';
   
       active = 1;
    }
    else{
     
      if(szerokoscOkna >= 900){
      document.getElementById(dd).style.visibility='hidden';
      document.getElementById(dd).style.opacity='0'; 
      document.getElementById(`Info${dd}`).style.maxHeight="12vh";
     }else{

      document.getElementById(dd).style.visibility='hidden';
      document.getElementById(dd).style.opacity='0'; 
      document.getElementById(`Info${dd}`).style.maxHeight="31vh";

     } 
      
      if(dd != i){
        dd = i;
      }else{
        dd = null;
      }

      active = 0;

      console.log('ELSE2');
      console.log(i);
      
     
        commentAfter();
      
      
      
    }
    
  }
 
    
     function infomation(i){
      document.getElementById(i).style.maxHeight="300vh";
      document.getElementById(i).style.height="auto";
    }
   
   

    function collapseAll(){
      
      if (active == 1){
        
        console.log('Collapse ->')
        console.log(dd)

        if(szerokoscOkna >= 900){
      document.getElementById(dd).style.visibility='hidden';
      document.getElementById(dd).style.opacity='0'; 
      document.getElementById(`Info${dd}`).style.maxHeight="12vh";
     }else{

      document.getElementById(dd).style.visibility='hidden';
      document.getElementById(dd).style.opacity='0'; 
      document.getElementById(`Info${dd}`).style.maxHeight="30vh";

     } 
      // document.getElementById(`Info${dd}`).style.height="10vh";
      // dd = null;
      active= 0;
   
      
      }
       
  
   }
   
  </script>
 
</html>