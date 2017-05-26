<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserImages */

$this->title = 'Update User Images: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-images-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
