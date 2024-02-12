<?php
session_start();
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerLoggedIn.php";
$footer = $path . "/includes/footer.php";

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