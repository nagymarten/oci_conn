<?php
  include '../connectToDb.php'; // Assumes you have a connection script

  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Collect all the input data
      $order_id = $_POST['order_id'];
      $customer_id = $_POST['customer_id'];
      $book_isbn = $_POST['book_isbn'];
      $order_date = $_POST['order_date'];
      $books = $_POST['books'];
      $cost = $_POST['cost'];

      // Prepare SQL insert statement
      $sql = "INSERT INTO ORDERS (ORDER_ID, CUSTOMER_ID, BOOK_ISBN, ORDER_DATE, BOOKS, COST) 
              VALUES (:order_id, :customer_id, :book_isbn, TO_DATE(:order_date, 'YYYY-MM-DD'), :books, :cost)";
      $stmt = oci_parse($conn, $sql);

      // Bind the variables to the statement
      oci_bind_by_name($stmt, ':order_id', $order_id);
      oci_bind_by_name($stmt, ':customer_id', $customer_id);
      oci_bind_by_name($stmt, ':book_isbn', $book_isbn);
      oci_bind_by_name($stmt, ':order_date', $order_date);
      oci_bind_by_name($stmt, ':books', $books);
      oci_bind_by_name($stmt, ':cost', $cost);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "New order created successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List orders</button>";   
      } else {
          $e = oci_error($stmt);
          echo "Error: " . $e['message'];
      }

      oci_close($conn);
  }
?>