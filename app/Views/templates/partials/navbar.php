<nav class="Navbar">
    <div class="Logo">
        <span class="Logo__text">
            <a href="/">Guitar Trader</a>
        </span>
    </div>
    <div class="Menu">
        <ul class="Menu__items">
            <li class="Menu__item">
                <a href="/categories">
                    Categories
                </a>
            </li>


            <? if (App\Services\Auth::check()): ?>
            <li class="Menu__item">
                <a href="/create">
                    Create listing
                </a>
            </li>
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
            <? else : ?>
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
            <? endif;?>
        </ul>
    </div>

</nav>
