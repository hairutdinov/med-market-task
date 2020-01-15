<?php
/**
 * Created by PhpStorm.
 * User: hairutdinovbr
 * Date: 2020-01-15
 * Time: 10:43 AM
 */

namespace app\models;


use yii\base\Model;

class UploadFileForm extends Model
{
    public $file;

    public function rules()
    {
        return [
          ['file', 'image',
            'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'checkExtensionByMimeType' => true,
            'maxSize' => 2097152,
            'tooBig' => 'Файл не должен превышать 2МБ'
          ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir = 'uploads/'; // Директория - должна быть создана
            $name = $this->randomFileName($this->file->extension);
            $file = $dir . $name;
            $this->file->saveAs($file); // Сохраняем файл
            return true;
        } else {
            return false;
        }
    }

    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }

}