<?php
    include '../../header.php'; // Assuming 'header.php' is in the same directory as this file
    include '../../connectToDb.php';
?>
 <!DOCTYPE html>
<html>
<head>
    <title>Find User by Nickname</title>
</head>
<body>
    <form method="POST">
        <label for="nickname">Enter Nickname:</label>
        <input type="text" id="nickname" name="nickname">
        <button type="submit">Find User</button>
    </form>
</body>
</html>

<?php
    $conn = getDbConnection();
    if (isset($_POST['nickname'])) {
    $nickname = $_POST['nickname'];

    // Prepare the SQL query to find the ÜGYFÉLID
    $sql = 'SELECT UGYFELID FROM UGYFELEK WHERE NICKNAME = :nickname';
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':nickname', $nickname);

    if (oci_execute($stid)) {
        $row = oci_fetch_array($stid, OCI_ASSOC);
        if ($row) {
            $ugyfel_id = $row['UGYFELID'];

            // Prepare the SQL query to find all orders for the UGYFELID
            $sql_orders = 'SELECT * FROM ORDERS WHERE CUSTOMER_ID = :ugyfel_id';
            $stid_orders = oci_parse($conn, $sql_orders);
            oci_bind_by_name($stid_orders, ':ugyfel_id', $ugyfel_id);

            // Execute the query to get all orders
            if (oci_execute($stid_orders)) {

                echo "Orders for user '" . htmlspecialchars($nickname) . "':<br>";
                while ($order_row = oci_fetch_array($stid_orders, OCI_ASSOC)) {
                    echo "Order ID: " . htmlspecialchars($order_row['ORDER_ID']);

                    // Fetch ISBNs for the current ORDER_ID from the ORDER_DETAILS table
                    $sql_details = 'SELECT ISBN FROM ORDER_DETAILS WHERE ORDER_ID = :order_id';
                    $stid_details = oci_parse($conn, $sql_details);
                    oci_bind_by_name($stid_details, ':order_id', $order_row['ORDER_ID']);

                    if (oci_execute($stid_details)) {
                        echo ", ISBNs: ";
                        $isbns = [];
                        while ($details_row = oci_fetch_array($stid_details, OCI_ASSOC)) {
                            $isbns[] = htmlspecialchars($details_row['ISBN']);
                        }
                        echo implode(", ", $isbns) . "<br>";
                    } else {
                        $e = oci_error($stid_details);
                        echo " Error retrieving order details: " . htmlentities($e['message'], ENT_QUOTES) . "<br>";
                    }

                    oci_free_statement($stid_details);
                }
            } else {
                $e = oci_error($stid_orders);
                echo "Error retrieving orders: " . htmlentities($e['message'], ENT_QUOTES);
            }

            oci_free_statement($stid_orders);
        } else {
            echo "No user found with nickname '" . htmlspecialchars($nickname) . "'.";
        }
    } else {
        $e = oci_error($stid);
        echo "Error retrieving user: " . htmlentities($e['message'], ENT_QUOTES);
    }
}
  ?>