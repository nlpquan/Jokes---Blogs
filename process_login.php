<head>
    <?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include "db_connect.php";

    $username = addslashes($_POST['username']);
    $password = $_POST['password'];

    echo "You attempted to login with " . $username . " and " . $password . "<br>";

    $stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($userid, $uname, $pw);

    //echo "SQL = " . $sql . "<br>";

    if ($stmt->num_rows > 0) {
        echo "I found one person with that username<br>";
        $stmt->fetch();
        if (password_verify($password, $pw)) {
            echo "The password matches<br>";
            echo "Login successful!<br>";
            $_SESSION['username'] = $uname;
            $_SESSION['userid'] = $userid;
            exit;
        }
        else {
            $_SESSION = [];
            session_destroy();
        }
    } 
    else {
        $_SESSION = [];
        session_destroy();
    }
    echo "Login failed<br>";


    echo "SESSION Variable = <br>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    echo "<br><a href='index.php'>Return to main page</a>";
    ?>