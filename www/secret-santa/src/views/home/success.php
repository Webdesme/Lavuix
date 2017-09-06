<?php

/* @var $this yii\web\View */

$this->title = 'Успех';

$session = \Yii::$app->session;
unset($session['form_token']);
?>

<?php $this->beginBlock('hitr') ?>
    <a class="white" href="/result">Пойти на хитрость</a>
<?php $this->endBlock() ?>

<div class="main-big no_back">
    <img class="ven" src="/web/img/group23.png"><br>
    <a class="white" href="/">Боооооольше подарков!</a>
</div>