<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
        echo '<button onclick="window.location.pathname=\'oci_conn/books/create.php\'">Create New Book</button>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best customers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Stats</h2>
    <?php
        $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

        if ( $isAdmin ) {
            echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/best_genre.php';\">best_genre</button>";
            echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/serch_customer_orders.php';\">Search Customer Orders</button>";
        }
    ?>
</body>
</html
