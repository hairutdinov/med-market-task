<?php

namespace app\models;

use Yii;

class UploadFile
{

    private $upload_dir = "./uploads/";

    public static function getRandomFileName($path = "/uploads", $extension = null)
    {
        $max_while_count = 1000;
        $count_while_count = 0;

        if ($extension === null) {
            return false;
        }

        do {
            $name = substr(md5(microtime() . rand(0, 9999)), 0, 16);
//            $name = mt_rand(1, 10);

            if (substr($path, -1,1) !== "/") {
                $path .= "/";
            }

            $file = $path . $name . $extension;
            $count_while_count+=1;
        } while (file_exists($file) && $count_while_count < $max_while_count);

        if ($count_while_count === $max_while_count) {
            return false;
        }

        return $name . $extension;
    }

    public static function getExtension($file_type)
    {
        $extension = null;
        switch ($file_type) {
            case "image/jpeg":
                $extension = ".jpg";
                break;
            case "image/png":
                $extension = ".png";
                break;
        }

        return $extension;
    }

    /**
     * @param array $files Массив $_FILES
     * @param string $referrer Строка со значением, откуда пришел ajax запрос (http://med_market.loc/admin/product/update/2).
     * @return array
     * */
    public function upload($files, $referrer)
    {
        $errors = [];
        $uploaded_images = [];
        $tmp = [];

        $uploaded_images_count = 0;

        /*
         * ID продукта определяется по $referrer и текущему хосту
         * */
        $productId = $this->getProductId($referrer, $this->getHostInfo());

        if ($productId !== null && is_integer($productId)) {

            $images_count = ProductImage::find()->where(["product_id" => $productId])->count();

            if (substr($this->upload_dir, -1,1) !== "/") {
                $this->upload_dir .= "/";
            }


            /*
             * Если в базе меньше 5 изображений
             * То запускаем цикл по файлам
             * Иначе в массив $errors пишем ошибку
             * */
            if ($images_count < 5) {

                foreach ($files["file"]["name"] as $k => $name) {

                    if (($images_count + $uploaded_images_count) < 5) {
                        $filename =  UploadFile::getRandomFileName($this->upload_dir, UploadFile::getExtension($files["file"]["type"][$k]));

                        $path = $this->upload_dir . $filename;

                        if (empty($filename)) {
                            $this->setError("upload_to_server", $errors, $files, $k, $path);
                        } else {
                            if (move_uploaded_file($files['file']['tmp_name'][$k], $path)) {
                                $model = new ProductImage();
                                $writeToDb = $this->writeToDb($model, $filename, $name, $productId, ($images_count + $uploaded_images_count + 1));

                                if ($writeToDb) {
                                    $this->setSuccessUploadedFiles($files, $k,$uploaded_images, $filename, $model->id );
                                    $uploaded_images_count += 1;
                                } else {
                                    $this->setError("write_to_db", $errors, $files, $k, $path);
                                }

                            } else {
                                $this->setError("upload_to_server", $errors, $files, $k, $path);
                            }
                        }
                    } else {
                        $this->setError("to_many_images", $errors, $files, $k);
                    }
                }

            } else {
                $errors["max_count_images"] = 'Максимальное количество изображений: 5';
            }

        } else {
            $errors[] = 'Не удалось определить ID товара';
        }

        return compact('errors', 'uploaded_images', 'uploaded_images_count', 'tmp');
    }


    public function getHostInfo()
    {
        return Yii::$app->request->hostInfo;
    }

    public function getProductId($referrer, $hostInfo)
    {
        $id = null;
        if (strpos($referrer, $hostInfo) !== false) {
            return (int)substr($referrer, mb_strlen($hostInfo . "/admin/product/update/", "utf-8"));
        }
        return $id;
    }

    public function setError($error_name, &$error_ref, $files, $image_index, $generated_filename = null)
    {
        $error_ref[$error_name][] = [
          "name" => $files["file"]["name"][$image_index],
          "type" => $files["file"]["type"][$image_index],
          "tmp_name" => $files["file"]["tmp_name"][$image_index],
          "size" => $files["file"]["size"][$image_index],
          "filename" => $generated_filename
        ];
    }

    public function setSuccessUploadedFiles($files, $image_index, &$uploaded_images_ref, $generated_filename = null, $id = null)
    {
        $uploaded_images_ref[] = [
          "name" => $files["file"]["name"][$image_index],
          "type" => $files["file"]["type"][$image_index],
          "tmp_name" => $files["file"]["tmp_name"][$image_index],
          "size" => $files["file"]["size"][$image_index],
          "filename" => $generated_filename,
          "id" => $id
        ];
    }

    public function writeToDb($model, $generated_filename, $filename, $productId, $image_index)
    {
        $model->path = $generated_filename;
        $model->name = $filename;
        $model->product_id = $productId;
        $model->index = $image_index;
        return $model->save();
    }

}