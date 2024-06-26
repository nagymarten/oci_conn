<?php
    include '../header.php'; // Assuming 'header.php' is in the same directory as this file

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y') {
       echo '<button onclick="window.location.pathname=\'oci_conn/regular_customer/create.php\'">Create New Regular Customer</button>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Regular Customers</title>
</head>
<body>
    <div class="table-container">
        <h2>List of Regular Customers</h2>
        <table>
            <?php
                include '../connectToDb.php';
                $conn = getDbConnection();
    
                echo "<form method='get' action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">
                    <div class=\"flex justify-start\">
                        <label for='search'>Search by Customer ID:</label>
                        <input type='number' id='search' name='search' placeholder='Enter customer ID...'>
                        <input type='submit' value='Search'>
                    </div>
                </form>";
    
    
                $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';
    
                echo '<tr>
                    <th>CUSTOMER_ID</th>
                ';
    
                if ($isAdmin) {
                    echo '<th>Delete</th>';
                }
                echo '</tr>';
    
                if (!$conn) {
                    echo "<tr><td colspan='10'>Unable to connect to the database.</td></tr>";
                } else {
                    $query = 'SELECT * FROM REGULAR_CUSTOMER';
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $query .= ' WHERE CUSTOMER_ID = :search';
                    }
                    $stid = oci_parse($conn, $query);
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        oci_bind_by_name($stid, ':search', $_GET['search']);
                    }
                    oci_execute($stid);
    
                    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                        echo "<tr>";
                        foreach ($row as $item) {
                            echo "<td>" . ($item !== null ? htmlspecialchars($item, ENT_QUOTES) : "&nbsp;") . "</td>";
                        };
                        if ($isAdmin) {
                            echo "<td><button onclick=\"window.location.href='delete.php?CUSTOMER_ID=" . urlencode($row['CUSTOMER_ID']) . "'\" class=\"btn-delete\">DELETE</button></td>";
                        };
                        echo "</tr>";
                    }
                    oci_free_statement($stid);
                    oci_close($conn);
                }
            ?>
        </table>
    </div>
</body>
</html>