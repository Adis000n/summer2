<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">       
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
$id = $_SESSION["id"];
$sql1 = "SELECT * FROM wydarzenia WHERE user_id = $id AND typ = 'obowiazek' AND `data` = CURDATE() ";
$result1 = $con->query($sql1);
$sql2 = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND `data` = DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";
$result2 = $con->query($sql2);
$sql3 = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND `data` = DATE_ADD(CURDATE(), INTERVAL 2 DAY) ";
$result3 = $con->query($sql3);
$sql4 = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND `data` = DATE_ADD(CURDATE(), INTERVAL 3 DAY) ";
$result4 = $con->query($sql4);
$sql5 = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND `data` = DATE_ADD(CURDATE(), INTERVAL 4 DAY) ";
$result5 = $con->query($sql5);
$sql6 = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND `data` = DATE_ADD(CURDATE(), INTERVAL 5 DAY) ";
$result6 = $con->query($sql6);
$sql7 = "SELECT * FROM wydarzenia WHERE typ = 'obowiazek' AND `data` = DATE_ADD(CURDATE(), INTERVAL 6 DAY) ";
$result7 = $con->query($sql7);

$days = ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"];

// Get the current date
$currentDate = new DateTime();

// Create variables for the names of the next 7 days
$dzien1 = "Dzisiaj";
$dzien2 = $days[$currentDate->modify('+1 day')->format('w')];
$dzien3 = $days[$currentDate->modify('+1 day')->format('w')];
$dzien4 = $days[$currentDate->modify('+1 day')->format('w')];
$dzien5 = $days[$currentDate->modify('+1 day')->format('w')];
$dzien6 = $days[$currentDate->modify('+1 day')->format('w')];
$dzien7 = $days[$currentDate->modify('+1 day')->format('w')];

$dates = array();

for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', strtotime("+" . $i . " day"));
    $dates["date_$i"] = $date;
}

// Access the dates using the generated variable names
$today = $dates['date_0'];
$tomorrow = $dates['date_1'];
$nextDay = $dates['date_2'];
$nextDay2 = $dates['date_3'];
$nextDay3 = $dates['date_4'];
$nextDay4 = $dates['date_5'];
$nextDay5 = $dates['date_6'];
?>

