<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book Supply</title>
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
    <h1>Edit Book Supply</h1>
    <?php
    include '../connectToDb.php'; // Include your database connection script

    if (isset($_GET['SUPPLY_ID']) && !empty($_GET['SUPPLY_ID'])) {
        $supplyId = $_GET['SUPPLY_ID'];
        $conn = getDbConnection();

        if (!$conn) {
            echo "Unable to connect to database.";
            exit;
        }

        // Fetch the book supply data from the database
        $sql = "SELECT SUPPLY_ID, BOOK_ISBN, SUPPLYER_NAME, SUPPLY_DATE, QUANTITY, TOTAL_COST FROM KONYVBESZERZES WHERE SUPPLY_ID = :SUPPLY_ID";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':SUPPLY_ID', $supplyId);
        oci_execute($stmt);
        $bookSupply = oci_fetch_array($stmt, OCI_ASSOC);

        if (!$bookSupply) {
            echo "Elem not found.";
            exit;
        } else {
            // Display the form with values filled in
            ?>
            <form action="updateBooksupply.php?SUPPLY_ID=<?php echo htmlspecialchars($supplyId); ?>" method="POST">
                <label for="book_isbn">Book ISBN:</label>
                <input type="text" id="book_isbn" name="book_isbn" value="<?php echo htmlspecialchars($bookSupply['BOOK_ISBN']); ?>" required>

                <label for="supplyer_name">Supplyer Name:</label>
                <input type="text" id="supplyer_name" name="supplyer_name" value="<?php echo htmlspecialchars($bookSupply['SUPPLYER_NAME']); ?>" required>

                <label for="supply_date">Supply Date:</label>
                <input type="date" id="supply_date" name="supply_date" value="<?php echo date('Y-m-d', strtotime($bookSupply['SUPPLY_DATE'])); ?>" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($bookSupply['QUANTITY']); ?>" required>

                <label for="total_cost">Total Cost:</label>
                <input type="number" id="total_cost" name="total_cost" value="<?php echo htmlspecialchars($bookSupply['TOTAL_COST']); ?>" step="0.01" required>

                <button type="submit">Update Book Supply</button>
            </form>
            <?php
        }
        oci_free_statement($stmt);
        oci_close($conn);
    } else {
        echo "No SUPPLY_ID specified.";
    }
    ?>
</body>
</html>