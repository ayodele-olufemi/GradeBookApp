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
// Check if the user is not logged in. Send them to index page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "index.php");
    exit();
}

include($header);


?>
<div class="content">
    <h1>Profile Page</h1>
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
        <form action="">
            <label for="uploadPics">Upload profile picture: </label>
            <input name="uploadPics" type="file">
            <input type="submit" class="btn btn-primary" name="upload" value="Upload Picture">
        </form>
    </section>

    <section>
        <h2>Change Password</h2>
        <form action="">
            <label for="currentPassword">Enter current password: </label>
            <input name="currentPassword" type="password"><br>

            <label for="newPassword">Enter new password: </label>
            <input name="newPassword" type="password"><br>

            <label for="confirm_newPassword">Confirm new password: </label>
            <input name="confirm_newPassword" type="password"><br><br>
            <input type="submit" class="btn btn-primary" name="changePassword" value="Submit">
        </form>
    </section>
</div>

<?php
include($footer);
?>