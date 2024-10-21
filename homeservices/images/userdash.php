<?php
session_start();
include_once './include/header.php';
include_once './scripts/DB.php';

// Check if the user is logged in and retrieve their ID
if (!isset($_SESSION['user_id'])) {
    header('Location: userlogin.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's pending bookings
$pendingBookings = DB::query("SELECT * FROM bookings WHERE user_id = ? AND status IN ('pending', 'accepted')", [$user_id])->fetchAll(PDO::FETCH_OBJ);

// Fetch user's completed or denied bookings
$historyBookings = DB::query("SELECT * FROM bookings WHERE user_id = ? AND status IN ('finished', 'denied')", [$user_id])->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container" style="margin-top: 30px;">
    <h3>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!</h3>

    <!-- Request New Service Button -->
    <div class="text-right mb-3">
        <a href="findservice.php" class="btn btn-primary">Request New Service</a>
    </div>

    <h4>Your Current Bookings</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Provider Name</th>
                <th>Date</th>
                <th>Address</th>
                <th>Problem</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingBookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking->id); ?></td>
                    <td><?= htmlspecialchars($booking->provider_id); // Adjust to show provider name ?></td>
                    <td><?= htmlspecialchars($booking->date); ?></td>
                    <td><?= htmlspecialchars($booking->adder); ?></td>
                    <td><?= htmlspecialchars($booking->queries); ?></td>
                    <td><?= htmlspecialchars($booking->status); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>Booking History</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Provider Name</th>
                <th>Date</th>
                <th>Address</th>
                <th>Problem</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historyBookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking->id); ?></td>
                    <td><?= htmlspecialchars($booking->provider_id); // Adjust to show provider name ?></td>
                    <td><?= htmlspecialchars($booking->date); ?></td>
                    <td><?= htmlspecialchars($booking->adder); ?></td>
                    <td><?= htmlspecialchars($booking->queries); ?></td>
                    <td><?= htmlspecialchars($booking->status); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once './include/footer.php'; ?>
