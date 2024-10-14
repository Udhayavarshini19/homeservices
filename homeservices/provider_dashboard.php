<?php
session_start();
include_once "./include/header.php";
include_once "./scripts/DB.php";

if (!isset($_SESSION['provider_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve the logged-in provider's ID
$providerId = $_SESSION['provider_id'];

// Fetch provider information based on the logged-in provider ID
$provider = DB::query("SELECT * FROM providers WHERE id=?", [$providerId])->fetch(PDO::FETCH_OBJ);

if ($provider === false) {
    echo "<p>Provider details not found.</p>";
    exit();
}

// Fetch bookings associated with this provider
$bookings = DB::query("SELECT * FROM bookings WHERE provider_id=? ORDER BY status DESC, date DESC", [$providerId])->fetchAll(PDO::FETCH_OBJ);

?>

<div class="container" style="margin-top: 30px;">
    <div class="card text-center">
        <div class="card-header">
            <h3>Dashboard for <?= htmlspecialchars($provider->name); ?></h3>
        </div>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col">
                    <img style="height: 250px" src="images/<?= htmlspecialchars($provider->photo); ?>" alt="<?= htmlspecialchars($provider->name); ?>">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td><?= htmlspecialchars($provider->name); ?></td>
                    <th>Profession</th>
                    <td><?= htmlspecialchars($provider->profession); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?= htmlspecialchars($provider->adder1); ?>, <?= htmlspecialchars($provider->adder2); ?></td>
                    <th>City</th>
                    <td><?= htmlspecialchars($provider->city); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 30px;">
    <h4>Bookings</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking->id; ?></td>
                    <td><?= htmlspecialchars($booking->fname); ?></td>
                    <td><?= htmlspecialchars($booking->adder); ?></td>
                    <td><?= htmlspecialchars($booking->date); ?></td>
                    <td><?= htmlspecialchars($booking->status); ?></td>
                    <td>
                        <?php if ($booking->status !== 'Completed'): ?>
                            <form action="update_status.php" method="post">
                                <input type="hidden" name="booking_id" value="<?= $booking->id; ?>">
                                <input type="submit" name="mark_complete" value="Mark as Completed" class="btn btn-primary btn-sm">
                            </form>
                        <?php else: ?>
                            <span>Completed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once "include/footer.php"; ?>
