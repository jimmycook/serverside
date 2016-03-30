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
            <h4>Current Balance:
                <span id="current-balance">£<?php echo number_format($user['credit'] / 100, 2) ?></span>
            </h4>
            <div class="row">
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
                <section class="col-md-6">
                    <h4>Withdraw funds</h4>
                    <form class="form-inline" action="/account/withdrawfunds" method="post">
                      <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">£</div>
                            <input type="number" class="form-control" name="pounds" placeholder="Pounds">
                            <div class="input-group-addon">.</div>
                            <input type="number" class="form-control" name="pence" placeholder="Pence" max="99">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Withdraw funds</button>
                    </form>
                </section>
            </div>
            <br>
            <p>
                Note: In this app if it was live, this would use a payment gateway
                to properly manage funds. However in this prototype it's simulated.
            </p>
        </div>

    </div>
    <div class="panel">

        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-8">
                    <h3>Your Listings</h3>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-primary pull-right btn-lg" id="create-listing-modal-button">Create a listing</button>
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
                    <form action="/account/createlisting" method="post">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" placeholder="Listing name" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" name="description" placeholder="Listing description" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="file">
                                    Image
                                </label>
                                <!-- <div class="row" id="image-upload"> -->
                                    <!-- <div class="col-sm-6"> -->
                                        <!-- <div id="image-file-container">
                                            <input type="file" id="image-file" name="image-file">
                                            <span class="file-custom"></span>
                                        </div> -->
                                        <div id="image-url-container">
                                            <input type="text" class="form-control" name="image-url" placeholder="Image URL">
                                        </div>
                                    <!-- </div>
                                    <div class="col-sm-6">
                                        <button type="button" name="button" class="btn btn-primary" id="image-switch" data-image="image-file">Use a URL instead</button>
                                    </div> -->
                                <!-- </div> -->
                                <!-- <input type="hidden" name="image-type" id="image-type" value="image-file"> -->
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">£</div>
                                        <input type="number" class="form-control" name="pounds" placeholder="Pounds">
                                        <div class="input-group-addon">.</div>
                                        <input type="number" class="form-control" name="pence" placeholder="Pence" max="99">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Listing</button>
                        </div>
                    </form>
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
                            <button type="button" class="btn btn-danger" id="listing-order-cancel-button">Cancel this order</button>
                            <button type="button" class="btn btn-primary" id="listing-modal-button"></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <?php endif; ?>
            </table>
        </div>
    </div>
</div>


<?php include(__DIR__ . '/../partials/footer.php') ?>
