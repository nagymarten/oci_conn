<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Collect all the input data
      $customer_id = $_POST['customer_id'];

      // Prepare SQL insert statement
      $sql = "INSERT INTO REGULAR_CUSTOMER (CUSTOMER_ID) VALUES (:customer_id)";
      $stmt = oci_parse($conn, $sql);

      // Bind the variables to the statement
      oci_bind_by_name($stmt, ':customer_id', $customer_id);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "New regular customer created successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List regular customers</button>";   
      } else {
          $e = oci_error($stmt);
          echo "Error: ". $e['message'];
      }

      oci_close($conn);
  }
?>