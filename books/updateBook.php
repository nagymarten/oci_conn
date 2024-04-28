<?php
  include '../connectToDb.php'; // Assuming this file sets up your database connection
  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['ISBN']) && !empty($_GET['ISBN'])) {
      $isbn = $_GET['ISBN'];
      $title = $_POST['title'];
      $author = $_POST['author'];
      $price = $_POST['price'];
      $genre = $_POST['genre'];
      $binding = $_POST['bookBinding'];
      $pageCount = $_POST['page_count'];
      $publisher = $_POST['publisher'];
      $pageSize = $_POST['pageSize'];
      $publishDate = $_POST['publisher_date'];

      $conn = getDbConnection();
      if (!$conn) {
          echo "Unable to connect to database.";
          exit;
      }

      // Update the book data in the database
      $sql = "UPDATE KONYVEK SET TITLE = :title, AUTHOR = :author, PRICE = :price, GENRE = :genre, 
              BOOK_BINDING = :binding, PAGE_COUNT = :pageCount, PUBLISHER = :publisher, 
              PAGE_SIZE = :pageSize, PUBLISHER_DATE = TO_DATE(:publishDate, 'YYYY-MM-DD') WHERE ISBN = :isbn";
      $stmt = oci_parse($conn, $sql);

      oci_bind_by_name($stmt, ':title', $title);
      oci_bind_by_name($stmt, ':author', $author);
      oci_bind_by_name($stmt, ':price', $price);
      oci_bind_by_name($stmt, ':genre', $genre);
      oci_bind_by_name($stmt, ':binding', $binding);
      oci_bind_by_name($stmt, ':pageCount', $pageCount);
      oci_bind_by_name($stmt, ':publisher', $publisher);
      oci_bind_by_name($stmt, ':pageSize', $pageSize);
      oci_bind_by_name($stmt, ':publishDate', $publishDate);
      oci_bind_by_name($stmt, ':isbn', $isbn);

      $result = oci_execute($stmt);
      if ($result) {
          echo "Book updated successfully.";
          // Optionally, redirect back to the book list or another appropriate page
          header("Location: list.php"); // Make sure this path is correct
          exit;
      } else {
          $e = oci_error($stmt);
          echo "Error updating book: " . $e['message'];
      }

      oci_free_statement($stmt);
      oci_close($conn);

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/books/list.php");
  } else {
      echo "No ISBN specified or wrong request method.";
  }
?>
