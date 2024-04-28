<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection

  if (isset($_GET['CUSTOMER_ID']) && !empty($_GET['CUSTOMER_ID'])) {
      $customerId = $_GET['CUSTOMER_ID'];
      $conn = getDbConnection();

      if (!$conn) {
          echo "Unable to connect to the database.";
          exit;
      }

      // Prepare a DELETE statement to remove the customer with the provided CUSTOMER_ID
      $sql = "DELETE FROM REGULAR_CUSTOMER WHERE CUSTOMER_ID = :customerId";
      $stmt = oci_parse($conn, $sql);

      // Bind the CUSTOMER_ID to the statement
      oci_bind_by_name($stmt, ':customerId', $customerId);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "Customer with CUSTOMER_ID " . htmlspecialchars($customerId) . " has been deleted successfully.";
          // Optionally, redirect back to the customer list or another appropriate page
          header("Location: list.php"); // Make sure this path is correct
          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error deleting customer: " . $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/regular_customer/list.php");
  } else {
      echo "No CUSTOMER_ID specified.";
  }
?>