<html lang="en">
<?php
$local = true;
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}

// Initialize the session
session_start();

// Check if the user is already logged in. Change header to headerLoggedIn.php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["usertype"] == "student") {
        header("location: welcomeStudent.php");
    } else {
        header("location: welcomeProfessor.php");
    }
    exit;
}

require_once($path . "/includes/config.php");


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password_hash, studentId, professorId FROM auth_table WHERE username = ?";

        if ($stmt = mysqli_prepare($db, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $studentId, $professorId);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            if (!empty($studentId)) {
                                //user is student
                                $_SESSION["usertype"] = "student";
                                $_SESSION["studendId"] = (int)$studentId;

                                // Redirect user to welcome page
                                header("location: welcomeStudent.php");
                            } else {
                                //user is professor
                                $_SESSION["usertype"] = "professor";
                                $_SESSION["professorId"] = (int)$professorId;

                                // Redirect user to welcome page
                                header("location: welcomeProfessor.php");
                            }
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($db);
}
?>

<head>
    <meta charset="utf-8" />
    <title>GradeBook App - Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="<?= $docRoot ?>js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= $docRoot ?>css/styles.css" />
</head>

<body>
    <div class="heading">
        <a href="<?= $docRoot ?>index.php">
            <img src="<?= $docRoot ?>images/G-oneLogo.png" class="g_one_logo" alt="G-One Logo">
        </a>
        <div class="otherItems">
            <div class="loginForm">
                <?php
                if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="username">Username: </label>
                    <input type="text" name="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"> <br>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span><br>

                    <label for="password">Password: </label>
                    <input type="password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"><br>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span><br>

                    <p>Forgot your password? Click <a href="<?= $docRoot ?>otherPages/resetpassword.php">here</a> to reset it.</p>
                    <input type="submit" class="btn btn-primary" value="Login">
                </form>
            </div>
            <div class="callToSignUp">
                <p>Don't have an account? Click <a href="<?= $docRoot ?>otherPages/signup.php">here</a> to create one now!</p>
            </div>
        </div>
    </div>
    <hr>