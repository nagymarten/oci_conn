<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['SUPPLY_ID']) && !empty($_GET['SUPPLY_ID'])) {
      $supplyId = $_GET['SUPPLY_ID'];
      $bookIsbn = $_POST['book_isbn'];
      $supplyerName = $_POST['supplyer_name'];
      $supplyDate = $_POST['supply_date'];
      $quantity = $_POST['quantity'];
      $totalCost = $_POST['total_cost'];

      $conn = getDbConnection();
      if (!$conn) {
          echo "Unable to connect to database.";
          exit;
      }

      // Prepare SQL update statement
      $sql = "UPDATE KONYVBESZERZES SET BOOK_ISBN = :book_isbn, SUPPLYER_NAME = :supplyer_name, SUPPLY_DATE = TO_DATE(:supply_date, 'YYYY-MM-DD'), QUANTITY = :quantity, TOTAL_COST = :total_cost WHERE SUPPLY_ID = :supply_id";
      $stmt = oci_parse($conn, $sql);

      oci_bind_by_name($stmt, ':book_isbn', $bookIsbn);
      oci_bind_by_name($stmt, ':supplyer_name', $supplyerName);
      oci_bind_by_name($stmt, ':supply_date', $supplyDate);
      oci_bind_by_name($stmt, ':quantity', $quantity);
      oci_bind_by_name($stmt, ':total_cost', $totalCost);
      oci_bind_by_name($stmt, ':supply_id', $supplyId);

      $result = oci_execute($stmt);
      if ($result) {
          echo "Book supply updated successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List book supplies</button>";  

          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error updating book supply: " . $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
    //   header("Location: http://$host/oci_conn/konyvbeszerzes/list.php");
  } else {
      echo "No SUPPLY_ID specified or wrong request method.";
  }
?>