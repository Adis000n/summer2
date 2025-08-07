<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawanie wydarzeń</title>
    <link rel="icon" href="img/logo.jpg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
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
<body>
    <button type="button" class="btn btn-primary btn-lg" onclick="goBack()" id="back">Wróć</button>
            <!-- ########################################################################### -->
            <form method="post">
            <!-- potrzebna nazwa, co to jest(kartkówka,sprawdzian,czy zadanie), jak ważne, komentarz, data na kiedy, i od kiedy do kiedy chcesz to robić -->
            <div class="form-floating mb-3">
                <input class="form-control" id="floatingInput" placeholder="Przykładowy_przedmiot" name="nazwa" maxlength="70">
                <label for="floatingInput">Nazwa wydarzenia</label>
            </div>
            <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="typ">
                <option selected>Wybierz typ wydarzenia</option>
                <option value="sprawdzian">Sprawdzian</option>
                <option value="kartkowka">Kartkówka</option>
                <option value="zadanie">Zadanie domowe</option>
                <option value="obowiazek">Obowiązek domowy</option>
            </select>
            <label for="floatingSelect">Klinij aby otworzyć menu </label>
            </div>
            <br>
            <div class="form-floating">
            <select class="form-select" id="floatingSelect2" aria-label="Floating label select example" name="waznosc">
                <option selected>Wybierz jak ważne jest wydarzenie</option>
                <option value="bardzo">Bardzo ważny</option>
                <option value="srednio">Średnio ważny</option>
                <option value="malo">Mało ważny</option>
            </select>
            <label for="floatingSelect2">Klinij aby otworzyć menu</label>
            </div>
            <br>
            <label>Wybierz date wydarzenia</label>
            <input type="date" id="dateInput" min="<?php echo date("Y-m-d") ?>" value="<?php echo date("Y-m-d") ?>" style="border-radius:5px" name="data_wydarzenia" />
            <br><br>
            <div id="studyDatesContainer">Data zrobienia/nauki:<br></div>
            <br>
            <button type="button" class="btn btn-success" onclick="addStudyDate()" id="add">Dodaj datę nauki/zrobienia</button>
            <br><br>
            <button type="button" class="btn btn-danger" onclick="deleteStudyDate()" id="delete" style="display: none; width:100%;">Usuń datę nauki/zrobienia</button>
            <br>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="komentarz" maxlength="200"></textarea>
                <label for="floatingTextarea2">Komentarz</label>
            </div>
            <br>
            <input class="btn btn-primary" type="submit" value="Wyślij" style="width:100%">
            </form>
            <!-- ########################################################################### -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = $_POST["nazwa"];
    $typ = $_POST["typ"];
    $waznosc = $_POST["waznosc"];
    $data_wydarzenia = $_POST["data_wydarzenia"];
    $komentarz = $_POST["komentarz"];

    if (!empty($nazwa) && $nazwa !== "Przykładowy_przedmiot" &&
        !empty($typ) && $typ !== "Wybierz typ wydarzenia" &&
        !empty($waznosc) && $waznosc !== "Wybierz jak ważne jest wydarzenie") {
        
        // Check if the event date is the current date
        if ($data_wydarzenia !== date("Y-m-d")) {
            // If it's not the current date, perform additional validation
            if (empty($data_wydarzenia)) {
                // Handle validation errors for the event date
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Błąd",
                    text: "Data wydarzenia jest wymagana, gdy nie jest dzisiejsza.",
                });
                </script>';
                return; // Stop further processing
            }

            // Escape and quote values for SQL
            $nazwa = mysqli_real_escape_string($con, $nazwa);
            $typ = mysqli_real_escape_string($con, $typ);
            $waznosc = mysqli_real_escape_string($con, $waznosc);
            $data_wydarzenia = mysqli_real_escape_string($con, $data_wydarzenia);
            $komentarz = mysqli_real_escape_string($con, $komentarz);
        }

        $id = $_SESSION['id'];

        // Create and execute a prepared statement to insert into wydarzenia table
        $stmt = mysqli_prepare($con, "INSERT INTO `wydarzenia` (`id`, `nazwa`, `typ`, `waznosc`, `data`, `komentarz`, `user_id`, `zrobione`)
        VALUES (NULL, ?, ?, ?, ?, ?, ?, 0);");
        mysqli_stmt_bind_param($stmt, "sssssi", $nazwa, $typ, $waznosc, $data_wydarzenia, $komentarz, $id);

        if (mysqli_stmt_execute($stmt)) {
            // Get the ID of the newly added event
            $event_id = mysqli_insert_id($con);

            // Insert study dates into daty_nauki table
            if ($typ !== "obowiazek") {
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'studyDate') === 0) {
                        $studyDate = $value;

                        // Create and execute a prepared statement to insert into daty_nauki table
                        $studyStmt = mysqli_prepare($con, "INSERT INTO `daty_nauki` (`id`, `wydarzenie_id`, `data_nauki`, `zrobione`)
                        VALUES (NULL, ?, ?, 0);
                        ");
                        mysqli_stmt_bind_param($studyStmt, "is", $event_id, $studyDate);
                        mysqli_stmt_execute($studyStmt);
                    }
                }
            }

            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Pomyślnie dodano nowe wydarzenie!",
                timer: 2500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "kalendarz.php";
            });
            </script>';
        } else {
            echo "Error: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oho...",
            text: "Nie wszystkie pola zostały wypełnione",
        });
        </script>';
    }
}

