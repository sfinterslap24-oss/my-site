<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">

    <div class="container nav-container">

        <div class="logo">
            <span>Suliani sazame</span>
            <small>Ресторан грузинской кухни</small>
        </div>

        <nav class="nav-menu">
            <a href="index.php">Главная</a>
            <a href="menu.php">Меню</a>
            <a href="index.php#delivery">Доставка</a>

            <?php if (isset($_SESSION['user_id'])): ?>

                <a href="profile.php">Профиль</a>
                <a href="cart.php">Корзина</a>

                <a href="javascript:logout()">
                    Выйти
                </a>

            <?php else: ?>

                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>

            <?php endif; ?>
        </nav>

    </div>

</header>
