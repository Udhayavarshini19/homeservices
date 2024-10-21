<?php
include_once "./include/header.php";
include_once "./scripts/DB.php";
require_once "./scripts/session.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: userlogin.php');
    exit();
}

// Get logged-in user ID
$user_id = $_SESSION['user_id'];

// Fetch all bookings for the logged-in user
$bookings = DB::query("SELECT bookings.id, bookings.date, bookings.status, providers.name as provider_name, providers.profession 
                       FROM bookings
                       JOIN providers ON bookings.provider_id = providers.id
                       WHERE bookings.user_id = ?
                       ORDER BY bookings.date DESC", [$user_id])->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container" style="margin-top: 30px;">
    <h3>Your Service Bookings</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Provider Name</th>
                    <th>Profession</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($bookings) > 0): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking->id); ?></td>
                            <td><?= htmlspecialchars($booking->provider_name); ?></td>
                            <td><?= htmlspecialchars($booking->profession); ?></td>
                            <td><?= htmlspecialchars($booking->date); ?></td>
                            <td><?= htmlspecialchars($booking->status); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "./include/footer.php"; ?>