<div class="container">
    <?php flashMessage('warning') ?>
    <div class="panel">

        <div class="panel-heading">
            <h2><?php echo $listing['name'] ?></h2>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <img class="guitar-thumbnail" src="<?php echo $listing['img_path'] ?>" alt="listing image" />
                </div>
                <div class="col-md-9">
                    <p><strong>Price: </strong>£<?php echo number_format($listing['price'] / 100, 2) ?></p>
                    <p><strong>Sold By: </strong><?php echo $user['first_name'].' '.$user['last_name'].' <strong>('.$user['username'] ?>)</strong></p>
                    <p><strong>Description: </strong><?php echo $listing['description']?></p>
                    <p><strong>Category: </strong><?php echo $listing['category']['name']?></p>
                    <form class="" action="/listings/order/<?php echo $listing['slug']?>" method="get">
                        <?php
                        if (user()['id'] == $listing['user_id']) {
                            echo '<input class="btn btn-disabled btn-lg" disabled type="submit" name="submit" value="You cannot buy your own item">';
                        } elseif (!check()) {
                            echo '<input class="btn btn-lg" type="submit" name="submit" value="Sign in to buy this item">';
                        } elseif (count($listing['order']) == 6 && $listing['order']['status'] != 'cancelled') {
                            echo '<button class="btn btn-lg btn-disabled" disabled>This item is not available at this time</button>';
                        } elseif (check()) {
                            echo '<input class="btn btn-primary btn-lg" type="submit" name="submit" value="Buy This Item">';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
