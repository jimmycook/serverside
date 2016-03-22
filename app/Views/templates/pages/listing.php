<?php include(__DIR__ . '/../partials/header.php') ?>
<?php include(__DIR__ . '/../partials/navbar.php') ?>

<div class="container">
    <div class="panel">

        <div class="panel-heading">
            <h2><?php echo $listing['name'] ?></h2>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo $listing['img_path'] ?>" alt="" />
                </div>
                <div class="col-md-9">
                    <p><strong>Price: </strong>£<?php echo number_format($listing['price'] / 100, 2) ?></p>
                    <p><strong>Sold By: </strong><?php echo $user['first_name'] . ' ' . $user['last_name'] . ' <strong>(' . $user['username'] ?>)</strong></p>
                    <p><strong>Description: </strong><?php echo $listing['description']?></p>
                    <form class="" action="/listings/<?php echo $listing['slug']?>" method="post">
                        <?php
                        if (check())
                        {
                            echo '<input class="btn btn-primary btn-lg" type="submit" name="submit" value="Buy This Item">';
                        }
                        else
                        {
                            echo '<input class="btn btn-lg" type="submit" name="submit" value="Sign in to buy this item">';

                        }
                         ?>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <pre>
        <?php print_r($user); ?>
    </pre>
</div>




<?php include(__DIR__ . '/../partials/footer.php') ?>
