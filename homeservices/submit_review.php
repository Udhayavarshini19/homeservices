<?php
session_start();
include_once "./scripts/DB.php";

// Get POST data
$provider_id = $_POST['provider_id'];
$reviewer_name = $_POST['reviewer_name'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Insert review into database
$insert_sql = "INSERT INTO reviews (provider_id, reviewer_name, rating, comment, review_date) 
               VALUES (:provider_id, :reviewer_name, :rating, :comment, NOW())";
$insert_params = [
    'provider_id' => $provider_id,
    'reviewer_name' => $reviewer_name,
    'rating' => $rating,
    'comment' => $comment,
];

if (DB::query($insert_sql, $insert_params)) {
    // Set success message in session
    $_SESSION['review_success'] = "Your review has been successfully submitted.";
} else {
    // Set error message in session (optional)
    $_SESSION['review_error'] = "There was an error submitting your review. Please try again.";
}

// Redirect back to the provider's review page
header("Location: ./reviewnow.php?provider=$provider_id");
exit;
?>
