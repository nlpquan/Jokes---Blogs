<?php
// add a new user to the database. requires input from register_new_user.php

include "db_connect.php";

$new_username = $_GET['username'];
$new_password1 = $_GET['password'];
$new_password2 = $_GET['password-confirm'];

$hashed_password = password_hash($new_password1, PASSWORD_DEFAULT);

echo "<h2>Trying to add a new user " . $new_username . " pw =  " . $new_password1 . " and " . $new_password2 . "</h2>";

if ($new_password1 != $new_password2) {
    echo "The passwords do not match. Please try again";
    exit;
}

preg_match('/[0-9]+/', $new_password1, $matches);
if (sizeof($matches) == 0) {
    echo "The passwords must have at least one number <br>";
    exit;
}

preg_match('/[!@#$%^&*()]+/', $new_password1, $matches);
if (sizeof($matches) == 0) {
    echo "The passwords must have at least one special character like !@#$%^&*() <br>";
    exit;
}

if (strlen($new_password1) <= 8) {
    echo "The passwords must be at least 8 characters long<br>";
    exit;
}

$sql = "INSERT INTO users (id, username, password) VALUES (null, '$new_username', '$hashed_password')";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));

if ($result) {
    echo "Registration success!";
} else {
    echo "Something went wrong.  Not registered.";
}
echo "<a href = 'index.php'>Return to main</a>";
