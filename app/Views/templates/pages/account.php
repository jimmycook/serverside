<?php include(__DIR__ . '/../partials/header.php') ?>
<?php include(__DIR__ . '/../partials/navbar.php') ?>

<div class="container">
    <div class="panel">

        <div class="panel-heading">
            <h2>Your Account</h2>
        </div>

        <div class="panel-body">
            <p>Logged in as <strong><? echo user()['username'] ?></strong></p>
        </div>

    </div>
</div>




<?php include(__DIR__ . '/../partials/footer.php') ?>
