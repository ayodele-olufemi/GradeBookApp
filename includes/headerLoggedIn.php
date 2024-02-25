<html lang="en">
<?php
$local = true;
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/GradeBookApp";

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}
require_once($path . "/GradeBookApp/includes/config.php");

if (isset($_POST["logoutBtn"])) {
    session_start();
    session_destroy();
    $_SESSION = array();
    header("location:" . $docRoot . "index.php");
}




?>

<head>
    <meta charset="utf-8" />
    <title>GradeBook App - Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="<?= $docRoot ?>/js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= $docRoot ?>/css/styles.css" />
</head>

<body>
    <div class="heading">
        <a href="<?= $docRoot ?>index.php">
            <img src="<?= $docRoot ?>/images/G-oneLogo.png" class="g_one_logo" alt="G-One Logo">
        </a>
        <div class="profile_area">
            <div class="profilePicture">
                <img class="g_one_logo " src="<?= $docRoot . "/uploads/" ?><?php echo htmlspecialchars($_SESSION["profilePicture"]); ?>" alt="profile_pics">
            </div>
            <div class="p_texts">
                <p class="user_name"><?php echo htmlspecialchars($_SESSION["firstName"]) . " " . htmlspecialchars($_SESSION["lastName"]) ?></p>
                <a href="<?= $docRoot ?>/otherPages/profile.php">Profile & Settings</a>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="submit" class="btn btn-danger" name="logoutBtn" value="Logout">
                </form>

            </div>

        </div>
    </div>
    <hr>