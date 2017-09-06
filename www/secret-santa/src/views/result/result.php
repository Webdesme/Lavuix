<?php

/* @var $this yii\web\View */

$this->title = 'Тайна раскрыта';
?>

<?php $this->beginBlock('hitr') ?>
    <a class="white" href="/">За подарками!</a>
<?php $this->endBlock() ?>

<div class="main-big">
    <a href="/"><img src="/web/img/11-layers.png"></a>
    <?php
    foreach ($model->couples as $key => $value) {
        echo '<div class="name" >';
        echo '<span class="green" style="margin-bottom: 23px">'.$key.'</span><img class="margin" src="/web/img/15-layers.png"><span class="green" style="margin-bottom: 23px">'.$value.'</span>';
        echo '</div>';
    }
    ?>
</div>
<div class="home_back"></div>
<div class="home_back_1"></div>

