<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
       echo '<button onclick="window.location.pathname=\'oci_conn/konyvbeszerzes/create.php\'">Create New Book Supply</button>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Book Supplies</title>
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
    <h2>List of Book Supplies</h2>
    <table>
        <?php
            include '../connectToDb.php';
            $conn = getDbConnection();

            echo "<form method='get' action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">
                <label for='search'>Search by Book ISBN:</label>
                <input type='text' id='search' name='search' placeholder='Enter book ISBN...'>
                <input type='submit' value='Search'>
            </form>";


            $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

            echo '<tr>
                <th>SUPPLY_ID</th>
                <th>BOOK_ISBN</th>
                <th>SUPPLYER_NAME</th>
                <th>SUPPLY_DATE</th>
                <th>QUANTITY</th>
                <th>TOTAL_COST</th>
            ';

            if ($isAdmin) {
                echo '<th>Edit</th>';
                echo '<th>Delete</th>';
            }
            echo '</tr>';

            if (!$conn) {
                echo "<tr><td colspan='10'>Unable to connect to the database.</td></tr>";
            } else {
                $query = 'SELECT * FROM KONYVBESZERZES';
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $query .= ' WHERE BOOK_ISBN LIKE :search';
                }
                $stid = oci_parse($conn, $query);
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    oci_bind_by_name($stid, ':search', '%' . $_GET['search'] . '%');
                }
                oci_execute($stid);

                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>";
                    foreach ($row as $item) {
                        echo "<td>" . ($item !== null ? htmlspecialchars($item, ENT_QUOTES) : "&nbsp;") . "</td>";
                    };
                    if ($isAdmin) {
                        echo "<td><button onclick=\"window.location.href='edit.php?SUPPLY_ID=" . urlencode($row['SUPPLY_ID']) . "'\"'>EDIT</button></td>";
                        echo "<td><button onclick=\"window.location.href='delete.php?SUPPLY_ID=" . urlencode($row['SUPPLY_ID']) . "'\">DELETE</button></td>";
                    };
                    echo "</tr>";
                }
                oci_free_statement($stid);
                oci_close($conn);
            }
        ?>
    </table>
</body>
</html>