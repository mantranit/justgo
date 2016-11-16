<?php
/**
 * Created by PhpStorm.
 * User: Jimmy
 * Date: 4/8/2015
 * Time: 11:38 PM
 */
namespace backend\models;

use yii\base\Model;
use Yii;

/**
 * Class FileForm
 * @package backend\models
 *
 * @property string  $filePath
 * @property string  $fileName
 * @property string  $fileExt
 * @property string  $fileUrl
 * @property string  $fileDir
 */
class FileForm extends Model {
    public $filePath;
    public $fileName;
    public $fileExt;
    public $fileUrl;
    public $fileDir;

    public $fileType;
    public $width;
    public $height;
}