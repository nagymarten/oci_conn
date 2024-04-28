<?php include '../header.php'; ?>
<?php include 'insertOrder.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Order</title>
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
    <h1>Create New Order</h1>
    <form action="insertOrder.php" method="POST">
        <label for="order_id">Order ID:</label>
        <input type="text" id="order_id" name="order_id" required>
        <!-- TODO: check customer id is legit -->
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" required>
        <!-- TODO: check book id is legit -->

        <label for="book_isbn">Book ISBN:</label>
        <input type="text" id="book_isbn" name="book_isbn" required>

        <label for="books">Number of Books:</label>
        <input type="number" id="books" name="books" required>

        <label for="cost">Cost:</label>
        <input type="number" id="cost" name="cost" step="0.01" required>

        <label for="order_date">Order Date:</label>
        <input type="date" id="order_date" name="order_date" required>

        <button type="submit">Create Order</button>
    </form>
</body>
</html>