<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
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
    <h1>Edit Order</h1>
    <?php
    include '../connectToDb.php'; // Include your database connection script

    if (isset($_GET['ORDER_ID']) && !empty($_GET['ORDER_ID'])) {
        $orderId = $_GET['ORDER_ID'];
        $conn = getDbConnection();

        if (!$conn) {
            echo "Unable to connect to database.";
            exit;
        }

        // Fetch the order data from the database
        $sql = "SELECT ORDER_ID, CUSTOMER_ID, ORDER_DATE  FROM ORDERS WHERE ORDER_ID = :orderId";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':orderId', $orderId);
        oci_execute($stmt);
        $order = oci_fetch_array($stmt, OCI_ASSOC);

        if (!$order) {
            echo "Elem not found.";
            exit;
        } else {
            // Display the form with values filled in
            ?>
            <form action="updateOrder.php?ORDER_ID=<?php echo htmlspecialchars($orderId); ?>" method="POST">
                <label for="customer_id">Customer ID:</label>
                <input type="number" id="customer_id" name="customer_id" value="<?php echo htmlspecialchars($order['CUSTOMER_ID']); ?>" required>


                <label for="order_date">Order Date:</label>
                <input type="date" id="order_date" name="order_date" value="<?php echo date('Y-m-d', strtotime($order['ORDER_DATE'])); ?>" required>


                <button type="submit">Update Order</button>
            </form>
            <?php
        }
        oci_free_statement($stmt);
        oci_close($conn);
    } else {
        echo "No ORDER_ID specified.";
    }
    ?>
</body>
</html>