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

//prepare sql to get student enrollment details
$sql2 = "SELECT studentId, courseId, courseTitle, courseDescription, profFirstName, profLastName, profEmail, enrollStatus FROM vw_studentEnrollments WHERE studentId = ?";

//prepare sql to get course available for registration
$sql3 = "SELECT courseId, courseTitle, courseDescription, profFirstName, profLastName, profEmail FROM vw_availableEnrollments WHERE courseId NOT IN (SELECT courseId from vw_studentEnrollments WHERE studentId = ?)";

// Execute sql to get student details
if ($stmt1 = mysqli_prepare($db, $sql1)) {
    mysqli_stmt_bind_param($stmt1, "i", $param_studentId);

    $param_studentId = $studentId;

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

// Execute sql to get student enrollment details
if ($stmt2 = mysqli_prepare($db, $sql2)) {
    mysqli_stmt_bind_param($stmt2, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt2)) {
        $result = mysqli_stmt_get_result($stmt2);
        if (mysqli_num_rows($result) > 0) {
            $enrollment = "<table class='table table-success table-striped table-hover'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                $ee = $row['enrollStatus'] == 1 ? 'Enrolled' : 'Awaiting Approval';
                $enrollment .= "<tr>
                <td>" . $row['courseId'] . "</td>
                <td>" . $row['courseTitle'] . "</td>
                <td>" . $row['courseDescription'] . "</td>
                <td>" . $row['profFirstName'] . " " . $row['profLastName'] . "</td>
                <td>" . $row['profEmail'] . "</td>
                <td>" . $ee . "</td>
                <td><input type='submit' class='btn btn-success' value='Check Grade' name='checkGrade'> <input type='submit' class='btn btn-danger' value='Drop Class' name='dropClass'></td>
                </tr>";
            }
            $enrollment .= "</tbody>
                        </thead>
                    </table>";
        } else {
            $enrollment = "You are not currently enrolled to any class.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt2);
}

// Execute sql to get course available for registration
if ($stmt3 = mysqli_prepare($db, $sql3)) {
    mysqli_stmt_bind_param($stmt3, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt3)) {
        $result = mysqli_stmt_get_result($stmt3);
        if (mysqli_num_rows($result) > 0) {
            $available = "<table class='table table-primary table-striped table-hover'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                $available .= "<tr>
                <td>" . $row['courseId'] . "</td>
                <td>" . $row['courseTitle'] . "</td>
                <td>" . $row['courseDescription'] . "</td>
                <td>" . $row['profFirstName'] . " " . $row['profLastName'] . "</td>
                <td>" . $row['profEmail'] . "</td>
                <td><input type='submit' class='btn btn-primary' value='Enroll' name='enrollNow'></td>
                </tr>";
            }
            $available .= "</tbody>
                        </thead>
                    </table>";
        } else {
            $available = "There are currently no classes available. Please check again later.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt3);
}


// function to enroll in a  class

// function to check grade



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
        <div class="registeredClasses">
            <p><?php echo $enrollment ?></p>
        </div>
    </section>
    <section>
        <h2>Available Classes</h2>
        <div class="availableClasses">
            <p><?php echo $available ?></p>
        </div>
    </section>
</div>
<?php
include($footer);
?>