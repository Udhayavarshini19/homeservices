<?php require_once "scripts/session.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <style>
        nav a.nav-link {
            color: #fff !important;
        }
    </style>

    <title> ASMU Home Services</title>
</head>

<body>
    <nav class="nav bg-dark">
        <?php if (!isset($_SESSION['user'])): ?>
         <a class="nav-link action " href="index.php">Home</a>
        <a class="nav-link " href="findservice.php">FindServiceProvider</a>
        <a class="nav-link" href="login.php"> ServiceProvider</a>
       
        <a class="nav-link" href="about.php">About</a>
        <a class="nav-link" href="user_dashboard.php">RequesterProfile</a>

        <?php elseif ($_SESSION['user']->name == 'admin'): ?>
        <a class="nav-link" href="managehall.php">Manage Providers</a>
        <a class="nav-link" href="admin.php">Manage Booking</a>
        <a class="nav-link" href="logout.php">Log Out</a>

        <?php else: ?>
        <a class="nav-link" href="logout.php">Log Out</a>
        <a class="nav-link" href="provider.php">Update Profile</a>
        <?php endif; ?>

    </nav>
