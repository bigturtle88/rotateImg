<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.05.2017
 * Time: 13:01
 */
namespace frontend\components;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use frontend\models\UserImages;
use yii\web\UploadedFile;

/**
 * Class ImageManager implements image loading and rotation
 * @package frontend\components
 */
class ImageManager
{
    const SIZE = 150;
    const ROTATE = 90;
    const MODE = 0655;
    private $modelImages;

    /**
     * ImageManager constructor.
     * @param object $modelImages
     */

    public function __construct($modelImages) {
        $this->modelImages = $modelImages;
    }

    /**
     * Method of image upload
     */
    public function upload(){

        $imageName = uniqid(UserImages::FILE_PREFIX);
        $this->modelImages->file = UploadedFile::getInstance($this->modelImages, 'file');
        $this->modelImages->file_path = UserImages::FILE_PATH . Yii::$app->user->identity->id;
        $this->modelImages->file_name = $imageName. '.' . $this->modelImages->file->extension;
        BaseFileHelper::createDirectory($this->modelImages->file_path, self::MODE , true );
        $this->modelImages->file->saveAs( $this->modelImages->file_path . DIRECTORY_SEPARATOR.$this->modelImages->file_name);
        Image::thumbnail($this->modelImages->file_path . DIRECTORY_SEPARATOR.$this->modelImages->file_name, self::SIZE, self::SIZE)
                ->save($this->modelImages->file_path . DIRECTORY_SEPARATOR.$this->modelImages->file_name);

        $this->modelImages->save();
    }

    /**
     * Method of image rotate
     */
    public function rotate(){

        Image::frame(UserImages::FILE_PATH . Yii::$app->user->identity->id . DIRECTORY_SEPARATOR .     $this->modelImages->image, 0, 0)
            ->rotate(self::ROTATE)
            ->save(UserImages::FILE_PATH . Yii::$app->user->identity->id . DIRECTORY_SEPARATOR .     $this->modelImages->image);

        $this->modelImages->updated_at = date('Y-m-d H:i:s');
        $this->modelImages->save();

        Yii::$app->cache->flush();
    }
}