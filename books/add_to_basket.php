<?php
include '../header.php'; // Assuming 'header.php' starts the session
session_start(); // Start the session if it's not already started in header.php

// Check if ISBN is provided in the request
if(isset($_POST['ISBN']) && !empty($_POST['ISBN'])) { 
    $ISBN = $_POST['ISBN'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Default quantity to 1 if not specified

    echo '<script> console.log("ISBN: ' . $ISBN . '");</script>';

    // Fetch or simulate fetching book details
    $bookDetails = getBookDetailsByISBN($ISBN);
    echo "<script>console.log(" . json_encode($bookDetails) . ");</script>";

    // Check if the book details are retrieved successfully
    if($bookDetails !== null) {
        // Initialize or update the book in the basket session variable
        $found = false;
        foreach ($_SESSION['basket'] as &$item) {
            if ($item['ISBN'] == $ISBN) {
                $item['quantity'] += $quantity; // Update quantity if the book is already in the basket
                $found = true;
                break;
            }
        }
        if (!$found) {
            $bookDetails['quantity'] = $quantity; // Set quantity for new addition
            $_SESSION['basket'][] = $bookDetails;
        }

        // Redirect back to the book listing page with a success message
        header('Location: list.php?added_to_basket');
        exit();
    } else {
        // Redirect back to the book listing page with an error message
        header('Location: list.php?error=book_not_found');
        exit();
    }
} else {
    // Redirect back to the book listing page if ISBN is not provided or empty
    header('Location: list.php?error=missing_ISBN');
    exit();
}

// Function to simulate fetching book details based on ISBN
function getBookDetailsByISBN($ISBN) {
    include '../connectToDb.php'; // Ensure database connection is available
    $conn = getDbConnection();

    if ($conn) {
        $query = 'SELECT ISBN, TITLE, AUTHOR, PRICE FROM KONYVEK WHERE ISBN = :isbn';
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':isbn', $ISBN);

        if (oci_execute($stmt)) {
            $row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS);
            if ($row) {
                // Construct an array to hold book details
                $bookDetails = array(
                    'ISBN' => $row['ISBN'],
                    'title' => $row['TITLE'],
                    'author' => $row['AUTHOR'],
                    'price' => $row['PRICE']
                );
                echo "<script>console.log('Book Details: ', " . json_encode($bookDetails) . ");</script>";
                return $bookDetails;
            }
        }
        oci_free_statement($stmt);
        oci_close($conn);
    }
    return null; // Return null if no book is found or in case of an error
}
?>