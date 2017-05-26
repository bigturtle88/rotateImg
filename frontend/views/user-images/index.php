<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$this->registerJs(
    'jQuery(document).ready(function($){
                $(document).ready(function () {
                   var body = $("body");
                     body.on("click", ".rotate-btn", function(){
                     var $this =  $(this);
                     var id = $this.attr("data-id");
                     var url = $this.attr("data-url");
                     var rotate = $this.attr("data-rotate");
                     var img =  $("#img-" + id );
                            rotate = (rotate > 270) ? 90 : +rotate + 90;
                         img.css("rotate",  rotate);
                         $this.attr("data-rotate", rotate);
                    $.ajax({
                       url: url,
                       method: "POST"
                    });
                    });
                });
            });'
);
?>
<div class="user-images-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="user-images-create">
        <?= $this->render('_form', [
            'model' => $modelImages,
        ]) ?>
    </div>
<?php Pjax::begin(['id' => 'images-list' ]); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img('uploads/images/user_'.Yii::$app->user->identity->id.'/'.$data->image.'?'.time(),[
                        'style' => 'width:150px',
                        'id' => 'img-' . $data->id
                    ]);
                },
            ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{rotate}{delete}',
            'buttons' => [
                'rotate' => function ($url,$model,$data) {
                    return Html::a(' <button type="button" class="btn btn-primary">'.Yii::t('app', 'Rotate').'</button>',false,
                        [
                            'title' => Yii::t('app', 'Rotate'),
                            'class'=>'rotate-btn',
                            'data-url'=> $url,
                            'data-id' => $model->id,
                            'data-rotate' => '0'
                        ]);
                },
                'delete' => function ($url,$model) {
                   return Html::a(' <button type="button" class="btn btn-danger">'.Yii::t('app', 'Delete').'</button>', $url,
                       [
                           'title' => Yii::t('app', 'Delete'),
                           'data-method'=>'POST',
                           'data-pjax' => '#images-list',
                           'data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                       ]);
               },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
