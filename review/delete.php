<?php
  include '../connectToDb.php'; // Include your database connection script

  if (isset($_GET['REVIEW_ID']) &&!empty($_GET['REVIEW_ID'])) {
      $reviewId = $_GET['REVIEW_ID'];
      $conn = getDbConnection();

      if (!$conn) {
          echo "Unable to connect to the database.";
          exit;
      }

      // Prepare a DELETE statement to remove the review with the provided REVIEW_ID
      $sql = "DELETE FROM ERTEKELESEK WHERE REVIEW_ID = :reviewId";
      $stmt = oci_parse($conn, $sql);

      // Bind the REVIEW_ID to the statement
      oci_bind_by_name($stmt, ':reviewId', $reviewId);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "Review with ID ". htmlspecialchars($reviewId). " has been deleted successfully.";
          // Optionally, redirect or perform further actions
      } else {
          $e = oci_error($stmt);
          echo "Error deleting review: ". $e['message'];
      }

      oci_close($conn);
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/review/list.php");
        exit; 
  } else {
      echo "No REVIEW_ID provided.";
  }
?>