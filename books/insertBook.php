<?php
  include '../connectToDb.php'; // Assumes you have a connection script

  $conn = getDbConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Collect all the input data
      $isbn = $_POST['isbn'];
      $title = $_POST['title'];
      $author = $_POST['author'];
      $price = $_POST['price'];
      $genre = $_POST['genre'];
      $bookBinding = $_POST['bookBinding'];
      $page_count = $_POST['page_count'];
      $publisher = $_POST['publisher'];
      $pageSize = $_POST['pageSize'];
      $publisher_date = $_POST['publisher_date'];

      // Prepare SQL insert statement
      $sql = "INSERT INTO KONYVEK (ISBN, TITLE, AUTHOR, PRICE, GENRE, BOOK_BINDING, PAGE_COUNT, PUBLISHER, PAGE_SIZE, PUBLISHER_DATE) 
              VALUES (:isbn, :title, :author, :price, :genre, :bookBinding, :page_count, :publisher, :pageSize, TO_DATE(:publisher_date, 'YYYY-MM-DD'))";
      $stmt = oci_parse($conn, $sql);

      // Bind the variables to the statement
      oci_bind_by_name($stmt, ':isbn', $isbn);
      oci_bind_by_name($stmt, ':title', $title);
      oci_bind_by_name($stmt, ':author', $author);
      oci_bind_by_name($stmt, ':price', $price);
      oci_bind_by_name($stmt, ':genre', $genre);
      oci_bind_by_name($stmt, ':bookBinding', $bookBinding);
      oci_bind_by_name($stmt, ':page_count', $page_count);
      oci_bind_by_name($stmt, ':publisher', $publisher);
      oci_bind_by_name($stmt, ':pageSize', $pageSize);
      oci_bind_by_name($stmt, ':publisher_date', $publisher_date);

      // Execute the statement
      $result = oci_execute($stmt);

      if ($result) {
          echo "New book created successfully.";
          echo "<br>";
          echo "<button onclick=\"window.location.href = 'list.php';\">List books</button>";   
      } else {
          $e = oci_error($stmt);
          echo "Error: " . $e['message'];
      }

      oci_close($conn);
  }
?>
