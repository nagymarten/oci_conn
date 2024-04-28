<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Book Supply</title>
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
    <h1>Create New Book Supply</h1>
    <?php
    include '../connectToDb.php'; // Include your database connection script

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
        echo '<button onclick="window.location.pathname=\'oci_conn/konyvbeszerzes/insertBooksupply.php\'">Create New Book Supply</button>';
    }
    ?>
    //TODO: test parent key is available
    <form action="insertBooksupply.php" method="POST">
        <label for="book_isbn">Book ISBN:</label>
        <input type="text" id="book_isbn" name="book_isbn" required>

        <label for="supplyer_name">Supplyer Name:</label>
        <input type="text" id="supplyer_name" name="supplyer_name" required>

        <label for="supply_date">Supply Date:</label>
        <input type="date" id="supply_date" name="supply_date" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="total_cost">Total Cost:</label>
        <input type="number" id="total_cost" name="total_cost" step="0.01" required>

        <button type="submit">Create Book Supply</button>
    </form>
</body>
</html>