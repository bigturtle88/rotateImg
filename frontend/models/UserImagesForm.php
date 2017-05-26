<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\UserImages;

/**
 * This is the model class for table "user_images".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $image
 * @property string $updated_at
 * @property string $created_at
 */
class UserImagesForm extends Model
{
    public $file;
    public $file_path;
    public $file_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'],'file','skipOnEmpty' => false, 'extensions' => 'png, jpg'],
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'image' => 'Image',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * method save
     */
    public function save()
    {

        $model = new UserImages();
        $model->user_id = Yii::$app->user->identity->id;
        $model->image = $this->file_name;

        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
    }
}
