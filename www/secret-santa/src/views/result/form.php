<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CreateForm */
/* @var $form ActiveForm */

$this->title = 'Результаты';
?>

<?php $this->beginBlock('hitr') ?>
    <a class="white" href="/">За подарками!</a>
<?php $this->endBlock() ?>

<div class="main-big">
    <?php $form = ActiveForm::begin([
        'action' =>['result/submit'],
        'id' => 'result-form',
        'options' => ['class' => ''],
    ]); ?>
        <a href="/"><img src="/web/img/13-layers.png"></a>
        <p class="green" style="margin: 10px 0px 5px 0px">
            Ты готов узнать кто твой Санта, хитрец?! Нужны все<br>
            дружочки с особым стишком от Санты, собери всех<br>
            друзей и узнай кто есть кто на самом деле.
        </p>

        <div class="checkwords-group input">
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
        setResultInputs();
    });
</script>
