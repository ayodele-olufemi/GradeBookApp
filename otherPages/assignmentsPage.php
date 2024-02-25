<!DOCTYPE html>
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

include($header);
?>
<link rel="stylesheet" href="/css/assignments.css">
<h1>Assignments</h1>
<table style="width: 100%;">
    <tr class="columnHeaders">
        <td>Assignment</td>
        <td>Upload Status</td>
        <td>Score</td>
        <td>Feedback</td>
    </tr>
    <tr>
        <td>
            <div>
                <a href="">Assignment 1</a>
            </div>
            <div>Due Date</div>
        </td>
        <td class="uploadStatus">
            <div>
                <a href="">1 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>15 / 15</div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?php echo $docRoot; ?>/otherPages/feedback.php?name=Assignment+1&score=15/15">unread</a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <a href="">Assignment 2</a>
            </div>
            <div>Due Date</div>
        </td>
        <td class="uploadStatus">
            <div>
                <a href="">3 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>85 / 100</div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?php echo $docRoot; ?>/otherPages/feedback.php?name=Assignment+2&score=85/100">unread</a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <a href="">Assignment 3</a>
            </div>
            <div>Due Date</div>
        </td>
        <td class="uploadStatus">
            <div>
                <a href="">not submitted</a>
            </div>
        </td>
        <td class="score">
            <div>- / -</div>
        </td>
        <td class="feedback">
            <div>
                <a href=""></a>
            </div>
        </td>
    </tr>
</table>
<?php
include($footer);
?>