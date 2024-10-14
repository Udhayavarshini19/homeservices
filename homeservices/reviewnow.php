<?php
session_start();
include_once "./include/header.php"; 
include_once "./scripts/DB.php";

// Get provider ID from query parameter
$provider_id = isset($_GET['provider']) ? intval($_GET['provider']) : 0;

// Fetch provider information
$provider_sql = "SELECT * FROM providers WHERE id = :provider_id";
$provider_result = DB::query($provider_sql, ['provider_id' => $provider_id]);
$provider = $provider_result->fetch(PDO::FETCH_ASSOC);

if (!$provider) {
    echo "<h2>Provider not found.</h2>";
    exit;
}

// Fetch reviews for the provider
$reviews_sql = "SELECT * FROM reviews WHERE provider_id = :provider_id ORDER BY review_date DESC";
$reviews_result = DB::query($reviews_sql, ['provider_id' => $provider_id]);

?>

<h2 class="text-center" style="margin-top: 20px">
    <?php echo htmlspecialchars($provider['name']); ?> - Reviews
</h2>
<hr>

<!-- Display success message if review was submitted -->
<?php if (isset($_SESSION['review_success'])): ?>
    <div class="alert alert-success text-center">
        <?php echo $_SESSION['review_success']; ?>
    </div>
    <?php unset($_SESSION['review_success']); // Clear message ?>
<?php elseif (isset($_SESSION['review_error'])): ?>
    <div class="alert alert-danger text-center">
        <?php echo $_SESSION['review_error']; ?>
    </div>
    <?php unset($_SESSION['review_error']); // Clear error message ?>
<?php endif; ?>

<div class="container" style="margin-top: 20px; margin-bottom: 60px;">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Display Provider Photo if available -->
            <?php if (!empty($provider['photo'])): ?>
                <div class="text-center mb-3">
                    <img src="images/<?php echo htmlspecialchars($provider['photo']); ?>" alt="Provider Photo" style="height: 150px; width: 150px; border-radius: 50%;">
                </div>
            <?php endif; ?>

            <!-- Button to scroll down to review form -->
            <div class="text-center mb-4">
                <button class="btn btn-primary" id="leaveReviewBtn">Leave a Review</button>
            </div>

            <!-- Display Reviews at the top -->
            <h4>Reviews</h4>
            <?php if ($reviews_result->rowCount() > 0): ?>
                <?php while ($review = $reviews_result->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($review['reviewer_name']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rating: <?php echo htmlspecialchars($review['rating']); ?>/5</h6>
                            <p class="card-text"><?php echo htmlspecialchars($review['comment']); ?></p>
                            <p class="card-text"><small class="text-muted">Reviewed on <?php echo date('F j, Y', strtotime($review['review_date'])); ?></small></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review!</p>
            <?php endif; ?>

            <hr>

            <!-- Review Form (placed at the bottom now) -->
            <h4 id="reviewForm">Leave a Review</h4>
            <form action="submit_review.php" method="POST">
                <input type="hidden" name="provider_id" value="<?php echo htmlspecialchars($provider['id']); ?>" />
                <div class="form-group">
                    <label for="reviewer_name">Your Name</label>
                    <input type="text" class="form-control" name="reviewer_name" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select class="form-control" name="rating" required>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Below Average</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>
</div>

<!-- Scroll down to the review form using JavaScript -->
<script>
    document.getElementById('leaveReviewBtn').addEventListener('click', function() {
        // Smooth scroll to the review form
        document.getElementById('reviewForm').scrollIntoView({ behavior: 'smooth' });
    });
</script>

<?php include_once "./include/footer.php"; ?>
