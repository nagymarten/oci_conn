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
  <main class="flex column align-start justify-start">
      <h2>Most active reviewer</h2>
      <?php
        $conn = getDbConnection();

        // Prepare the SQL query to count each CUSTOMER_ID and find the most frequent one
        $sql = 'SELECT CUSTOMER_ID, COUNT(CUSTOMER_ID) AS count FROM ERTEKELESEK GROUP BY CUSTOMER_ID ORDER BY count DESC FETCH FIRST 1 ROWS ONLY';
        $stid = oci_parse($conn, $sql);

        // Execute the query to get the most frequent CUSTOMER_ID
        if (oci_execute($stid)) {
            $row = oci_fetch_array($stid, OCI_ASSOC);
            if ($row) {
                $most_common_customer_id = $row['CUSTOMER_ID'];

                // Prepare the SQL query to find the user details for the most frequent CUSTOMER_ID
                $sql_user = 'SELECT NICKNAME FROM UGYFELEK WHERE UGYFELID = :customer_id';
                $stid_user = oci_parse($conn, $sql_user);
                oci_bind_by_name($stid_user, ':customer_id', $most_common_customer_id);

                // Execute the query to get user details
                if (oci_execute($stid_user)) {
                    $user_row = oci_fetch_array($stid_user, OCI_ASSOC);
                    if ($user_row) {
                        echo "Most of the reviews were submitted by the user " . htmlspecialchars($user_row['NICKNAME']);
                    } else {
                        echo "No user found with the customer ID: " . htmlspecialchars($most_common_customer_id);
                    }
                } else {
                    $e = oci_error($stid_user);
                    echo "Error retrieving user details: " . htmlentities($e['message'], ENT_QUOTES);
                }

                oci_free_statement($stid_user);
            } else {
                echo "No reviews found in ERTEKELESEK.";
            }
        } else {
            $e = oci_error($stid);
            echo "Error retrieving frequency of customer reviews: " . htmlentities($e['message'], ENT_QUOTES);
        }

        oci_free_statement($stid);
        oci_close($conn);
      ?>
  </main>
</body>
</html
