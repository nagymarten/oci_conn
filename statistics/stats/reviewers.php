<?php
  include '../../header.php';
  include '../../connectToDb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewers</title>
</head>
<body>
  <main class="flex column align-start justify-start">
     <div class="table-container">
      <h2>Reviewers</h2>
        <?php
          $conn = getDbConnection();

          $sql = 'SELECT u.NICKNAME, COUNT(e.CUSTOMER_ID) AS REVIEW_COUNT 
                  FROM ERTEKELESEK e 
                  JOIN UGYFELEK u ON u.UGYFELID = e.CUSTOMER_ID 
                  GROUP BY u.NICKNAME 
                  ORDER BY REVIEW_COUNT DESC';

          $stid = oci_parse($conn, $sql);

          // Execute the query
          if (oci_execute($stid)) {
              echo "<table>";
              echo "<thead><tr><th>Nickname</th><th>Review Count</th></tr></thead>";

              // Fetch each row and display it in the table
              while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['NICKNAME']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['REVIEW_COUNT']) . "</td>";
                  echo "</tr>";
              }

              echo "</table>";
          } else {
              $e = oci_error($stid);
              echo "Error retrieving user review counts: " . htmlentities($e['message'], ENT_QUOTES);
          }

          oci_free_statement($stid);
          oci_close($conn);

        ?>
     </div>
  </main>
</body>
</html
