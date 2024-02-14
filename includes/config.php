<?php
//define('DB_SERVER', 'localhost:3307');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'gradebook');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($db === false) {
    die("Error: Could not connect to database." . mysqli_connect_error());
}
