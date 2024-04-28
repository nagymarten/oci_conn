<?php
  include '../connectToDb.php'; // Assumes you have a connection script

  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Collect all the input data
      $store_id = $_POST['store_id'];
      $store_name = $_POST['store_name'];
      $store_address = $_POST['store_address'];

      // Prepare SQL insert statement
      $sql = "INSERT INTO ARUHAZAK (STORE_ID, STORE_NAME, STORE_ADDRESS) 
              VALUES (:store_id, :store_name, :store_address)";
      $stmt = oci_parse($conn, $sql);

      // Bind the variables to the statement
      oci_bind_by_name($stmt, ':store_id', $store_id);
      oci_bind_by_name($stmt, ':store_name', $store_name);
      oci_bind_by_name($stmt, ':store_address', $store_address);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "New store created successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List books</button>";      } else {
          $e = oci_error($stmt);
          echo "Error: ". $e['message'];
      }

      oci_close($conn);
  }
?>