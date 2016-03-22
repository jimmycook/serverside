<?php include(__DIR__ . '/../partials/header.php') ?>
<?php include(__DIR__ . '/../partials/navbar.php') ?>

<div class="container">
    <?php flashMessage('warning') ?>

    <div class="panel">
        <div class="panel-heading">
            <h2>Your Account</h2>
        </div>
    </div>

    <div class="panel">

        <div class="panel-heading">
            <h3>Account Balance</h3>
        </div>

        <div class="panel-body">
            <section class="col-md-6">
                <h4>Current Balance: £<?php echo number_format($user['credit'] / 100, 2) ?></h4>
                <p>
                    Note: In this app if it was live, this would use a payment gateway to properly add money to your account; however for this example funds are directly added to your account.
                </p>
            </section>
            <section class="col-md-6">
                <h4>Add funds</h4>
                <form class="form-inline" action="/account/addfunds" method="post">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">£</div>
                      <input type="number" class="form-control" name="pounds" placeholder="Pounds">
                      <div class="input-group-addon">.</div>
                      <input type="number" class="form-control" name="pence" placeholder="Pence" max="99">

                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Add funds</button>
                </form>

            </section>
        </div>

    </div>
    <div class="panel">

        <div class="panel-heading">
            <h3>Your Listings</h3>
        </div>

        <div class="panel-body">
            You currently have X listings, and are being billed at £xx.xx a day
        </div>

    </div>
</div>


<?php include(__DIR__ . '/../partials/footer.php') ?>
