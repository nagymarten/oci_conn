<?php include '../header.php'; ?>
<?php include 'insertStore.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Store</title>
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
    <h1>Create New Store</h1>
    <form action="insertStore.php" method="POST">
        <label for="store_id">Store ID:</label>
        <input type="text" id="store_id" name="store_id" required>

        <label for="store_name">Title:</label>
        <input type="text" id="store_name" name="store_name" required>

        <label for="store_address">Author:</label>
        <input type="text" id="store_address" name="store_address" required>

        <button type="submit">Create Store</button>
    </form>
</body>
</html>
