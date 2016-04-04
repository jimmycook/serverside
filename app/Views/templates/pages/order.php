<div class="container">
    <div class="panel">
        <div class="panel-heading">
            <h2>Confirm Your Order</h2>
        </div>
        <div class="panel-body">
            <p>
                Please enter the address for the item to be shipped to.
            </p>
            <p>
                Completing the order will leave you with the account credit of £<?php echo number_format(($user['credit'] - $listing['price']) / 100, 2)?>
            </p>
            <form method="post">
                <div class="form-group">
                    <label>Delivery Address: </label>
                    <textarea name="address" rows="4" class="form-control" placeholder="Address" required></textarea>
                </div>
                <button class="btn btn-primary btn-lg" type="submit" name="button">Submit</button>
            </form>

        </div>
    </div>
</div>
