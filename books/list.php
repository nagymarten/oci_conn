<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file
    include '../connectToDb.php';

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
        echo '<button onclick="window.location.pathname=\'oci_conn/books/create.php\'">Create New Book</button>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Books</title>
</head>
<body>
    <div class="table-container">
        <h2>List of Books</h2>
        <table>
            <?php
                $conn = getDbConnection();

                echo "<form method='get' action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">
                    <div class=\"flex justify-start\">
                        <label for='search'>Search by Title:</label>
                        <input type='text' id='search' name='search' placeholder='Enter book title...'>
                        <input type='submit' value='Search'>
                    </div>
                </form>";

                $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

                echo '<thead><tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Genre</th>
                <th>Book Binding</th>
                <th>Page Count</th>
                <th>Publisher</th>
                <th>Page Size</th>
                <th>Publish Date</th>
                <th>Quantity</th>'; 

                if ($isAdmin) {
                    echo '<th>Edit</th>';
                    echo '<th>Delete</th>';
                } else {
                    echo '<th>Add to Basket</th>';
                }
                echo '</tr></thead>';

                if (!$conn) {
                    echo "<tr><td colspan='12'>Unable to connect to the database.</td></tr>";
                } else {
                    $query = "SELECT k.ISBN, k.TITLE, k.AUTHOR, k.PRICE, k.GENRE, k.BOOK_BINDING, k.PAGE_COUNT, k.PUBLISHER, k.PAGE_SIZE, k.PUBLISHER_DATE, b.QUANTITY
                            FROM KONYVEK k
                            JOIN BOOK_SUPPLY b ON k.ISBN = b.BOOK_ISBN
                            WHERE b.QUANTITY > 0";

                    $stid = oci_parse($conn, $query);
                    oci_execute($stid);

                    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                        echo "<tr>";
                        foreach ($row as $item) {
                            echo "<td>" . ($item !== null ? htmlspecialchars($item, ENT_QUOTES) : "&nbsp;") . "</td>";
                        };
                        if ($isAdmin) {
                            echo "<td><button onclick=\"window.location.href='edit.php?ISBN=" . urlencode($row['ISBN']) . "'\" class=\"primary\">EDIT</button></td>";
                            echo "<td><button onclick=\"window.location.href='delete.php?ISBN=" . urlencode($row['ISBN']) . "'\" class=\"btn-delete\">DELETE</button></td>";
                        } else {
                        echo "
                        <td>
                                <form action='add_to_basket.php' method='post'>
                                    <input type='hidden' name='ISBN' value='" . htmlspecialchars($row['ISBN']) . "'>
                                    <button type='submit'>Add to Basket</button>
                                </form>
                            </td>";
                        }
                        echo "</tr>";
                    }
                    oci_free_statement($stid);
                    oci_close($conn);
                }
            ?>
        </table>
    </div>
</body>
</html
