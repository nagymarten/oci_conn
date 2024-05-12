<?php
    include '../../header.php'; // Assuming 'header.php' is in the same directory as this file
    include '../../connectToDb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best customers</title>
</head>
<body>
    <div class="table-container">
    <h2>Best genre</h2>
    <table>
        <?php
            $conn = getDbConnection();

            $sql = 'SELECT ISBN, TITLE, PRICE FROM KONYVEK ORDER BY PRICE DESC FETCH FIRST 1 ROWS ONLY';
            $stid = oci_parse($conn, $sql);

            // Execute the query
            if (oci_execute($stid)) {
                $row = oci_fetch_array($stid, OCI_ASSOC);

                if ($row) {
                    $isbn = $row['ISBN'];
                    $title = $row['TITLE'];
                    $price = $row['PRICE'];

                    // Prepare the SQL query to count how many times the ISBN appears in ORDER_DETAILS
                    $sql_count = 'SELECT COUNT(*) AS ORDER_COUNT FROM ORDER_DETAILS WHERE ISBN = :isbn';
                    $stid_count = oci_parse($conn, $sql_count);
                    oci_bind_by_name($stid_count, ':isbn', $isbn);

                    if (oci_execute($stid_count)) {
                        $count_row = oci_fetch_array($stid_count, OCI_ASSOC);
                        $order_count = $count_row['ORDER_COUNT'];

                        // Display the information
                        echo "The most expensive book was " . htmlspecialchars($title) . 
                            ", its price is $" . htmlspecialchars($price) . 
                            " and it was sold " . htmlspecialchars($order_count) . " times.";
                    } else {
                        $e = oci_error($stid_count);
                        echo "Error counting book sales: " . htmlentities($e['message'], ENT_QUOTES);
                    }
                    oci_free_statement($stid_count);
                } else {
                    echo "No books found in the database.";
                }
            } else {
                $e = oci_error($stid);
                echo "Error retrieving the most expensive book: " . htmlentities($e['message'], ENT_QUOTES);
            }

            oci_free_statement($stid);
            oci_close($conn);
        ?>
    </table>
    </div>
</body>
</html
