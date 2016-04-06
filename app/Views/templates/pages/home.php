<div class="container">
    <?php

    if ($recent)
    {
        $category = $recent;
        require(__DIR__ . '/../partials/category.php');
    }

    $showLink = true;

    foreach ($categories as $category)
    {
        if (count($category))
        {
            require(__DIR__ . '/../partials/category.php');
        }
    }
     ?>
</div>
