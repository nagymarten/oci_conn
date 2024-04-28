<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        label, input, select {
            display: block;
            margin-top: 8px;
        }
        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Book</h1>
    <?php
    include '../connectToDb.php'; // Include your database connection script

    if (isset($_GET['ISBN']) && !empty($_GET['ISBN'])) {
        $bookId = $_GET['ISBN'];
        $conn = getDbConnection();

        if (!$conn) {
            echo "Unable to connect to database.";
            exit;
        }

        // Fetch the book data from the database
        $sql = "SELECT ISBN, TITLE, AUTHOR, PRICE, GENRE, BOOK_BINDING, PAGE_COUNT, PUBLISHER, PAGE_SIZE, PUBLISHER_DATE FROM KONYVEK WHERE ISBN = :ISBN";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':ISBN', $bookId);
        oci_execute($stmt);
        $book = oci_fetch_array($stmt, OCI_ASSOC);

        if (!$book) {
            echo "Elem not found.";
            exit;
        } else {
            // Display the form with values filled in
            ?>
            <form action="updateBook.php?ISBN=<?php echo htmlspecialchars($bookId); ?>" method="POST">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['TITLE']); ?>" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['AUTHOR']); ?>" required>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($book['PRICE']); ?>" step="0.01" required>

                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['GENRE']); ?>" required>

                <label for="bookBinding">Binding:</label>
                <input type="text" id="bookBinding" name="bookBinding" value="<?php echo htmlspecialchars($book['BOOK_BINDING']); ?>" required>

                <label for="page_count">Page Count:</label>
                <input type="number" id="page_count" name="page_count" value="<?php echo htmlspecialchars($book['PAGE_COUNT']); ?>" required>

                <label for="publisher">Publisher:</label>
                <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['PUBLISHER']); ?>" required>

                <label for="pageSize">Size:</label>
                <input type="text" id="pageSize" name="pageSize" value="<?php echo htmlspecialchars($book['PAGE_SIZE']); ?>" required>

               <label for="publisher_date">Publish Date: (currrent <?php echo $book['PUBLISHER_DATE'] ?>)</label>
               <input type="date" id="publisher_date" name="publisher_date" value="<?php echo date('d-m-y', strtotime($book['PUBLISHER_DATE'])); ?>" required>


                <button type="submit">Update Book</button>
            </form>
            <?php
        }
        oci_free_statement($stmt);
        oci_close($conn);
    } else {
        echo "No book ID specified.";
    }
    ?>
</body>
</html>
