<?php
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
    <h1>Student Welcome Page</h1>
    <?php
    echo "<p>The StudentId is " . $_SESSION["studentId"] . "</p>";
    ?>
</div>
<?php
include($footer);
?>