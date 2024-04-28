<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <style>
        label, input, select {
            display: block;
            margin-top: 8px;
        }
        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Review</h1>
    <?php
    include '../connectToDb.php'; // Include your database connection script

    if (isset($_GET['REVIEW_ID']) &&!empty($_GET['REVIEW_ID'])) {
        $reviewId = $_GET['REVIEW_ID'];
        $conn = getDbConnection();

        if (!$conn) {
            echo "Unable to connect to database.";
            exit;
        }

        // Fetch the review data from the database
        $sql = "SELECT REVIEW_ID, CUSTOMER_ID, REVIEW_SCORE, REVIEW, REVIEW_DATE FROM ERTEKELESEK WHERE REVIEW_ID = :REVIEW_ID";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':REVIEW_ID', $reviewId);
        oci_execute($stmt);
        $review = oci_fetch_array($stmt, OCI_ASSOC);

        if (!$review) {
            echo "Review not found.";
            exit;
        } else {
            // Display the form with values filled in
           ?>
            <form action="updateReview.php?REVIEW_ID=<?php echo htmlspecialchars($reviewId);?>" method="POST">
                <label for="customer_id">Customer ID:</label>
                <input type="number" id="customer_id" name="customer_id" value="<?php echo htmlspecialchars($review['CUSTOMER_ID']);?>" required>
                <!-- TODO: set boundries for score -->
                <label for="review_score">Review Score:</label>
                <input type="number" id="review_score" name="review_score" value="<?php echo htmlspecialchars($review['REVIEW_SCORE']);?>" required>

                <label for="review">Review:</label>
                <textarea id="review" name="review" required><?php echo htmlspecialchars($review['REVIEW']);?></textarea>

                <label for="review_date">Review Date: (current <?php echo $review['REVIEW_DATE']?>)</label>
                <input type="date" id="review_date" name="review_date" value="<?php echo date('d-m-y', strtotime($review['REVIEW_DATE']));?>" required>

                <button type="submit">Update Review</button>
            </form>
            <?php
        }
        oci_free_statement($stmt);
        oci_close($conn);
    } else {
        echo "No review ID specified.";
    }
   ?>
</body>
</html>