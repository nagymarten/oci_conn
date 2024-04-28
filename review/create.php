<?php include '../header.php'; ?>
<?php include 'insertReview.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Review</title>
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
    <h1>Create New Review</h1>
    <form action="insertReview.php" method="POST">
        <label for="review_id">Review ID:</label>
        <input type="text" id="review_id" name="review_id" required>
        //TODO: check customer id is legit
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" required>

        <label for="review_score">Review Score:</label>
        <input type="number" id="review_score" name="review_score" step="0.1" required>

        <label for="review_text">Review Text:</label>
        <textarea id="review_text" name="review_text" required></textarea>

        <label for="review_date">Review Date:</label>
        <input type="date" id="review_date" name="review_date" required>

        <button type="submit">Create Review</button>
    </form>
</body>
</html>