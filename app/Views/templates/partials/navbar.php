<nav class="Navbar">
    <div class="Logo">
        <span class="Logo__text">
            <a href="/">Guitar Trader</a>
        </span>
    </div>
    <div class="Menu">
        <ul class="Menu__items">
            <li class="Menu__item">
                <a href="/category">
                    Categories
                </a>
            </li>
            <?php if (check()): ?>
            <li class="Menu__item">
                <a href="/account">
                    Your Account
                </a>
            </li>
            <li class="Menu__item">
                <a href="/logout">
                    Logout
                </a>
            </li>
            <?php else : ?>
            <li class="Menu__item">
                <a href="/login">
                    Login
                </a>
            </li>
            <li class="Menu__item">
                <a href="/register">
                    Register
                </a>
            </li>
            <?php endif;?>
        </ul>
    </div>

</nav>
