<?php
  include '../connectToDb.php'; // Include your database connection script

  if (isset($_GET['SUPPLY_ID']) && !empty($_GET['SUPPLY_ID'])) {
      $supplyId = $_GET['SUPPLY_ID'];
      $conn = getDbConnection();

      if (!$conn) {
          echo "Unable to connect to database.";
          exit;
      }

      // Prepare a DELETE statement to remove the book supply with the provided SUPPLY_ID
      $sql = "DELETE FROM KONYVBESZERZES WHERE SUPPLY_ID = :supplyId";
      $stmt = oci_parse($conn, $sql);

      // Bind the SUPPLY_ID to the statement
      oci_bind_by_name($stmt, ':supplyId', $supplyId);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "Book supply with SUPPLY_ID " . htmlspecialchars($supplyId) . " has been deleted successfully.";
          // Optionally, redirect back to the book supply list or another appropriate page
          header("Location: list.php"); // Make sure this path is correct
          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error deleting book supply: " . $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/konyvbeszerzes/list.php");
  } else {
      echo "No SUPPLY_ID specified.";
  }
?>