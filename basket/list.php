<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file

    print_r($_SESSION); // Debug: Print all session data

    // Handle delete request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_isbn'])) {
        // Loop through the basket and remove the item that matches the ISBN
        foreach ($_SESSION['basket'] as $key => $bookDetails) {
            if ($bookDetails['ISBN'] === $_POST['delete_isbn']) {
                unset($_SESSION['basket'][$key]);
                // Reindex the array to avoid skipped indices
                $_SESSION['basket'] = array_values($_SESSION['basket']);
                break;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basket</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-delete {
            color: #fff;
            background-color: #f44336;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        .checkout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50; /* Green */
            border: none;
            cursor: pointer;
        }
        .checkout-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Basket</h2>
    <table>
        <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
            $totalPrice = 0; // Initialize total price
            if(isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
                foreach ($_SESSION['basket'] as $bookDetails) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($bookDetails['ISBN']) . "</td>";
                    echo "<td>" . htmlspecialchars($bookDetails['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($bookDetails['author']) . "</td>";
                    echo "<td>$" . htmlspecialchars($bookDetails['price']) . "</td>";
                    // Add Delete button
                    echo "<td>
                            <form method='post'>
                                <input type='hidden' name='delete_isbn' value='" . htmlspecialchars($bookDetails['ISBN']) . "'>
                                <button type='submit' class='btn-delete'>Delete</button>
                            </form>
                          </td>";
                    $totalPrice += $bookDetails['price'];
                    echo "</tr>";
                }
                echo "<tr><td colspan='3' style='text-align: right; font-weight: bold;'>Total:</td><td>$" . number_format($totalPrice, 2) . "</td><td></td></tr>";
            } else {
                echo "<tr><td colspan='5'>Your basket is empty.</td></tr>";
            }
        ?>
    </table>
    <?php
        if (!empty($_SESSION['basket'])) {
            echo "<form action='checkout.php' method='post'>";
            echo "<button type='submit' class='checkout-btn'>Proceed to Checkout</button>";
            echo "</form>";
        }
    ?>
</body>
</html>
