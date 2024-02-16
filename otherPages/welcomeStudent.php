<?php
session_start();
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerLoggedIn.php";
$footer = $path . "/includes/footer.php";

require_once($path . "/includes/config.php");

// Check if the user is not logged in. Send them to index/login page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "index.php");
    exit();
}

// declare variables 
$studentId = $_SESSION['studentId'];

//prepare sql to get student details
$sql1 = "SELECT firstName, lastName, email, phone, photoUrl FROM students WHERE id = ?";

if ($stmt = mysqli_prepare($db, $sql1)) {
    mysqli_stmt_bind_param($stmt, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $first_name, $last_name, $e_mail, $phone, $photoUrl);
        if (mysqli_stmt_fetch($stmt)) {
            $_SESSION["firstName"] = $first_name;
            $_SESSION["lastName"] = $last_name;
            $_SESSION["email"] = $e_mail;
            $_SESSION["phone"] = $phone;
            $_SESSION["profilePicture"] = $photoUrl;
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}

//prepare sql to get student enrollment details

//prepare sql to get course available for registration

//TESTING CODE -- PRINT $_SESSION
foreach ($_SESSION as $a => $b) {
    echo $a . " => " . $b . " ";
}

include($header);


?>
<div class="content">
    <h1>Student Welcome Page</h1>
    <section>
        <h2>Registered Classes</h2>
    </section>
    <section>
        <h2>Available Classes</h2>
    </section>

    <?php
    if (isset($_SESSION["studentId"])) {
        echo "<p>The StudentId is " . $_SESSION['studentId'] . "</p>";
    }
    ?>
</div>
<?php
include($footer);
?>