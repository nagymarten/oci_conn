<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file

    print_r($_SESSION); // Debug: Print all session data
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
            <!-- Add more columns as needed for other book details -->
        </tr>
        <?php
            // Check if the basket session variable is set and not empty
            if(isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
                // Loop through each item in the basket and display its details
                foreach ($_SESSION['basket'] as $bookDetails) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($bookDetails['ISBN']) . "</td>";
                    echo "<td>" . htmlspecialchars($bookDetails['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($bookDetails['author']) . "</td>";
                    echo "<td>" . htmlspecialchars($bookDetails['price']) . "</td>";
                    // Add more columns as needed for other book details
                    echo "</tr>";
                }
            } else {
                // Display a message if the basket is empty
                echo "<tr><td colspan='4'>Your basket is empty.</td></tr>";
            }
        ?>
    </table>
</body>
</html>
