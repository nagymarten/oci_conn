<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <?php
    include 'header_unathorized.php'; // Assuming 'header.php' is in the same directory as this file

    include 'connectToDb.php';

    session_start();

    function generateToken($nickname) {
        $token = base64_encode(random_bytes(32));
        return $token;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nickname = htmlspecialchars($_POST['nickname']);
        $password = $_POST['password'];

        // Connect to the database
        $conn = getDbConnection();

        if (!$conn) {
            echo "<h2>Database connection error.</h2>";
        } else {
            // Prepare a select statement to check if the nickname exists and fetch the password
            $sql = 'SELECT * FROM UGYFELEK WHERE NICKNAME = :nickname';
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':nickname', $nickname);
            oci_execute($stid);

            $row = oci_fetch_array($stid, OCI_ASSOC);

            if (!$row) {
                echo "<h2>Nickname not registered</h2>";
            } else {
                // Verify the password
                if (password_verify($password, $row['PASSWORD'])) {
                    $token = generateToken($nickname);
                    $_SESSION['token'] = $token;
                    $_SESSION['nickname'] = $nickname;
                    $_SESSION['email'] = $row['EMAIL'];
                    $_SESSION['isAdmin'] = $row['IS_ADMIN'];
                    $_SESSION['basket'] = array();
                    header("Location: header.php");
                    exit(); // Ensure no further execution of the script after redirection
                } else {
                    echo "<h2>Login Failed: Invalid nickname or password.</h2>";
                }
            }
        }

        // Close the Oracle connection
        oci_close($conn);
    }
  ?>

    <h2>Login Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="nickname">Nickname:</label><br>
        <input type="text" id="nickname" name="nickname" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>