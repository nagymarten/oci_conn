<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['ORDER_ID']) &&!empty($_GET['ORDER_ID'])) {
      $orderId = $_GET['ORDER_ID'];
      $customerId = $_POST['customer_id'];
      $bookIsbn = $_POST['book_isbn'];
      $orderDate = $_POST['order_date'];
      $books = $_POST['books'];
      $cost = $_POST['cost'];

      $conn = getDbConnection();
      if (!$conn) {
          echo "Unable to connect to database.";
          exit;
      }

      // Update the order data in the database
      $sql = "UPDATE ORDERS SET CUSTOMER_ID = :customerId, BOOK_ISBN = :bookIsbn, ORDER_DATE = TO_DATE(:orderDate, 'YYYY-MM-DD'), BOOKS = :books, COST = :cost WHERE ORDER_ID = :orderId";
      $stmt = oci_parse($conn, $sql);

      oci_bind_by_name($stmt, ':customerId', $customerId);
      oci_bind_by_name($stmt, ':bookIsbn', $bookIsbn);
      oci_bind_by_name($stmt, ':orderDate', $orderDate);
      oci_bind_by_name($stmt, ':books', $books);
      oci_bind_by_name($stmt, ':cost', $cost);
      oci_bind_by_name($stmt, ':orderId', $orderId);

      $result = oci_execute($stmt);
      if ($result) {
          echo "Order updated successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List orders</button>";  

          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error updating order: ". $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
    //   header("Location: http://$host/oci_conn/orders/list.php");
  } else {
      echo "No ORDER_ID specified or wrong request method.";
  }
?>