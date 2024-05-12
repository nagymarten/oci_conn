<?php
include '../header.php';
include '../connection.php';

// Start or continue the session (if not already started in header.php)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$jsonOrderData = ''; // Initialize an empty string for the JSON data

// Check if the correct data has been posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isbn'], $_POST['quantity'], $_POST['price'])) {
    // Collect POST data
    $isbnArray = $_POST['isbn'];
    $quantityArray = $_POST['quantity'];
    $priceArray = $_POST['price'];

    // Create an associative array to structure the order data
    $orderData = [];
    $orderData['items'] = [];

    // Populate order items
    for ($i = 0; $i < count($isbnArray); $i++) {
        $orderData['items'][] = [
            'ISBN' => $isbnArray[$i],
            'Quantity' => $quantityArray[$i],
            'Price' => $priceArray[$i]
        ];
    }

    // Encode data to JSON
    $jsonOrderData = json_encode($orderData, JSON_PRETTY_PRINT);
    
    $conn = getDbConnection();
    $sql = 'BEGIN PLACE_ORDER(:customerId, :orders); END;';
    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':customerId', $customerId);
    oci_bind_by_name($stmt, ':orders', $jsonOrderData);
    
    oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);
    
    // Clear the basket after processing
    $_SESSION['basket'] = [];

} else {
    // If accessed without POST data, redirect to the basket or home page
    header('Location: basket.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order! Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account to view details of this transaction.</p>
    <?php
    if (!empty($jsonOrderData)) {
        echo "<h2>Your Order Details:</h2>";
        echo "<pre>" . htmlspecialchars($jsonOrderData) . "</pre>";
    }
    ?>
    <a href="index.php">Return to Home</a>
</body>
</html>
