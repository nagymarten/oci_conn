<?php
  include '../../header.php';
  include '../../connectToDb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best customers</title>
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
    <h2>Best genre</h2>
    <table>
        <?php
            $conn = getDbConnection();
            $sql = 'SELECT ISBN, COUNT(ISBN) AS count FROM ORDER_DETAILS GROUP BY ISBN ORDER BY count DESC FETCH FIRST 1 ROWS ONLY';
            $stid = oci_parse($conn, $sql);

            if (oci_execute($stid)) {
              $row = oci_fetch_array($stid, OCI_ASSOC);
              if ($row) {
                  $most_common_isbn = $row['ISBN'];
                  echo "Best seller ISBN: " . htmlspecialchars($most_common_isbn) . "<br><br>";
          
                  $sql_order_ids = 'SELECT ORDER_ID FROM ORDER_DETAILS WHERE ISBN = :isbn';
                  $stid_order_ids = oci_parse($conn, $sql_order_ids);
                  oci_bind_by_name($stid_order_ids, ':isbn', $most_common_isbn);
          
                  if (oci_execute($stid_order_ids)) {
                      echo "Orders containing the most common ISBN:<br>";
          
                      // Fetch each ORDER_ID and then query the ORDERS table for the corresponding CUSTOMER_ID
                      while ($order_details_row = oci_fetch_array($stid_order_ids, OCI_ASSOC)) {
                          $order_id = $order_details_row['ORDER_ID'];
                          
                          // Now get the CUSTOMER_ID from the ORDERS table
                          $sql_customer = 'SELECT CUSTOMER_ID FROM ORDERS WHERE ORDER_ID = :order_id';
                          $stid_customer = oci_parse($conn, $sql_customer);
                          oci_bind_by_name($stid_customer, ':order_id', $order_id);
          
                          if (oci_execute($stid_customer)) {
                              $customer_row = oci_fetch_array($stid_customer, OCI_ASSOC);
                              if ($customer_row) {
                                  $customer_id = $customer_row['CUSTOMER_ID'];
          
                                  // Finally, get the user details from the UGYFELEK table
                                  $sql_user = 'SELECT * FROM UGYFELEK WHERE UGYFELID = :customer_id';
                                  $stid_user = oci_parse($conn, $sql_user);
                                  oci_bind_by_name($stid_user, ':customer_id', $customer_id);
          
                                  if (oci_execute($stid_user)) {
                                      $user_row = oci_fetch_array($stid_user, OCI_ASSOC);
                                      if ($user_row) {
                                          echo "Order ID: $order_id, Customer ID: $customer_id, User Nickname: " . htmlspecialchars($user_row['NICKNAME']) . "<br>";
                                      }
                                  }
                                  oci_free_statement($stid_user);
                              }
                          }
                          oci_free_statement($stid_customer);
                      }
                  }
                  oci_free_statement($stid_order_ids);
              } else {
                  echo "No ISBNs found in ORDER_DETAILS.";
              }
            } else {
                $e = oci_error($stid);
                echo "Error retrieving ISBN frequency: " . htmlentities($e['message'], ENT_QUOTES);
            }
        ?>
    </table>
</body>
</html
