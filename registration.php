<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>

<body>
    <?php
    include 'header_unathorized.php'; // Assuming 'header.php' is in the same directory as this file

    include 'connectToDb.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Connect to the database
        $conn = getDbConnection();

        // Collect and sanitize input data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password securely
        $address = htmlspecialchars($_POST['address']); // Sanitize the address input

        // Prepare a select statement to check if the email already exists
        $sql = 'SELECT Email FROM UGYFELEK WHERE Email = :email';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':email', $email);
        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC);

        if ($row) {
            echo "<h2>User with this email already exists!</h2>";
        } else if ($name) {
            // Email does not exist, proceed with insertion
            $sql = 'INSERT INTO UGYFELEK (NICKNAME, ADDRESS, EMAIL, PASSWORD) VALUES (:name, :address, :email, :password)';

            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':name', $name);
            oci_bind_by_name($stid, ':email', $email);
            oci_bind_by_name($stid, ':password', $password);
            oci_bind_by_name($stid, ':address', $address);
            $result = oci_execute($stid);
            if ($result) {
                echo "<h2>Registration successful!</h2>";
            } else {
                $e = oci_error($stid);
                echo "<h2>Error during the registration: " . $e['message'] . "</h2>";
            }
        }

        // Close the Oracle connection
        oci_close($conn);
    }
    ?>

    <h2>Registration Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>