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

    if (isset($_GET['STORE_ID']) && !empty($_GET['STORE_ID'])) {
        $storeId = $_GET['STORE_ID'];
        $conn = getDbConnection();

        if (!$conn) {
            echo "Unable to connect to database.";
            exit;
        }

        // Fetch the store data from the database
        $sql = "SELECT STORE_ID, STORE_NAME, STORE_ADDRESS  FROM ARUHAZAK WHERE STORE_ID = :STORE_ID";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':STORE_ID', $storeId);
        oci_execute($stmt);
        $store = oci_fetch_array($stmt, OCI_ASSOC);

        if (!$store) {
            echo "Elem not found.";
            exit;
        } else {
            // Display the form with values filled in
            ?>
            <form action="updateStore.php?STORE_ID=<?php echo htmlspecialchars($storeId); ?>" method="POST">
                <label for="store_name">Name:</label>
                <input type="text" id="store_name" name="store_name" value="<?php echo htmlspecialchars($store['STORE_NAME']); ?>" required>

                <label for="store_address">Address:</label>
                <input type="text" id="store_address" name="store_address" value="<?php echo htmlspecialchars($store['STORE_ADDRESS']); ?>" required>

                <button type="submit">Update Store</button>
            </form>
            <?php
        }
        oci_free_statement($stmt);
        oci_close($conn);
    } else {
        echo "No store ID specified.";
    }
    ?>
</body>
</html>
