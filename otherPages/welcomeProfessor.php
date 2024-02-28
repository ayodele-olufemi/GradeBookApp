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


if (isset($_SESSION["confirmationGood"]) || isset($_SESSION["confirmationBad"])) {
    echo '<script type="text/Javascript">
    setTimeout(() => {
        document.querySelector(".confirmation").style.display="none";
    }, 3000);
    </script>';
}

// declare variables 
$professorId = $_SESSION['professorId'];

//prepare sql to get professor details
$sql1 = "SELECT firstName, lastName, email, phone, photoUrl FROM professors WHERE id = ?";



// Execute sql to get professor details
if ($stmt1 = mysqli_prepare($db, $sql1)) {
    mysqli_stmt_bind_param($stmt1, "i", $param_professorId);

    $param_professorId = $professorId;

    if (mysqli_stmt_execute($stmt1)) {
        mysqli_stmt_store_result($stmt1);
        mysqli_stmt_bind_result($stmt1, $first_name, $last_name, $e_mail, $phone, $photoUrl);
        if (mysqli_stmt_fetch($stmt1)) {
            $_SESSION["firstName"] = $first_name;
            $_SESSION["lastName"] = $last_name;
            $_SESSION["email"] = $e_mail;
            $_SESSION["phone"] = $phone;
            $_SESSION["profilePicture"] = $photoUrl;
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt1);
}





include($header);

?>
<div class="content">
    <h1>Professor Welcome Page</h1>
    <?php
    echo "<p>The ProfessorId is " . $_SESSION["professorId"] . "</p>";
    ?>
</div>
<?php
include($footer);
?>