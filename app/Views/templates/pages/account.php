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
            <div class="row">
                <div class="col-sm-8">
                    <h3>Your Listings</h3>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-primary pull-right btn-lg">Create a listing</button>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <p>
                It costs £1 a day to host a listing for an item on the site. You will be billed automatically. Your credit can go into the negative from this so please remember to top up your account.
            </p>
        <?php if (count($listings)):
            ?>
            <table class="table">
                <thead>
                   <tr>
                     <th>Item Name</th>
                     <th>Price</th>
                     <th>Billed Until</th>
                     <th>Purchased</th>
                     <th>Delete</th>
                   </tr>
                </thead>
            <?php

            foreach ($listings as $listing): ?>

            <tr>
                <td>
                    <?php echo $listing['name'] ?>
                </td>
                <td>
                    £<?php echo number_format($listing['price'] / 100, 2) ?>
                </td>
                <td>
                    <?php echo $listing['paid_until'] ?>

                </td>
                <td>
                    <button type="button" class="btn btn-primary" disabled>View Purchase Info</button>
                </td>
                <td>
                    <button class="btn btn-danger" name="delete" data-listing="<?php echo $listing['slug']?>">Delete</button>
                </td>
            </tr>


            <?php endforeach;
            endif; ?>
            </table>
        </div>
        <pre><?php print_r($listings) ?></pre>

    </div>
</div>


<?php include(__DIR__ . '/../partials/footer.php') ?>
