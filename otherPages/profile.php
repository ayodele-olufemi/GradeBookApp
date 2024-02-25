<?php
session_start();
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/GradeBookApp";

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/GradeBookApp/includes/headerLoggedIn.php";
$footer = $path . "/GradeBookApp/includes/footer.php";

require_once($path . "/GradeBookApp/includes/config.php");
// Check if the user is not logged in. Send them to index page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "index.php");
    exit();
}

// Handle changing of profile picture
$upload_err = "";

include($header);

if (isset($_POST["upload"]) && !empty($_FILES["uploadPics"]["tmp_name"])) {
    $upload_err = "";
    $target_dir = $path . "/GradeBookApp/uploads/"; // Directory where the images will be stored
    $target_file = $target_dir . basename($_FILES["uploadPics"]["name"]);
    $targetfile = basename($_FILES["uploadPics"]["name"]);
    $upload_ok = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["uploadPics"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $upload_ok = 1;
    } else {
        $upload_err .= "File is not an image.";
        $upload_ok = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $upload_ok = 0;
    }

    // Check file size
    if ($_FILES["uploadPics"]["size"] > 500000) {
        $upload_err .=  "Sorry, your file is too large.";
        $upload_ok = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $upload_err .=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $upload_ok = 0;
    }

    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        $upload_err .= "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["uploadPics"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["uploadPics"]["name"]) . " has been uploaded.";

            // Update the user's profile picture URL in the database
            if ($_SESSION["usertype"] == "student") {
                $studentId = $_SESSION["studentId"];
                // Prepare an update statement
                $sql = "UPDATE students SET photoUrl = '$targetfile' WHERE id = $studentId";
                if (mysqli_query($db, $sql)) {
                    echo "<h2 style='color: green'>Profile picture uploaded successfully!</h2>";
                    $_SESSION["profilePicture"] = $targetfile;
                    header("location:" . $docRoot . "/otherPages/profile.php");
                } else {
                    echo "<h2 style='color: red;'>Error updating profile picture: " . mysqli_error($db) . "</h2>";
                }
            } else {
                $professorId = $_SESSION["professorId"];
                // Prepare an update statement
                $sql = "UPDATE professors SET photoUrl = '$targetfile' WHERE id = $professorId";
                if (mysqli_query($db, $sql)) {
                    echo "Profile picture updated successfully.";
                    $_SESSION["profilePicture"] = $targetfile;
                } else {
                    $upload_err =  "Error updating profile picture: " . mysqli_error($db);
                }
            }
        } else {
            $upload_err =  "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_POST["returnHome"])) {
    if ($_SESSION["usertype"] == "student") {
        header("location: " . $docRoot . "/otherPages/welcomeStudent.php");
    } else {
        header("location: " . $docRoot . "/otherPages/welcomeProfessor.php");
    }
}

?>
<div class="content">
    <h1>Profile Page</h1>
    <div class="profilePageSections">
        <section>
            <h2>User Details</h2>
            <br>
            <div class="userDetails">
                <h2>
                    <?php
                    echo htmlspecialchars($_SESSION["firstName"]) . " " . htmlspecialchars($_SESSION["lastName"]);
                    ?>
                </h2><br>
                <p><b>Email: </b><?= htmlspecialchars($_SESSION["email"]) ?></p>
                <p><b>Phone: </b><?= htmlspecialchars($_SESSION["phone"]) ?></p>
            </div>
        </section>

        <section>
            <h2>Change Profile Picture</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <label for="uploadPics">Upload profile picture: </label>
                <input id="uploadPics" name="uploadPics" type="file">
                <input type="submit" class="btn btn-primary" name="upload" value="Upload Picture"><br>
                <span style='color: red;'><?php echo $upload_err; ?></span>
            </form>
        </section>

        <section>
            <h2>Change Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="currentPassword">Enter current password: </label>
                <input id="currentPassword" name="currentPassword" type="password"><br>

                <label for="newPassword">Enter new password: </label>
                <input id="newPassword" name="newPassword" type="password"><br>

                <label for="confirm_newPassword">Confirm new password: </label>
                <input id="confirm_newPassword" name="confirm_newPassword" type="password"><br><br>
                <input type="submit" class="btn btn-primary" name="changePassword" value="Submit">
            </form>
        </section>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type=submit class="btn btn-success" name="returnHome" value="Return to your Home Page">
    </form>
</div>

<?php
include($footer);
?>