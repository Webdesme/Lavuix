<?php

/* @var $this yii\web\View */

$this->title = 'Провал';

$session = \Yii::$app->session;
unset($session['form_token']);
?>

<?php $this->beginBlock('hitr') ?>
    <a class="white" href="/result">Пойти на хитрость</a>
<?php $this->endBlock() ?>

<div class="main-big no_back">
    <img class="ugol" src="/web/img/14-layers.png"><br>
    <a class="white" href="/">Я настырный!</a>
</div>
