<?php
session_start();
require_once './scripts/DB.php';

// Check if the provider is logged in
if (!isset($_SESSION['provider_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the booking ID is provided
if (isset($_POST['booking_id']) && isset($_POST['mark_finished'])) {
    $booking_id = $_POST['booking_id'];
    $provider_id = $_SESSION['provider_id'];

    // Update the booking status to 'finished' for this provider
    $update_query = "UPDATE bookings SET status = 'finished' WHERE id = ? AND provider_id = ?";
    $isUpdated = DB::query($update_query, [$booking_id, $provider_id]);

    // Redirect with success or error message
    if ($isUpdated) {
        header("Location: provider_dashboard.php?msg=Booking marked as finished successfully");
    } else {
        header("Location: provider_dashboard.php?msg=Failed to mark booking as finished");
    }
} else {
    header("Location: provider_dashboard.php?msg=Invalid request");
}
exit();
