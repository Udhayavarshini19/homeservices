<?php if (isset($_GET['msg'])): ?>
<div class="container" style="margin-top: 30px">
    <?php if ($_GET['msg'] == "success"): ?>
    <div class="alert alert-success">
        <h4>Success</h4>
        <p>review submitted</p>
    </div>
    <?php elseif ($_GET['msg'] == "failed"): ?>
    <div class="alert alert-danger">
        <h4>Failure</h4>
        <p>Problem while posting reviews! Please try again later!</p>
    </div>
    <?php endif; ?>
</div>
<?php endif;
