<?php
session_start();
require_once './scripts/DB.php';

if (isset($_POST['login'])) {
    $contact = trim($_POST['contact']);
    $password = trim($_POST['password']);

    // Fetch user data
    $query = "SELECT id, password FROM users WHERE contact = ?";
    $user = DB::query($query, [$contact])->fetch(PDO::FETCH_OBJ);

    if ($user && password_verify($password, $user->password)) {
        // Set session and redirect to dashboard
        $_SESSION['user_id'] = $user->id;
        header("Location: user_dashboard.php");
        exit();
    } else {
        // Redirect with error if credentials don't match
        header("Location: userlogin.php?error=Invalid contact or password");
        exit();
    }
}
