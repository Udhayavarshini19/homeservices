<?php
session_start();
include_once 'include/header.php';

if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php"); // Redirect if already logged in
    exit();
}
?>

<div class="container mt-5">
    <h2>Register</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <form action="userregister_process.php" method="post">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="text" name="contact" id="contact" class="form-control"  maxlength="10" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary mt-3">Register</button>
    </form>
</div>

<?php include_once 'include/footer.php'; ?>
