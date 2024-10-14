<?php
include_once 'include/header.php';
include_once "./scripts/DB.php";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
   
    $password = trim($_POST['password']);

    // Validate contact
    $existingUser = DB::query("SELECT * FROM users WHERE contact = ?", [$contact])->fetch(PDO::FETCH_OBJ);
    if ($existingUser) {
        header("Location: userregister.php?error=contact already registered");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (name, contact, password) VALUES (?, ?, ?)";
    $isRegistered = DB::query($sql, [$name, $contact, $hashedPassword]);

    if ($isRegistered) {
        header("Location: userlogin.php?msg=Registration successful! Please log in.");
        exit();
    } else {
        header("Location: userregister.php?error=Registration failed. Try again.");
        exit();
    }
}
