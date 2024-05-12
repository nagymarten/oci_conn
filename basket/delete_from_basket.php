<?php
// Start the session to access session variables
session_start();

// Include necessary files if required (e.g., for database connection, configurations)
// include 'path/to/required/file.php';

// Check if the delete request is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_isbn'])) {
    $deleteISBN = $_POST['delete_isbn'];

    // Check if the basket session variable is set and not empty
    if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
        // Loop through the basket
        foreach ($_SESSION['basket'] as $key => $bookDetails) {
            if ($bookDetails['ISBN'] === $deleteISBN) {
                // Remove the item from the basket
                unset($_SESSION['basket'][$key]);
                // Re-index the array after removing the item
                $_SESSION['basket'] = array_values($_SESSION['basket']);
                // Add a session flash message or similar to indicate success
                $_SESSION['message'] = "Item successfully removed from the basket.";
                break;
            }
        }
    } else {
        // If the basket is empty or not set
        $_SESSION['message'] = "No items in the basket to remove.";
    }
} else {
    // If the delete request is not proper or ISBN is not sent
    $_SESSION['message'] = "Invalid request.";
}

// Redirect back to the basket page or wherever appropriate
header('Location: list.php'); // Adjust the redirection path as necessary
exit();
?>
