<?php
function getDbConnection() {
    $USERNAME = 'C##LZAOLF';
    $PASSWORD = 'C##LZAOLF'; 
    $dbstr1 ="
    (DESCRIPTION =
    (ADDRESS_LIST =
    (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
    (SID = orania2)
    )
    )";

    $conn = oci_connect($USERNAME, $PASSWORD, $dbstr1, 'AL32UTF8');

    if(!$conn) {
        $m = oci_error();
        trigger_error(htmlentities($m['message'], ENT_QUOTES), E_USER_ERROR);
        return null; // Ensure that null is returned if the connection fails
    }
    return $conn;
}

// Optionally, check connection when this file is accessed directly
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    $conn = getDbConnection();
    if ($conn) {
        echo "Your Connection is Successful";
    }
}
?>
