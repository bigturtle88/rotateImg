<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_images".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $image
 * @property string $updated_at
 * @property string $created_at
 */
class UserImages extends \yii\db\ActiveRecord
{
    const FILE_PATH = "uploads/images/user_";
    const FILE_PREFIX = "img_";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['image'], 'string', 'max' => 255],
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
     * delete img before deleting data
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            if ($this->image)
                @unlink(self::FILE_PATH . Yii::$app->user->identity->id . DIRECTORY_SEPARATOR . $this->image);
           return true;
     } else return false;
    }


}
