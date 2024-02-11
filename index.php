<?php
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerNotLoggedIn.php";
$footer = $path . "/includes/footer.php";

include($header);
?>
<div class="content">
    <h1>Home Page</h1>
</div>
<?php
include($footer);
?>