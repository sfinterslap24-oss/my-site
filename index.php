<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Грузинская кухня</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body class="home-page">

<?php include 'php/header.php'; ?>

<main>

<!-- HERO -->

<section class="hero">

    <div class="hero-overlay"></div>

    <div class="hero-content container">

        <div class="hero-stamp" aria-label="Знаменитая грузинская кухня">
            <svg class="stamp-svg" viewBox="0 0 500 500" role="img">
                <defs>
                    <path
                        id="stampOuterText"
                        d="M 250,250 m -180,0 a 180,180 0 1,1 360,0 a 180,180 0 1,1 -360,0"
                    />
                    <path
                        id="stampInnerText"
                        d="M 250,250 m -125,0 a 125,125 0 1,1 250,0 a 125,125 0 1,1 -250,0"
                    />
                </defs>

                <circle class="stamp-base" cx="250" cy="250" r="236" />
                <circle class="stamp-ring" cx="250" cy="250" r="220" />
                <circle class="stamp-middle" cx="250" cy="250" r="150" />

                <g class="stamp-text stamp-text-outer">
                    <text>
                        <textPath
                            href="#stampOuterText"
                            startOffset="0"
                            textLength="1131"
                            lengthAdjust="spacingAndGlyphs"
                        >
                            Знаменитая грузинская кухня |
                        </textPath>
                    </text>
                </g>

                <g class="stamp-text stamp-text-inner">
                    <text>
                        <textPath
                            href="#stampInnerText"
                            startOffset="0"
                            textLength="785"
                            lengthAdjust="spacingAndGlyphs"
                        >
                            Хинкали | Чахохбили | Мцвади Хачапури | Лобиани |
                        </textPath>
                    </text>
                </g>
            </svg>
        </div>

    </div>

    <div class="hero-marquee hero-marquee-bottom">
        <div class="marquee-track marquee-right">
            <span>Хинкал | Чашушули | Чахохбили | Сациви | Чкмерули | Шкмерули | Мцвади | Лобио | Пхали | Аджапсандали | Бадриджани |</span>
            <span>Хинкал | Чашушули | Чахохбили | Сациви | Чкмерули | Шкмерули | Мцвади | Лобио | Пхали | Аджапсандали | Бадриджани |</span>
        </div>
    </div>

</section>

<!-- ADVANTAGES -->

<section class="advantages" id="advantages">

    <div class="hero-marquee advantages-marquee">
        <div class="marquee-track marquee-left">
            <span>Шкмерули | Мцвади | Лобио | Пхали | Аджапсандали | Бадриджани | Хинкал | Чашушули | Чахохбили | Сациви | Чкмерули |</span>
            <span>Шкмерули | Мцвади | Лобио | Пхали | Аджапсандали | Бадриджани | Хинкал | Чашушули | Чахохбили | Сациви | Чкмерули |</span>
        </div>

    </div>

    <div class="container">

        <h2>Почему выбирают нас</h2>

        <div class="cards">

            <div class="card">
                <img src="images/card1.jpg">
                <h3>Оригинальный интерьер</h3>
                <p>
                    Простота, комфорт и акцент на традиции
                </p>
            </div>

            <div class="card">
                <img src="images/card2.jpg">
                <h3>Традиционные блюда</h3>
                <p>
                    Меню по настоящим рецептам
                </p>
            </div>

            <div class="card">
                <img src="images/card3.jpg">
                <h3>Грузинские вина</h3>
                <p>
                    Вина из бочек для яркого вкуса
                </p>
            </div>

            <div class="card">
                <img src="images/card4.jpg">
                <h3>Мастера своего дела</h3>
                <p>
                    Душевно готовим каждое блюдо
                </p>
            </div>

        </div>

    </div>

</section>

<!-- DELIVERY -->

<section class="delivery" id="delivery">

    <div class="container delivery-content">

        <div class="delivery-text">

            <h2>
                Доставка
            </h2>

            <p>
                Дарим скидку в 10% на заказы, оформленные через наш сайт.
                Самовывоз благодарим скидкой 15%, а нашим постоянным гостям
                дарим винные комплименты.
            </p>

            <a href="menu.php">
                Заказать
            </a>

        </div>

    </div>

</section>

<!-- FOOTER -->

</main>

<?php include 'php/footer.php'; ?>

<script src="js/scripts.js"></script>

</body>
</html>
