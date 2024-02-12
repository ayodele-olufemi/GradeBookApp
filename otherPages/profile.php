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

include($header);


?>
<div class="content">
    <h1>Profile Page</h1>

    <h2>Change Profile Picture</h2>
    <form action="">
        <label for="uploadPics">Upload profile picture: </label>
        <input name="uploadPics" type="file">
    </form>

    <h2>Change Password</h2>
    <form action="">
        <label for="currentPassword">Enter current password: </label>
        <input name="currentPassword" type="password">


        <label for="newPassword">Enter new password</label>
        <input name="newPassword" type="password">

        <label for="confirm_newPassword">Confirm new password</label>
        <input name="confirm_newPassword" type="password">
        <input type="submit" value="Submit">
    </form>
</div>
<?php
include($footer);
?>