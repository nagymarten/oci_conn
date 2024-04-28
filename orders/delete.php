<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection

  if (isset($_GET['ORDER_ID']) && !empty($_GET['ORDER_ID'])) {
      $orderId = $_GET['ORDER_ID'];
      $conn = getDbConnection();

      if (!$conn) {
          echo "Unable to connect to the database.";
          exit;
      }

      // Prepare a DELETE statement to remove the order with the provided ORDER_ID
      $sql = "DELETE FROM ORDERS WHERE ORDER_ID = :orderId";
      $stmt = oci_parse($conn, $sql);

      // Bind the ORDER_ID to the statement
      oci_bind_by_name($stmt, ':orderId', $orderId);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "Order with ORDER_ID " . htmlspecialchars($orderId) . " has been deleted successfully.";
          // Optionally, redirect back to the order list or another appropriate page
          header("Location: list.php"); // Make sure this path is correct
          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error deleting order: " . $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/orders/list.php");
  } else {
      echo "No ORDER_ID specified.";
  }
?>