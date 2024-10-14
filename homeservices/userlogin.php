<?php
session_start();
include_once 'include/header.php';

if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php"); // Redirect to user dashboard if already logged in
    exit();
}
?>

<div class="container mt-5">
    <h2>Login</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <form action="userlogin_process.php" method="post">
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="number" name="contact" id="contact" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <h5>Don't have an account ? <a href="userregister.php">REGISTER</h5>
        <button type="submit" name="login" class="btn btn-primary mt-3">Login</button>
    </form>
</div>

<?php include_once 'include/footer.php'; ?>
