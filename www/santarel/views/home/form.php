<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CreateForm */
/* @var $form ActiveForm */
$this->title = 'Начало игры';
?>

<?php $this->beginBlock('hitr') ?>
    <a class="white" href="/result">Пойти на хитрость</a>
<?php $this->endBlock() ?>

<div class="main-big">
    <?php $form = ActiveForm::begin([
        'action' =>['home/submit'],
        'id' => 'home-form',
        'options' => ['class' => ''],
    ]); ?>
        <a href="/"><img src="/web/img/13-layers.png"></a>
        <p class="green" style="margin: 10px 0px 5px 0px">
            Дружок, введи адреса ребят, которые хотят получить подарки:
        </p>

        <div class="emails-group">
        </div>

        <div class="input message">
            <p class="green" style="margin: 25px 0px 10px 0px; padding: 0px;">
                И послание для них:
            </p>
            <textarea name="message">Твой Санта уже готовит для тебя подарок дружок. Но ты тоже не робей и купи подарок не дороже пятисот рублей!</textarea>
            <div class="del-no"></div>
        </div>
        <div class="input">
            <?= Html::submitButton('Хо-хо-хо', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="home_back"></div>
<div class="home_back_1"></div>

<script>
    $(document).ready(function() {
        setHomeInputs();
    });
</script>