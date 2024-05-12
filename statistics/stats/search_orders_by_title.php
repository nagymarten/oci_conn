<?php
    include '../../header.php'; // Assuming 'header.php' is in the same directory as this file
    include '../../connectToDb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search orders by title</title>
</head>
<body>
   <main>
    <form form method="POST">
       <div class="flex">
          <label for="title">Enter Book Title:</label>
          <input type="text" id="title" name="title" required>
          <button type="submit">Search</button>
       </div>
    </form>

    <div class="table-container">
      <?php
          $conn = getDbConnection();
          if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['title'])) {
            $title = $_POST['title'];
        
            // Prepare the SQL query to find the ISBN by title
            $sql = 'SELECT ISBN FROM KONYVEK WHERE TITLE = :title';
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':title', $title);
        
            // Execute the query
            if (oci_execute($stid)) {
                $row = oci_fetch_array($stid, OCI_ASSOC);
        
                if ($row) {
                    $isbn = $row['ISBN'];
        
                    // Prepare the SQL query to find order details by ISBN
                    $sql_details = 'SELECT QUANTITY, PRICE, ORDER_ID FROM ORDER_DETAILS WHERE ISBN = :isbn';
                    $stid_details = oci_parse($conn, $sql_details);
                    oci_bind_by_name($stid_details, ':isbn', $isbn);
        
                    if (oci_execute($stid_details)) {
                        echo "<h2>Searched for the book title: " . htmlspecialchars($title) . "</h2>";
                        echo "<table>";
                        echo "<thead><tr><th>Quantity</th><th>Price</th><th>Order ID</th></tr></thead>";
        
                        // Fetch each order detail row and display it
                        while ($details_row = oci_fetch_array($stid_details, OCI_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($details_row['QUANTITY']) . "</td>";
                            echo "<td>" . htmlspecialchars($details_row['PRICE']) . "</td>";
                            echo "<td>" . htmlspecialchars($details_row['ORDER_ID']) . "</td>";
                            echo "</tr>";
                        }
        
                        echo "</table>";
                    } else {
                        $e = oci_error($stid_details);
                        echo "Error retrieving order details: " . htmlentities($e['message'], ENT_QUOTES);
                    }
                    oci_free_statement($stid_details);
                } else {
                    echo "No book found with the title: '" . htmlspecialchars($title) . "'.";
                }
            } else {
                $e = oci_error($stid);
                echo "Error retrieving ISBN: " . htmlentities($e['message'], ENT_QUOTES);
            }
        
            oci_free_statement($stid);
        }
        
        oci_close($conn);
        ?>
    </div>
   </main>
</body>
</html
