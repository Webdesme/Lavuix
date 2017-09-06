<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html">
    <meta name="author" content="Форвард">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>Форвард</title>

    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="apple-touch-icon" href="img/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/152.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&amp;subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/lightbox.css">

    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/lightbox.js"></script>


</head>
<body class="back_color">
<div class="width">
    <!-- Тут типа хедер с логотипом -->
    <header>
        <div class="logo">
            <a href="http://lavuix.ru/forvard"><img src="img/logo.png"></a>
        </div>
        <div class="up_contact">
            <div class="up_phone">8 4912 45-45-95</div>
            <div class="up_adress">Пожалостина, 44</div>
        </div>
        <ul class="menu">
            <li><a href="company.php">Компания</a></li>
            <li><a href="arend.php">Арендаторам</a></li>
            <li class="to">Галлерея</li>
            <li><a href="index.php">Арендовать офис</a></li>
        </ul>
    </header>
    <!--Контентная часть-->
    <div class="main">
        <ul class="gallery">
            <script>
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true
                })
            </script>


            <li style="background: url(img/photo-by-shumova-daria-023.png)">
                <a class="gallerylink" href="img/photo-by-shumova-daria-023.png" data-lightbox="roadtrip">
                    <div class="gallerytitle">
                        <span>Заголовок фотографии</span>
                        <p></p>
                    </div>
                </a>
            </li>

        </ul>
    </div>
    <div class="null"></div>
    <!--Подвал сайта-->
    <footer>
        <div class="left">
            <span>Торгово-офисный центр «Форвард», 2016</span>
            <ul>
                <li><a href="index.php">Контакты</a> |</li>
                <li><a href="index.php">Арендаторам</a> |</li>
                <li><a href="index.php">Арендовать офис</a> |</li>
                <li><a href="index.php">О компании</a> |</li>
                <li><a href="index.php">Галлерея</a></li>
            </ul>
        </div>
        <div class="right">
            <div class="social">
                <ul>
                    <li><a><img src="img/facebook.svg"></a></li>
                    <li><a><img src="img/facebook.svg"></a></li>
                    <li><a><img src="img/facebook.svg"></a></li>
                    <li><a><img src="img/facebook.svg"></a></li>
                    <li><a><img src="img/facebook.svg"></a></li>
                    <li><a><img src="img/facebook.svg"></a></li>
                </ul>
            </div>

        </div>
        <div class="lavuix">РАЗРАБОТАНО В <a href="http://www.lavuix.ru">LAVUIX</a></div>
    </footer>
</div>
<div id="container" class="container">
    <ul id="scene" class="scene">
        <li class="layer one_s" data-depth="0.4"><img src="img/pathone.png"></li>
        <li class="layer four_s" data-depth="0.1"><img src="img/pathfour.png"></li>
        <li class="layer two_s" data-depth="0.2"><img src="img/paththree.png"></li>
        <li class="layer three_s" data-depth="0.6"><img src="img/pathone.png"></li>
    </ul>
</div>
</body>
</html>

