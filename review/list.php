<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
       echo '<button onclick="window.location.pathname=\'oci_conn/review/create.php\'">Create New Review</button>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Reviews</title>
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
    <h2>List of Reviews</h2>
    <table>
        <?php
            include '../connectToDb.php';
            $conn = getDbConnection();

            echo "<form method='get' action=\"". htmlspecialchars($_SERVER['PHP_SELF']). "\">
                <label for='search'>Search by Customer ID:</label>
                <input type='number' id='search' name='search' placeholder='Enter customer ID...'>
                <input type='submit' value='Search'>
            </form>";

            $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

            echo '<tr>
                <th>Review ID</th>
                <th>Customer ID</th>
                <th>Review Score</th>
                <th>Review</th>
                <th>Review Date</th>
            ';

            if ($isAdmin) {
                echo '<th>Edit</th>';
                echo '<th>Delete</th>';
            }
            echo '</tr>';

            if (!$conn) {
                echo "<tr><td colspan='10'>Unable to connect to the database.</td></tr>";
            } else {
                $query = 'SELECT * FROM ERTEKELESEK';
                $stid = oci_parse($conn, $query);
                oci_execute($stid);

                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>";
                    foreach ($row as $item) {
                        echo "<td>". ($item!== null? htmlspecialchars($item, ENT_QUOTES) : "&nbsp;"). "</td>";
                    };
                    if ($isAdmin) {
                        echo "<td><button onclick=\"window.location.href='edit.php?REVIEW_ID=". urlencode($row['REVIEW_ID']). "'\"'>EDIT</button></td>";
                        echo "<td><button onclick=\"window.location.href='delete.php?REVIEW_ID=". urlencode($row['REVIEW_ID']). "'\">DELETE</button></td>";
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