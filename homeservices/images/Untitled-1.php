<?php
session_start();
include_once "./scripts/DB.php";

// Check if user is logged in and get their user ID
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current service requests
$current_requests = DB::query("SELECT b.*, p.name AS provider_name, p.photo
                               FROM bookings AS b
                               JOIN providers AS p ON b.provider_id = p.id
                               WHERE b.user_id = ? AND b.status != 'completed'
                               ORDER BY b.created_at DESC", [$user_id])
                     ->fetchAll(PDO::FETCH_OBJ);

// Fetch completed service history
$completed_requests = DB::query("SELECT b.*, p.name AS provider_name, p.photo
                                 FROM bookings AS b
                                 JOIN providers AS p ON b.provider_id = p.id
                                 WHERE b.user_id = ? AND b.status = 'completed'
                                 ORDER BY b.created_at DESC", [$user_id])
                       ->fetchAll(PDO::FETCH_OBJ);

include_once 'include/header.php';
?>

<div class="container mt-4">
    <h2>Welcome to Your Dashboard</h2>

    <!-- Current Service Requests -->
    <section class="mt-5">
        <h3>Current Service Requests</h3>
        <?php if (count($current_requests) > 0): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Provider</th>
                                <th>Service Date</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($current_requests as $request): ?>
                                <tr>
                                    <td>
                                        <img src="images/<?= htmlspecialchars($request->photo); ?>" alt="<?= htmlspecialchars($request->provider_name); ?>" width="50">
                                        <?= htmlspecialchars($request->provider_name); ?>
                                    </td>
                                    <td><?= htmlspecialchars(date('F j, Y', strtotime($request->created_at))); ?></td>
                                    <td><?= ucfirst(htmlspecialchars($request->status)); ?></td>
                                    <td><a href="booking_details.php?id=<?= $request->id; ?>" class="btn btn-info btn-sm">View</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p>No current service requests.</p>
        <?php endif; ?>
    </section>

    <!-- Service History -->
    <section class="mt-5">
        <h3>Service History</h3>
        <?php if (count($completed_requests) > 0): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Provider</th>
                                <th>Service Date</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completed_requests as $request): ?>
                                <tr>
                                    <td>
                                        <img src="images/<?= htmlspecialchars($request->photo); ?>" alt="<?= htmlspecialchars($request->provider_name); ?>" width="50">
                                        <?= htmlspecialchars($request->provider_name); ?>
                                    </td>
                                    <td><?= htmlspecialchars(date('F j, Y', strtotime($request->created_at))); ?></td>
                                    <td><?= ucfirst(htmlspecialchars($request->status)); ?></td>
                                    <td><a href="booking_details.php?id=<?= $request->id; ?>" class="btn btn-info btn-sm">View</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p>No completed services yet.</p>
        <?php endif; ?>
    </section>
</div>

<?php include_once 'include/footer.php'; ?>
