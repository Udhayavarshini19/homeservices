<?php
include_once "./scripts/DB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    switch ($action) {
        case 'accept':
            DB::query("UPDATE bookings SET status = 'accepted' WHERE id = ?", [$booking_id]);
            break;
        case 'deny':
            DB::query("UPDATE bookings SET status = 'denied' WHERE id = ?", [$booking_id]);
            break;
        case 'finish':
            DB::query("UPDATE bookings SET status = 'finished' WHERE id = ?", [$booking_id]);
            break;
    }
}

// Redirect back to the provider dashboard
header('Location: provider_dashboard.php');
exit();
