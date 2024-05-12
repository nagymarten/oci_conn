<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
</head>
<body>
   <main class="flex column align-start justify-start">
        <div class="flex column align-start justify-start">
            <h2>Stats</h2>
            <div class="flex align-start justify-start">
                <?php
                    $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

                    if ( $isAdmin ) {
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/best_genre.php';\">Best genre</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/serch_customer_orders.php';\">Search Customer Orders</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/search_orders_by_title.php';\">Search orders by title</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/best_seller.php';\">See best sellers</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/best_reviewer.php';\">See most active reviewer</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/reviewers.php';\">Reviewers</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/reguar_customers.php';\">Regular customers</button>";
                        echo "<button onclick=\"window.location.pathname = 'oci_conn/statistics/stats/most_expensive_book_orders.php';\">Most expensive book orders</button>";
                    }
                ?>
            </div>
        </div>
   </main>
</body>
</html
