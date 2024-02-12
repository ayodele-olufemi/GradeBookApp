<?php
session_start();
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerLoggedIn.php";
$footer = $path . "/includes/footer.php";

require_once($path . "/includes/config.php");

// declare variables 
$firstname = $lastname = $email = "";
$studentId = $_SESSION['studentId'];

//prepare sql to get student details
$sql1 = "SELECT firstName, lastName, email FROM students WHERE id = ?";

if ($stmt = mysqli_prepare($db, $sql1)) {
    mysqli_stmt_bind_param($stmt, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $first_name, $last_name, $e_mail);
        if (mysqli_stmt_fetch($stmt)) {
            $firstname = $first_name;
            $lastname = $last_name;
            $email = $e_mail;
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}

//prepare sql to get student enrollment details

//prepare sql to get course available for registration



include($header);


?>
<div class="content">
    <h1>Student Welcome Page</h1>
    <?php
    if (isset($_SESSION["studentId"])) {
        echo "<p>The StudentId is " . $_SESSION['studentId'] . "</p>";
    }

    ?>
</div>
<?php
include($footer);
?>