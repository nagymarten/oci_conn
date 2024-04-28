<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['REVIEW_ID']) &&!empty($_GET['REVIEW_ID'])) {
      $reviewId = $_GET['REVIEW_ID'];
      $customerId = $_POST['customer_id'];
      $reviewScore = $_POST['review_score'];
      $review = $_POST['review'];
      $reviewDate = $_POST['review_date'];

      $conn = getDbConnection();
      if (!$conn) {
          echo "Unable to connect to database.";
          exit;
      }

      // Update the review data in the database
      $sql = "UPDATE ERTEKELESEK SET CUSTOMER_ID = :customerId, REVIEW_SCORE = :reviewScore, REVIEW = :review, REVIEW_DATE = TO_DATE(:reviewDate, 'YYYY-MM-DD') WHERE REVIEW_ID = :reviewId";
      $stmt = oci_parse($conn, $sql);

      oci_bind_by_name($stmt, ':customerId', $customerId);
      oci_bind_by_name($stmt, ':reviewScore', $reviewScore);
      oci_bind_by_name($stmt, ':review', $review);
      oci_bind_by_name($stmt, ':reviewDate', $reviewDate);
      oci_bind_by_name($stmt, ':reviewId', $reviewId);

      $result = oci_execute($stmt);
      if ($result) {
          echo "Review updated successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List books</button>";  

          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error updating review: ". $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
    //   header("Location: http://$host/oci_conn/review/list.php");
  } else {
      echo "No ISBN specified or wrong request method.";
  }
?>