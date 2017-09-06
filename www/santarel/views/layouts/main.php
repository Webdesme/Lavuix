<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>Таный Санта - <?= Html::encode($this->title) ?></title>
        <link href="/web/css/style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script src="/web/scripts/jquery.js"></script>
        <script src="/web/scripts/parallax.min.js"></script>
        <script src="/web/scripts/main.js"></script>
        
        <link rel="apple-touch-icon" sizes="57x57" href="/web/img/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/web/img/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/web/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/web/img/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/web/img/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/web/img/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/web/img/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/web/img/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/web/img/apple-touch-icon-180x180.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Relef-Center">
        <link rel="manifest" href="/web/img/manifest.json">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#FFFFFF">
        <meta name="application-name" content="Relef-Center">
        <link rel="icon" type="image/png" sizes="228x228" href="/web/img/coast-228x228.png">
        <link rel="yandex-tableau-widget" href="/web/img/yandex-browser-manifest.json">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="/web/img/mstile-144x144.png">
        <meta name="msapplication-config" content="/web/img/browserconfig.xml">
        <link rel="icon" type="image/png" sizes="32x32" href="/web/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/web/img/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/web/img/favicon-16x16.png">
        <link rel="shortcut icon" href="/web/img/favicon.ico">
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" href="/web/img/apple-touch-startup-image-320x460.png">
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" href="/web/img/apple-touch-startup-image-640x920.png">
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="/web/img/apple-touch-startup-image-640x1096.png">
        <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="/web/img/apple-touch-startup-image-750x1294.png">
        <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 3)" href="/web/img/apple-touch-startup-image-1182x2208.png">
        <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 3)" href="/web/img/apple-touch-startup-image-1242x2148.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" href="/web/img/apple-touch-startup-image-748x1024.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" href="/web/img/apple-touch-startup-image-768x1004.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" href="/web/img/apple-touch-startup-image-1496x2048.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="/web/img/apple-touch-startup-image-1536x2008.png">
    </head>
    <body class="back-red">
        <?php $this->beginBody() ?>

        <div class="hitr">
            <?php if (isset($this->blocks['hitr'])): ?>
                <?= $this->blocks['hitr'] ?>
            <?php endif; ?>
        </div>

        <div class="page-wrap">
            <?= $content ?>
        </div>

        <footer class="white site-footer">
            <p>
                <span>Сайт разработан студией </span>
                <a class="white" href="/home/info">«Deer interprise»</a>
            </p>
        </footer>

        <!-- Prallax images -->
        <div id="container" class="container">
            <ul id="scene" class="scene">
                <li class="layer one" data-depth="0.1"><img src="/web/img/1.png"></li>
                <li class="layer four" data-depth="0.1"><img src="/web/img/1.png"></li>
                <li class="layer two" data-depth="0.2"><img src="/web/img/2.png"></li>
                <li class="layer three" data-depth="0.6"><img src="/web/img/3.png"></li>
            </ul>
        </div>
        <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>