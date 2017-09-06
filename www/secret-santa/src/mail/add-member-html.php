<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
    <h3>Привет!</h3>
    <p><?= $MESSAGE ?></p>
    <hr>
    <p>Ты должен подарить подарок человеку с email'ом: <b><?= $GETTER ?></b></p>
    <p>Твой секретный стишок для просмотра результатов: <b><?= $CHECKWORD ?></b></p>
    <p>Сохрани это письмо - пригодится :)</p>
    <br>
    <p><?= Html::a('Сходить за подарками', Url::home('http')) ?></p>