?>

</body>
<style>
    #back{
        position: absolute;
        right: 2%;
        top: 2%;
    }
    body{
        justify-content: center;
        display: flex;
        background-image: url("img/cool-background4.png");
        background-size: cover;
        background-position: center;
    }
    form{
        background: rgba(200, 200, 200, 0.8); /* Transparent white background */
        backdrop-filter: blur(1.5px); /* Adjust the blur intensity as needed */
        border-radius: 3%;
        padding: 2%;
        width: 50%;
        margin-top: 5%;
    }
        @media only screen and (max-width: 600px) {
    form {
        margin-top: 15%;
        width: 90%;
    }
    }
    #add{
        width: 100%;
    }
</style>
<script>
    function goBack(){
        location.href = "kalendarz.php";
    }
    // Get the input element by its id
    const dateInput = document.getElementById('dateInput');

    // Get the select and date input elements by their respective IDs
    const selectElement = document.getElementById('floatingSelect');
    const add = document.getElementById("add");

    // Add an event listener to the select element
    selectElement.addEventListener('change', function() {
        // Get the selected option's value
        const selectedValue = selectElement.value;

        // Disable the date input if "Obowiązek domowy" is selected, or enable it otherwise
        if (selectedValue === "obowiazek") {
            add.disabled = true;
            document.getElementById('studyDatesContainer').style.color = "red";
            document.getElementById('studyDatesContainer').innerHTML = "Data zrobienia/nauki:<br>!!!Ponieważ wybrałeś obowiązek domowy nie ma daty zrobienia/nauki!!!";
        } else {
            add.disabled = false;
            document.getElementById('studyDatesContainer').style.color = "black";
            document.getElementById('studyDatesContainer').innerHTML = "Data zrobienia/nauki:<br>";

        }
    });

    // Initialize the state based on the initial select value
    if (selectElement.value === "obowiazek") {
        dateInput.disabled = true;
    }
    const deleteButton = document.getElementById("delete");
    let dateInputCount = 0;
    function addStudyDate() {
        const studyDatesContainer = document.getElementById('studyDatesContainer');
        const dateInputs = studyDatesContainer.getElementsByTagName('input');

        // Get the selected event date
        const eventDate = new Date(dateInput.value);

        // Calculate the number of days between today and the event date
        const today = new Date();
        const daysUntilEvent = Math.ceil((eventDate - today) / (1000 * 60 * 60 * 24));

        // Show the "Delete Study Day" button after adding the first study date
        if (dateInputs.length === 0) {
            deleteButton.style.display = "block";
        }
        dateInputCount++;
        // Check if there are more study dates to add
        if (dateInputs.length < daysUntilEvent) {
            const newDateInput = document.createElement('input');
            newDateInput.type = 'date';
            newDateInput.name = `studyDate${dateInputCount}`;

            // Set the min attribute to the current date
            const currentDate = today.toISOString().split('T')[0];
            newDateInput.min = currentDate;

            // Set the max attribute to one day before the event date
            eventDate.setDate(eventDate.getDate() - 1);
            const formattedEventDate = eventDate.toISOString().split('T')[0];
            newDateInput.max = formattedEventDate;
            newDateInput.style.borderRadius = "5px";
            document.getElementById("add").innerHTML = "Dodaj kolejną datę nauki/zrobienia";

            studyDatesContainer.appendChild(newDateInput);

            if (hasDuplicateDates()) {
                // Display an alert if duplicate dates are found
                Swal.fire({
                    icon: 'error',
                    title: 'Oho...',
                    text: 'Nie można dodać dwóch takich samych dat nauki/zrobienia.',
                });

                // Remove the duplicate date input
                studyDatesContainer.removeChild(newDateInput);
            }
        } else {
            // If the maximum number of study dates has been reached, display a message
            Swal.fire({
                icon: 'error',
                title: 'Oho...',
                text: 'Dodałeś maksymalną ilość dni, w których możesz się uczyć/zadanie zrobić!',
            });
        }
    }

    function deleteStudyDate() {
        const studyDatesContainer = document.getElementById('studyDatesContainer');
        const dateInputs = studyDatesContainer.getElementsByTagName('input');
        if (dateInputs.length > 0) {
            studyDatesContainer.removeChild(dateInputs[dateInputs.length - 1]);
        }
        if (dateInputs.length === 0) {
            // Hide the "Delete Study Day" button when there are no study dates left
            deleteButton.style.display = "none";
        }
    }
// Function to check for duplicate dates
function hasDuplicateDates() {
    const dateInputs = studyDatesContainer.getElementsByTagName('input');
    const dateValues = Array.from(dateInputs).map(input => input.value);
    const uniqueDateValues = new Set(dateValues);
    return dateValues.length !== uniqueDateValues.size;
}

</script>
</html>