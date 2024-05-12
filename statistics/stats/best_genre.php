<?php
    include '../../header.php'; // Assuming 'header.php' is in the same directory as this file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best customers</title>
</head>
<body>
    <main>
    <div class="table-container">
    <h2>Best genre</h2>
    <table>
        <?php
            include '../../connectToDb.php';
            $conn = getDbConnection();

            $sql = 'SELECT k.GENRE, SUM(od.QUANTITY) AS TOTAL_SOLD
                    FROM ORDER_DETAILS od
                    JOIN KONYVEK k ON k.ISBN = od.ISBN
                    GROUP BY k.GENRE
                    ORDER BY TOTAL_SOLD DESC
                    FETCH FIRST 1 ROWS ONLY';
            $stid = oci_parse($conn, $sql);

            // Execute the query
            if (oci_execute($stid)) {
                $row = oci_fetch_array($stid, OCI_ASSOC);

                if ($row) {
                    echo "<div class=\"flex justify-start\">The most sold genre is: " . htmlspecialchars($row['GENRE']) . "<br></div>";
                    echo "<div class=\"flex justify-start\">Total copies sold: " . htmlspecialchars($row['TOTAL_SOLD']) . "<br></div>";
                } else {
                    echo "No sales data found.";
                }
            } else {
                $e = oci_error($stid);
                echo "Error retrieving sales data: " . htmlentities($e['message'], ENT_QUOTES);
            }

            $sql2 = 'SELECT GENRE, COUNT(GENRE) AS COUNT FROM KONYVEK GROUP BY GENRE ORDER BY COUNT DESC';
            $stid2 = oci_parse($conn, $sql2);

            // Execute the query
            if (oci_execute($stid2)) {
                echo "<table>";
                echo "<thead><tr><th>Genre</th><th>Order Count</th></tr></thead>";

                // Fetch each row and display it in the table
                while ($row = oci_fetch_array($stid2, OCI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['GENRE']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['COUNT']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                $e = oci_error($stid2);
                echo "Error retrieving genre counts: " . htmlentities($e['message'], ENT_QUOTES);
            }

            oci_free_statement($stid);
            oci_free_statement($stid2);
            oci_close($conn);

        ?>
    </table>
    </div>
    </main>
</body>
</html
