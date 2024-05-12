<?php
  include '../../header.php';
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
  <main>
    <div class="table-container">
    <h2>Regular customers list</h2>
      <?php
          $conn = getDbConnection();
          $sql = 'SELECT u.NICKNAME, u.KONYVEKVASAROLVA 
                  FROM UGYFELEK u 
                  JOIN REGULAR_CUSTOMER rc ON u.UGYFELID = rc.CUSTOMER_ID';
          
          $stid = oci_parse($conn, $sql);
          
          // Execute the query
          if (oci_execute($stid)) {
              echo "<table>";
              echo "<thead><tr><th>Nickname</th><th>Books Purchased</th></tr></thead>";
          
              // Fetch each row and display it in the table
              while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['NICKNAME']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['KONYVEKVASAROLVA']) . "</td>";
                  echo "</tr>";
              }
          
              echo "</table>";
          } else {
              $e = oci_error($stid);
              echo "Error retrieving regular customer details: " . htmlentities($e['message'], ENT_QUOTES);
          }
          
          oci_free_statement($stid);
          oci_close($conn);
        ?>
    </div>
  </main>
</body>
</html
