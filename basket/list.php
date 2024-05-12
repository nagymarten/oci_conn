<?php
    include '../header.php';

    // Handling quantity changes
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['change_qty'], $_POST['isbn'], $_POST['new_qty'])) {
            foreach ($_SESSION['basket'] as $key => &$bookDetails) {
                if ($bookDetails['ISBN'] === $_POST['isbn']) {
                    $bookDetails['quantity'] = max(1, $_POST['new_qty']); // Ensure quantity is at least 1
                    break;
                }
            }
        }
        elseif (isset($_POST['delete_isbn'])) {
            foreach ($_SESSION['basket'] as $key => $bookDetails) {
                if ($bookDetails['ISBN'] === $_POST['delete_isbn']) {
                    unset($_SESSION['basket'][$key]);
                    $_SESSION['basket'] = array_values($_SESSION['basket']);
                    break;
                }
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
</head>
<body>
    <h2>Basket</h2>
    <div class="table-container">
        <table>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <?php
                $totalPrice = 0;
                if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
                    foreach ($_SESSION['basket'] as $bookDetails) {
                        $linePrice = $bookDetails['price'] * $bookDetails['quantity'];
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($bookDetails['ISBN']) . "</td>";
                        echo "<td>" . htmlspecialchars($bookDetails['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($bookDetails['author']) . "</td>";
                        echo "<td>" . htmlspecialchars($bookDetails['price']) . " FT</td>";
                        echo "<td>
                                <form action='' method='post'>
                                    <input type='hidden' name='isbn' value='" . htmlspecialchars($bookDetails['ISBN']) . "'>
                                    <input type='number' name='new_qty' value='" . $bookDetails['quantity'] . "' min='1' style='width: 50px;'>
                                    <button type='submit' name='change_qty'>Update</button>
                                </form>
                              </td>";
                        echo "<td>
                                <form action='' method='post'>
                                    <input type='hidden' name='delete_isbn' value='" . htmlspecialchars($bookDetails['ISBN']) . "'>
                                    <button type='submit' class='btn-delete'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                        $totalPrice += $linePrice;
                    }
                    echo "<tr><td colspan='4' style='text-align: right; font-weight: bold;'>Total:</td><td>" . number_format($totalPrice, 2) . " FT</td><td></td></tr>";
                } else {
                    echo "<tr><td colspan='6'>Your basket is empty.</td></tr>";
                }
            ?>
        </table>
    </div>
    <?php
        if (!empty($_SESSION['basket'])) {
            echo "<form action='checkout.php' method='POST'>";
            foreach ($_SESSION['basket'] as $bookDetails) {
                echo "<input type='hidden' name='isbn[]' value='" . htmlspecialchars($bookDetails['ISBN']) . "'>";
                echo "<input type='hidden' name='quantity[]' value='" . htmlspecialchars($bookDetails['quantity']) . "'>";
                echo "<input type='hidden' name='price[]' value='" . htmlspecialchars($bookDetails['price']) . "'>";
            }
            echo "<button type='submit' class='checkout-btn'>Proceed to Checkout</button>";
            echo "</form>";
        }
    ?>
</body>
</html>
