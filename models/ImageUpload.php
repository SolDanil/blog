<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
class ImageUpload extends Model{

    public $image;
    public function rules()
    {
        return [
            [['image'], 'required'],
           // [['image'], 'file','skipOnEmpty' => false, 'extensions' => ['png']]
//        [['image'], 'image',  'types' => 'png']
        ];
    }
    public function uploadFile($currentImage)
    {

//echo'<pre>';
//        var_dump($this->validate());
//        var_dump($this->image->extension);
//        var_dump($this);die;
//        echo'</pre>';
        if($this->validate())
        {
            $this->deleteCurrentImage($currentImage);
//            var_dump($this->saveImage());die;
            return $this->saveImage();
        }
    }
    private function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';
    }
    private function generateFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }
    public function deleteCurrentImage($currentImage)
    {
        if($this->fileExists($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }
    public function fileExists($currentImage)
    {
        if(!empty($currentImage) && $currentImage != null)
        {
            return file_exists($this->getFolder() . $currentImage);
        }
    }
    public function saveImage()
    {
        $filename = $this->generateFilename();
//        var_dump($this->image);
//        var_dump($this->getFolder());die;
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }
}