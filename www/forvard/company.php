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
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.simplebanner.js"></script>
    <script type="text/javascript" src="js/jquery.easytabs.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/lightbox.js"></script>
    <link rel="stylesheet" href="css/lightbox.css">

    <script type="text/javascript">
        $(document).ready(function () {
            $('.simpleBanner').simplebanner();
        });
    </script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>


</head>
<body class="back_color">
<div class="width">

    <!-- Тут типа хед
    </header>ер с логотипом -->
    <header>
        <div class="logo">
ФЫВфывфв        </div>
        <div class="up_contact">
            <div class="up_phone">8 4912 45-45-95</div>
            <div class="up_adress">Пожалостина, 44</div>


        </div>
        <ul class="menu">
            <li><a class="to">Компания</a></li>
            <li><a href="arend.php">Арендаторам</a></li>
            <li><a href="gallery.php">Галлерея</a></li>
            <li><a href="">Арендовать офис</a></li>
        </ul>

    <!--Контентная часть-->
    <div class="main">

        <!--Карта расположения здания-->
        <div class="map">
            <div class="maps">
                <div class="maps_about">
                    <p class="maps_about_title">
                        ТОЦ Форвард
                    </p>
                    <p class="maps_about_adres ">
                        390000 Рязань, <br>
                        улица Пожалостина дом 44
                    </p>
                    <p class="maps_about_phone">
                        Телефон: 8 4912 45-56-56
                    </p>
                    <p class="maps_about_mail">
                        Электронка: <a href="mail@forvard.ru">mail@forvard.ru</a>
                    </p>
                </div>
            </div>
            <div id="map" style="width: 100%; height: 365px"></div>
            <script type="text/javascript">
                ymaps.ready(function () {
                    var myMap = new ymaps.Map('map', {
                            center: [54.631546, 39.730895],
                            zoom: 18,
                            controls: ['zoomControl']

                        }, {
                            searchControlProvider: 'yandex#search'
                        }),


                        // Создаём макет содержимого.
                        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
                            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
                        ),

                        myPlacemarkWithContent = new ymaps.Placemark([54.631546, 39.730895], {},
                            {
                                // Опции.
                                // Необходимо указать данный тип макета.
                                iconLayout: 'default#image',
                                // Своё изображение иконки метки.
                                iconImageHref: 'img/ball.png',
                                // Размеры метки.
                                iconImageSize: [27, 40],
                                // Смещение левого верхнего угла иконки относительно
                                // её "ножки" (точки привязки).
                                iconImageOffset: [-24, -24],
                                // Смещение слоя с содержимым относительно слоя с картинкой.
                                iconContentOffset: [15, 15],
                                // Макет содержимого.
                                iconContentLayout: MyIconContentLayout
                            });

                    myMap.geoObjects
                        .add(myPlacemarkWithContent);
                    myMap.behaviors.disable('scrollZoom');
                });

            </script>

        </div>

    </div>
    <!--Отзывы клиентов-->
   <div class="gallery">
       <p class="gallerydesc">Пятиэтажное здание с цокольным этажом, площадь каждого этажа 550 кв. метров.
       индивидуальный подход к каждому клиенту - возможность планировки, с учетом требований каждого арендатора (при условии заключение предварительного договора), гибкая система оплаты, оказание помощи при переезде с другого офиса (предоставление газели в пределах города и грузчиков).
       Для первого этажа организована обособленная входная группа (центральный вход), что позволяет расположение арендатора не зависимо от всех остальных.
       </p>
       <p class="gallerydesc">
           <br>– расположение в самом центре города, в непосредственной близости от муниципальных учреждений, банков и гостиниц;
           <br> – удобное транспортное сообщение - находится в шаговой доступности от остановок общественного транспорта "Дом Художника" и "Площадь Ленина"
           <br> – удобный доступ к железнодорожным вокзалам
       </p>

       <p class="gallerydesc">
       Предусмотрено:
           <br> – оптоволоконные телекоммуникации;
           <br> – круглосуточная охрана
           <br>– система видеонаблюдения
           <br>– контроль доступа (поэтажный)
           <br>– лифт
       </p>
       <p class="gallerydesc"> В цокольном этаже находится кафе, позволяющее проводить переговоры, кофе-брейки и организовать бизнес-ланчи для сотрудников и гостей ТОЦ Форвард</p>

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
       <li style="background: url(img/photo-by-shumova-daria-023.png)">
           <a class="gallerylink" href="img/photo-by-shumova-daria-023.png" data-lightbox="roadtrip">
               <div class="gallerytitle">
                   <span>Заголовок фотографии</span>
                   <p></p>
               </div>
           </a>
       </li>
       <li style="background: url(img/photo-by-shumova-daria-023.png)">
           <a class="gallerylink" href="img/photo-by-shumova-daria-023.png" data-lightbox="roadtrip">
               <div class="gallerytitle">
                   <span>Заголовок фотографии</span>
                   <p></p>
               </div>
           </a>
       </li>
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

