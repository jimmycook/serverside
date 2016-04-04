<div class="container">
    <?php
    $showLink = true;
    foreach ($categories as $category):
        require(__DIR__ . '/../partials/category.php');
    endforeach; ?>
</div>
