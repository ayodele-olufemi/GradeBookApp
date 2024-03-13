<?php
session_start();
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/GradeBookApp/includes/headerLoggedIn.php";
$footer = $path . "/GradeBookApp/includes/footer.php";

include($header);

?>
<div class="content">
    <h1>Professor Welcome Page</h1>
    <?php
    echo "<p>The ProfessorId is " . $_SESSION["professorId"] . "</p>";
    ?>
    <section>
        <h2>
            <a href="/GradeBookApp/otherPages/professorAssignmentsPage.php">Assignments</a>
        </h2>
    </section>
</div>
<?php
include($footer);
?>