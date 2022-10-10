<?php

namespace app\models;


/**
 * This is the model class for table "{{%blog}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $img_src
 * @property string $body   
 * @property string|null $date
 * 
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%blog}}';
    }

    /**
     * {@inheritdoc}
     */
    public $file;

    public function rules()
    {
        return [
            [[ 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['date'], 'safe'],
            [['title', 'img_src'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpeg, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
        ];
    }
    public function upload($id) {

      if (true) {
        $path = $this->uploadPath() . $id .'.' .$this->file->extension;
        $this->file->saveAs($path,false);
        $this->img_src = $id . '.' . $this-> file -> extension;
        $this->save(false);
        return true;
      }
      else{
          return false;
      }
          
        	
    }

    public function uploadPath() {
    return 'images/';
    }
     //delete image  file
     public function deleteImage(){
        $file = 'images/' . $this-> img_src;
        if (unlink($file))
        {
            return true;
        }
        else {
            return false;
        } 
        
     }
     //get image function
      public function getImage(){
          if ($this -> img_src == '') return null;
            return '@web/' . $this -> uploadPath() . $this -> img_src;
      }
}