<body>
<div class="web"> 
<button onclick="topFunction()" id="goUpBtn" title="Go to top">Do Góry!</button>
    <div class="menu">
        <button class="menu_btn" onclick="goToDodawanie()">➕ Dodaj&nbsp;</button>
        <button  class="menu_btn" onclick="goto1()">widok1</button>
        <button  class="menu_btn" onclick="goto2()">widok2</button>
        <button  class="menu_btn" onclick="goto3()"style="background-color:rgba(47, 204, 255, 1)">widok3</button>       
    
        <button class="menu_btn" type="button">
        <img src="img/awatar.png" width="20%" height="auto"> 
    <?php 
        echo $_SESSION['user'];
    ?>
        </button>        
                    
        <div class="list_Menu">
        <button type="button" class="l_Btn" data-bs-toggle="modal" data-bs-target="#exampleModal">📈 Statystyki</button>
        <button class="l_Btn" onclick="document.location='myaccount.php'">⚙️ Ustawienia profilu&nbsp;</button>
        <button class="l_Btn" onclick="alert()">⚠️ Wyloguj się&nbsp;</button>
        </div>
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
    <div class="calendar">
    <h1>Obowiązki domowe w tym tygodniu:</h1>
      <div class="accordion" id="accordionPanelsStayOpenExample">
    <!-- DZIEN 1 #################################################################################################### -->
    <div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            <?php echo $dzien1." ".$today; ?>
        </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <h6 >Obowiązki:</h6>
            <hr>
            <?php
            if ($result1) {
                while ($row = mysqli_fetch_assoc($result1)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
function komentarz(eventId) {
    var komentarzElement = document.getElementById("komentarz_" + eventId);
    if (komentarzElement.style.display === "none" || komentarzElement.style.display === "") {
        komentarzElement.style.display = "block"; // Show the comment
    } else {
        komentarzElement.style.display = "none"; // Hide the comment
    }
}

</script>
          <!-- DZIEN 2 #################################################################################################### -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
          <?php echo $dzien2." ".$tomorrow; ?>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
        <div class="accordion-body">
        <h6>Obowiązki:</h6>
        <hr>
        <?php
            if ($result2) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
          <!-- DZIEN 3 #################################################################################################### -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
          <?php echo $dzien3." ".$nextDay; ?>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
        <div class="accordion-body">
        <h6>Obowiązki:</h6>
        <hr>
        <?php
            if ($result3) {
                while ($row = mysqli_fetch_assoc($result3)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
          <!-- DZIEN 4 #################################################################################################### -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
          <?php echo $dzien4." ".$nextDay2; ?>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
        <div class="accordion-body">
        <h6>Obowiązki:</h6>
        <hr>
        <?php
            if ($result4) {
                while ($row = mysqli_fetch_assoc($result4)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
          <!-- DZIEN 5 #################################################################################################### -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
          <?php echo $dzien5." ".$nextDay3; ?>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse">
        <div class="accordion-body">
        <h6>Obowiązki:</h6>
        <hr>
        <?php
            if ($result5) {
                while ($row = mysqli_fetch_assoc($result5)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
          <!-- DZIEN 6 #################################################################################################### -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
          <?php echo $dzien6." ".$nextDay4; ?>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse">
        <div class="accordion-body">
        <h6>Obowiązki:</h6>
        <hr>
        <?php
            if ($result6) {
                while ($row = mysqli_fetch_assoc($result6)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
          <!-- DZIEN 7 #################################################################################################### -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
          <?php echo $dzien7." ".$nextDay5; ?>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse">
        <div class="accordion-body">
        <h6>Obowiązki:</h6>
        <hr>
        <?php
            if ($result7) {
                while ($row = mysqli_fetch_assoc($result7)) {
                    echo '<div class="event-box" onclick="komentarz(' . $row['id'] . ')">';
                    echo '<div class="event-content">';
                    if ($row['waznosc'] == 'bardzo') {
                        echo '<img src="img/red.png" width="40vw" height="auto">';
                    } else if ($row['waznosc'] == 'srednio') {
                        echo '<img src="img/yellow.png" width="40vw" height="auto">';
                    } else {
                        echo '<img src="img/green.png" width="40vw" height="auto" >';
                    }
                    echo '<h3 id="nazwa">';
                    echo "  " . $row['nazwa'];
                    echo '</h3>';

                    if ($row['zrobione'] == 0) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_done" type="submit" id="form">Niezrobione <img src="img/cross.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    } else {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="event_id" value="' . $row["id"] . '">';
                        echo '<button name="mark_as_undone" type="submit" id="form">Zrobione <img src="img/check.png" width="30vw" height="auto"></button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '<div class="comment-text">Kliknij aby wyświetlić/schować komentarz do tego wydarzenia:</div>'; 
                    echo '<div class="comment" id="komentarz_' . $row['id'] . '" style="display: none;">Komentarz: ' . $row['komentarz'] . '</div>'; 
                    echo '</div>';
                }
            } else {
                // Handle the case when the query fails
                echo "Error: " . mysqli_error($con);
            }
            // Check if the form has been submitted to mark an event as done
            if (isset($_POST['mark_as_done'])) {
                // Retrieve the event ID from the submitted form data
                $event_id = $_POST['event_id'];

                // Update the 'zrobione' column in the 'wydarzenia' table to set it to 1 for the specified event
                $updateQuery = "UPDATE wydarzenia SET zrobione = 1 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    // Replace 'your_page.php' with the URL of the page you want to redirect to
                    echo '<script>location.href = "kalendarz3.php";</script>';
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
                $updateQuery = "UPDATE wydarzenia SET zrobione = 0 WHERE id = $event_id";

                // Execute the update query
                if (mysqli_query($con, $updateQuery)) {
                    // The record has been updated successfully
                    // You can add a success message or redirect the user as needed
                    echo '<script>location.href = "kalendarz3.php";</script>';// Replace 'your_page.php' with the URL of the page you want to redirect to
                    exit;
                } else {
                    // Handle any errors that may occur during the update
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>
</div>
  </div>
</div>

    <footer></footer>
    
</body>
<style>
.progress-stacked {
            width: 100%;
            height: 40px;
}
.progress {
    height: 40px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 1.5rem;
}

.comment{
    font-size: 1.3rem;
    white-space: normal;      /* Prevent text from wrapping */
    overflow: hidden;         /* Hide overflowed text */
    text-overflow: ellipsis; 
}

    #form{
        background: transparent ;
        color: white;
        border: transparent;
    }

  .event-box{
    background: rgb(192,172,255);
    background: linear-gradient(90deg, rgba(192,172,255,1) 0%, rgba(101,0,255,1) 100%);
    padding: 1%;
    width:100%;
    margin-bottom: 2%;
    border-radius:15px;
    color: white;
    display: flex;
    flex-direction: column;
}

.event-content {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center; 
    width: 100%;
    /* Add any other styling for the event content */
}
#nazwa{
    font-size: 2rem;
    padding-top: 1.5%;
    white-space: normal;      /* Prevent text from wrapping */
    overflow: hidden;         /* Hide overflowed text */
    text-overflow: ellipsis;  /* Display an ellipsis (...) for overflowed text */
    max-width: 60%;  
}
@media only screen and (max-width: 900px) {
    #nazwa{
        width: 100%;
        text-align: center;
        font-size: 1.2rem;
    }
    .comment{
        font-size: 0.9rem;
    }
    .event-content {
    display: flex;
    flex-direction: column;
    
}
.menu_btn{
            font-size: 1.8vh !important;
        }
}
#accordionPanelsStayOpenExample{
  width: 100%;
}
hr{
    border: 2px solid black;
    border-radius: 10px;
}

*{
    margin:0;
    padding:0; 
   
}
body{
    background-image: url(img/cool-background3.png);
    background-size: cover;    
    background-position: center;
    background-attachment: fixed;
}
/* -- Górne menu */
.web{
    height: auto;
    width: 100%;
}
.menu{
   
   height: 13vh;
   width: 100%;
   display: flex;
   position: relative;
   flex-direction: row;
   align-items: center;
   justify-content:space-around;    
   background-color: transparent    ; 
   
}
.menu::before{    /* linia pod elementem*/
   width: 100%;    
   content: "";
   position: absolute;
   left: 0;
   bottom: 0;
   height: 1px;
   width: 90%;  
   border-bottom: 3px solid white; 
   left: 5%;
   text-align: center;
   
}

.menu_btn{   
   display: flex;
   flex-direction: row;    
   align-items: center;
   justify-content: space-around;
   text-align: center;
   width: 15vw;
   height: 7vh;
   border-radius: 5px;
   border: none;
   transition: .3s;  
   color: black;
   font-size: 2.7vh; 
   background-color: rgba(255, 255, 255, 1);
   box-shadow: 1.2px 4px 3px 0px;  
}
.menu_btn:focus{
   background-color: rgba(211, 211, 211, 0.9);  
   transform: scale(1.2);    
   transition: .3s;    
}


.menu_btn:hover{
   transform: scale(1.2);    
   transition: .3s;   
}
.list_Menu{
   visibility: hidden;    
   display: flex;  

   transform: scale(1.2);
   width: 30vh;
   height: 15vh;
   position: fixed;
   background-color: rgba(211, 211, 211, 0.75);    
   transition: 0.1s;  
   align-items: center;
   justify-content: space-evenly;
   flex-direction: column;
   right: 39.5px;
   top: 13.2vh;
   /* border-radius: 5px; */
   border-bottom-right-radius: 10px;
   border-bottom-left-radius: 10px;
   border: none;
   z-index: 99;
   box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5);
  
   
   
   
}

.l_Btn{
   
   display: block;
   height: 4vh;
   width: 25vh;
   border-radius: 5px;
   border: none;
   transition: 0.1s;  
   color: black;
   font-size: 2vh; 
   background-color: rgba(116, 116, 116, 0.3);
   box-shadow: 1.2px 4px 3px 0px;
   
}
.l_Btn:hover{
   background-color: rgba(116, 116, 116, 0.75)
}

.menu_btn:focus:nth-child(5)+.list_Menu {
   visibility: visible;    
   transition: 0.1s;
}




#goUpBtn{
     
  opacity: 0;
  visibility: hidden;
  position: fixed; 
  bottom: 20px; 
  right: 30px; 
  z-index: 99; 
  border: none; 
  outline: none; 
  background-color: rgba(0, 121, 255, 1);
  color: rgba(255, 255, 255); 
  cursor: pointer; 
  padding: 15px; 
  border-radius: 10px; 
  font-size: 18px;
  transform: scale(1); 
  transition: opacity 500ms, visibility 500ms;
 
}
#goUpBtn:hover {
    background-color: rgba(0, 84, 255, 1); 
    color: white;
    transform: scale(1.2);
    transition: 0.3s;
    
  }
  #goUpBtn:focus {
    right: 2px;   
    
  }

/* Kalendarz, kafelki */
.calendar{
    margin-top: 10px;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    margin-left: 10%;
    margin-right: 10%;
    height: auto;
    transition: all ease-in;
    backdrop-filter: blur(1.5px);
    
    width:80%;
    background: rgba(255, 255, 255, 0.7);
    box-sizing: border-box;
    border-radius: 25px;
    padding: 30px;
    /* padding-bottom: 1vh; */
    }
    /* odwołanie się do rodzica */
    /* .calendar:has(> .container:hover){ 
        
        transition: all 0.4s;
       
    } */
footer{
    text-align: center;    
    position: relative;
    /* margin-top: 30px; */
    height: 3vh;
    width: 100%; 
    margin-top: 10px ; 
    font-size: 14px;
    width: auto;     
    color: black;
    background-color: rgba(255, 255, 255, 0.9);
    background: linear-gradient(to right, transparent, transparent 20%,rgba(255, 255, 255,0.75) 50%, transparent 80%);

    box-sizing: border-box;
}
footer::before{ /* linia pod elementem*/
    /* margin-top: 10px; */
    box-sizing: border-box;
    width: 100%;    
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 1px;
    width: 90%;  
    border-top: 3px solid white; 
    left: 5%;
    text-align: center;    
}

</style>
<script>
    // przycisk do góry! UWAGA ZAWSZE TEN SKRYPT MA BYĆ PIERWSZY INACZEJ NIE DZIAŁA niewiadomo czemu.
    
let timer;
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
console.log("timer")
mybutton.style.visibility = "hidden";   
mybutton.style.opacity = "0"; 
}, 2600);
};


function topFunction() {
document.body.scrollTop = 0;
document.documentElement.scrollTop = 0;
}
//funkcja ustawiająca kafelki (na razie nazywajaca jeden pierwszy kafelek)

function getDayName(date = new Date(), locale = 'en-US') {
return date.toLocaleDateString(locale, {weekday: 'long'});

}
console.log(getDayName()); //wywala nazwe dnia console log
document.getElementById("Today").innerHTML = getDayName();



//funkcja od wylogowywania sie

function alert(){
    Swal.fire({
title: 'Jestes pewien?',
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
</script>

</html>
