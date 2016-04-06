<div class="panel">
    <div class="panel-heading">
        <h2>
            <?php
            echo $category['name'];
            ?>
        </h2>
    </div>

    <div class="panel-body">
        <?php
        if ($category['listings']) {
            echo '<div class="row">';
            foreach ($category['listings'] as $listing): ?>
            <div class="col-sm-3">
                <a href="/listings/<?php echo $listing['slug'] ?>"
                    data-toggle="tooltip"
                    title="<?php echo $listing['name']?>">
                    <img class="guitar-thumbnail"
                    src="<?php echo $listing['img_path'] ?>"
                    alt="<?php echo $listing['name'] ?>" />
                </a>
                <a href="/listings/<?php echo $listing['slug'] ?>">
                    <?php echo $listing['name'] ?>
                </a>
            </div>
            <?php
            endforeach;
            echo '</div>';
        }
        else {
            echo '<p>There are no listings in this category at this time</p>';
        }
        ?>

        <div class="clearfix">
            <?php
            if (isset($showLink)) {
                echo '<small class="pull-right"><a href="/category/' . $category['slug'] .'"> View all</a></small>';
            }
            ?>
        </div>
    </div>
</div>
