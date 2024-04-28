<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Collect all the input data
      $book_isbn = $_POST['book_isbn'];
      $supplyer_name = $_POST['supplyer_name'];
      $supply_date = $_POST['supply_date'];
      $quantity = $_POST['quantity'];
      $total_cost = $_POST['total_cost'];

      // Prepare SQL insert statement
      $sql = "INSERT INTO KONYVBESZERZES (BOOK_ISBN, SUPPLYER_NAME, SUPPLY_DATE, QUANTITY, TOTAL_COST) 
              VALUES (:book_isbn, :supplyer_name, TO_DATE(:supply_date, 'YYYY-MM-DD'), :quantity, :total_cost)";
      $stmt = oci_parse($conn, $sql);

      // Bind the variables to the statement
      oci_bind_by_name($stmt, ':book_isbn', $book_isbn);
      oci_bind_by_name($stmt, ':supplyer_name', $supplyer_name);
      oci_bind_by_name($stmt, ':supply_date', $supply_date);
      oci_bind_by_name($stmt, ':quantity', $quantity);
      oci_bind_by_name($stmt, ':total_cost', $total_cost);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "New book supply created successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List book supplies</button>";   
      } else {
          $e = oci_error($stmt);
          echo "Error: " . $e['message'];
      }

      oci_close($conn);
  }
?>