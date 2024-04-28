<?php
  include '../connectToDb.php'; // Assumes you have a connection script

  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Collect all the input data
      $review_id = $_POST['review_id'];
      $customer_id = $_POST['customer_id'];
      $review_score = $_POST['review_score'];
      $review_text = $_POST['review_text'];
      $review_date = $_POST['review_date'];

      // Prepare SQL insert statement
      $sql = "INSERT INTO ERTEKELESEK (REVIEW_ID, CUSTOMER_ID, REVIEW_SCORE, REVIEW, REVIEW_DATE) 
              VALUES (:review_id, :customer_id, :review_score, :review_text, TO_DATE(:review_date, 'YYYY-MM-DD'))";
      $stmt = oci_parse($conn, $sql);

      // Bind the variables to the statement
      oci_bind_by_name($stmt, ':review_id', $review_id);
      oci_bind_by_name($stmt, ':customer_id', $customer_id);
      oci_bind_by_name($stmt, ':review_score', $review_score);
      oci_bind_by_name($stmt, ':review_text', $review_text);
      oci_bind_by_name($stmt, ':review_date', $review_date);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "New review created successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List reviews</button>";   
      } else {
          $e = oci_error($stmt);
          echo "Error: " . $e['message'];
      }

      oci_close($conn);
  }
?>