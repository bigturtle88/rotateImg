<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-images-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'file')->fileInput(); ?>

     <div class="form-group">
        <?= Html::submitButton( 'Create', ['class' =>  'btn btn-success' ,'data-pjax'=>true ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
