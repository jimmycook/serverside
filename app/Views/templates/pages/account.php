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
        <div class="modal fade" id="create-listing-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4>Create a listing</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="listing-modal-button"></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="panel-body">
            <p>
                It costs £1 a day to host a listing for an item on the site. You will be billed automatically. Your credit can go into the negative from this so please remember to top up your account.
            </p>
        <?php
        if (count($listings)):
            ?>
            <table class="table">
                <thead>
                   <tr>
                     <th>Item Name</th>
                     <th>Price</th>
                     <th>Billed Until</th>
                     <th>Action</th>
                   </tr>
                </thead>
            <tbody>
                <?php foreach ($listings as $listing): ?>

                <tr>
                    <td>
                        <a href="/listings/<?php echo $listing['slug'] ?>" target="_blank"><?php echo $listing['name'] ?></a>

                    </td>
                    <td>
                        £<?php echo number_format($listing['price'] / 100, 2) ?>
                    </td>
                    <td>
                        <?php echo $listing['paid_until'] ?>

                    </td>
                    <?php if ($listing['order']['status'] == 'completed'): ?>
                        <td>
                            <button class="btn btn-success listing-utility" data-status="completed" name="info" data-listing="<?php echo $listing['slug']?>">Order Information</button>
                        </td>
                    <?php elseif ($listing['order']['status'] == 'processing'): ?>
                        <td>
                            <button class="btn btn-primary listing-utility" data-status="processing" name="info" data-listing="<?php echo $listing['slug']?>">Order Information</button>
                        </td>
                    <?php else: ?>
                        <td>
                            <button class="btn btn-danger listing-utility" data-status="none" name="delete" data-listing="<?php echo $listing['slug']?>">Delete</button>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <div class="modal fade" id="listing-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 id="listing-modal-header"></h4>
                        </div>
                        <div class="modal-body" id="listing-modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="listing-modal-button"></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php endif; ?>
            </table>
        </div>
        <pre><?php print_r($listings) ?></pre>

    </div>
</div>


<?php include(__DIR__ . '/../partials/footer.php') ?>
