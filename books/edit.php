<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Book</title>
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
<?php include 'insertBook.php' ?>
<body>
    <h1>Edit Book</h1>
    <form action="insertBook.php" method="POST">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required>

        <label for="binding">Binding:</label>
        <input type="text" id="binding" name="binding" required>

        <label for="page_count">Page Count:</label>
        <input type="number" id="page_count" name="page_count" required>

        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" name="publisher" required>

        <label for="size">Size:</label>
        <input type="text" id="size" name="size" required>

        <label for="publisher_date">Publish Date:</label>
        <input type="date" id="publisher_date" name="publisher_date" required>

        <button type="submit">Create Book</button>
    </form>
</body>
</html>
