<?php
  include '../connectToDb.php'; // Include your database connection script

  if (isset($_GET['ISBN']) && !empty($_GET['ISBN'])) {
      $isbn = $_GET['ISBN'];
      $conn = getDbConnection();

      if (!$conn) {
          echo "Unable to connect to the database.";
          exit;
      }

      // Prepare a DELETE statement to remove the book with the provided ISBN
      $sql = "DELETE FROM KONYVEK WHERE ISBN = :isbn";
      $stmt = oci_parse($conn, $sql);

      // Bind the ISBN to the statement
      oci_bind_by_name($stmt, ':isbn', $isbn);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "Book with ISBN " . htmlspecialchars($isbn) . " has been deleted successfully.";
          // Optionally, redirect or perform further actions
      } else {
          $e = oci_error($stmt);
          echo "Error deleting book: " . $e['message'];
      }

      oci_close($conn);
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/books/list.php");
        exit; 
  } else {
      echo "No ISBN provided.";
  }
?>
