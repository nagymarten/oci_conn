<?php
    session_start();

    // Check if the token exists in the session
    if (!isset($_SESSION['token'])) {
        // Redirect unauthenticated users to the login page
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'mypage.php';
        header("Location: http://$host/oci_conn/login.php");
        exit();
    }

    // Function to verify token (pseudo-code)
    function verifyToken($token) {
        //TODO
        return true;
    }

    // Verify the token
    if (!verifyToken($_SESSION['token'])) {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'mypage.php';
        header("Location: http://$host/oci_conn/login.php");
        exit();
    }
    // Sign out functionality
    if (isset($_POST['signout'])) {
        // Unset all session variables
        session_unset();
        // Destroy the session
        session_destroy();
        // Redirect to login page
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'mypage.php';
        header("Location: http://$host/oci_conn/login.php");
    exit();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h2>Könyvesbolt</h2>
    <button onclick="window.location.pathname = 'oci_conn/books/list.php';">Books</button>
    <button onclick="window.location.pathname = 'oci_conn/stores/list.php';">Stores</button>
    <button onclick="window.location.pathname = 'oci_conn/review/list.php';">Revierws </button>
    <button onclick="window.location.pathname = 'oci_conn/konyvbeszerzes/list.php';">Book supply </button>


    <form method="post">
        <input type="submit" name="signout" value="Sign Out">
    </form>
</body>
</html>
