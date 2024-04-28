<?php
  include '../connectToDb.php'; // Include your database connection script

  if (isset($_GET['STORE_ID']) && !empty($_GET['STORE_ID'])) {
      $isbn = $_GET['STORE_ID'];
      $conn = getDbConnection();

      if (!$conn) {
          echo "Unable to connect to the database.";
          exit;
      }

      // Prepare a DELETE statement to remove the book with the provided ISBN
      $sql = "DELETE FROM ARUHAZAK WHERE STORE_ID = :store_id";
      $stmt = oci_parse($conn, $sql);

      // Bind the ISBN to the statement
      oci_bind_by_name($stmt, ':store_id', $isbn);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "Store with STORE_ID " . htmlspecialchars($isbn) . " has been deleted successfully.";
          // Optionally, redirect or perform further actions
      } else {
          $e = oci_error($stmt);
          echo "Error deleting store: " . $e['message'];
      }

      oci_close($conn);
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/stores/list.php");
        exit; 
  } else {
      echo "No STORE_ID provided.";
  }
?>
