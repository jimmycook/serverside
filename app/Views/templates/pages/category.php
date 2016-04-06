<div class="container">
    <?php
        require(__DIR__ . '/../partials/category.php');
    ?>
    <div class="pull-right">
        <ul class="pagination">
            <li<?php if ($page <= 1) echo ' class="disabled"'?>>
                <a href="<?php echo '/category/' . $category['slug'] . '?page=' . ($page - 1)?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php
            for ($i = 1; $i <= $numPages; $i++)
            {

                echo '<li';
                if ($page == $i)
                {
                    echo ' class="active"';
                }
                echo '><a href="/category/' . $category['slug'] . '?page='. $i . '">' . $i . '</a></i>';
            }
             ?>
            <li<?php if ($page >= $numPages) echo ' class="disabled"'?>>
                <a href="<?php echo '/category/' . $category['slug'] . '?page='. ($page + 1) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>
</div>
