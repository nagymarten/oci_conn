<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['STORE_ID']) &&!empty($_GET['STORE_ID'])) {
      $storeId = $_GET['STORE_ID'];
      $storeName = $_POST['store_name'];
      $storeAddress = $_POST['store_address'];

      $conn = getDbConnection();
      if (!$conn) {
          echo "Unable to connect to database.";
          exit;
      }

      // Update the store data in the database
      $sql = "UPDATE ARUHAZAK SET STORE_NAME = :storeName, STORE_ADDRESS = :storeAddress WHERE STORE_ID = :storeId";
      $stmt = oci_parse($conn, $sql);

      oci_bind_by_name($stmt, ':storeName', $storeName);
      oci_bind_by_name($stmt, ':storeAddress', $storeAddress);
      oci_bind_by_name($stmt, ':storeId', $storeId);

      $result = oci_execute($stmt);
      if ($result) {
          echo "Store updated successfully.";
          // Optionally, redirect back to the store list or another appropriate page
          header("Location: list.php"); // Make sure this path is correct
          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error updating store: ". $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/stores/list.php");
  } else {
      echo "No store ID specified or wrong request method.";
  }
?>