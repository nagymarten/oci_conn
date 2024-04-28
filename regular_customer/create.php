<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Regular Customer</title>
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
    <h1>Create New Regular Customer</h1>
    <?php
    include '../connectToDb.php'; // Include your database connection script

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
        // TODO: inspect has parent
        echo '<button onclick="window.location.pathname=\'oci_conn/regular_customers/insertRegularCustomer.php\'">Create New Regular Customer</button>';
    }
   ?>
    <form action="insertRegularCustomer.php" method="POST">
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" required>

        <button type="submit">Create Regular Customer</button>
    </form>
</body>
</html>