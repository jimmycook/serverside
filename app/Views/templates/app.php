<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Guitar Trader</title>

        <link href="/css/app.css" rel="stylesheet">

    </head>
    <body>
        <?php
        include(__DIR__ . '/partials/navbar.php');
        echo $template;
        ?>
        <footer class="Footer">
            <ul class="Footer__items">
                <li class="Footer__item">&#169; Jimmy Cook, <?php echo date('Y')?></li>
            </ul>
        </footer>
        <script type="text/javascript" src="/js/main.js"></script>
    </body>
</html>
