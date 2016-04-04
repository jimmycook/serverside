<div class="container">
    <?php
    $category = $recent;
    require(__DIR__ . '/../partials/category.php');
    foreach ($categories as $category) {
        require(__DIR__ . '/../partials/category.php');
    }
     ?>
</div>
