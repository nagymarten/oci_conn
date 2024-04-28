<?php include 'adminGuard.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <!-- TODO: list volnurable data only for isAdmin  -->
    <h2>Könyvesbolt</h2>
    <button onclick="window.location.pathname = 'oci_conn/books/list.php';">Books</button>
    <button onclick="window.location.pathname = 'oci_conn/stores/list.php';">Stores</button>
    <button onclick="window.location.pathname = 'oci_conn/review/list.php';">Revierws </button>

    <?php
        $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

        if ( $isAdmin ) {
            echo "<button onclick=\"window.location.pathname = 'oci_conn/connection.php';\">DB connection check</button>";
            echo "<button onclick=\"window.location.pathname = 'oci_conn/book_supply/list.php';\">Book supply </button>";
            echo "<button onclick=\"window.location.pathname = 'oci_conn/orders/list.php';\">Orders </button>";
            echo "<button onclick=\"window.location.pathname = 'oci_conn/regular_customer/list.php';\">Regular Customers </button>";
        }
    ?>
   
    <form method="post">
        <input type="submit" name="signout" value="Sign Out">
    </form>
</body>
</html>
