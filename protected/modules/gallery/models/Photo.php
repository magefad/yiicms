<?php

/**
 * This is the model class for table "{{gallery_photo}}".
 *
 * The followings are the available columns in table '{{gallery_photo}}':
 * @property integer $id
 * @property integer $gallery_id
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $file_name
 * @property string $alt
 * @property integer $type
 * @property string $status
 * @property integer $sort_order
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property User $changeUser
 * @property Gallery $gallery
 * @property User $user
 *
 * The followings are the available model behaviors:
 * @property StatusBehavior $statusMain
 * @property GalleriaBehavior $galleria
 */
class Photo extends CActiveRecord
{
    public $author_search;
    public $changeAuthor_search;
    public $gallery_search;

    /** @var string Extensions for gallery images */
    public $galleryExt = 'jpg';

    public $versions = array(
        'thumb'    => array(
            'resize' => array(130, null),
        ),
        'small'    => array(
            'resize' => array(320, null),
        ),
        'standard' => array(
            'resize' => array(640, null),
        ),
        'medium'   => array(
            'resize' => array(1024, null),
        ),
        'large'    => array(
            'resize' => array(1280, null),
        )
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Photo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gallery_photo}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('gallery_id', 'required'),
            array('gallery_id, type, sort_order, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('title', 'length', 'max' => 75),
            array('keywords, description', 'length', 'max' => 200),
            array('file_name', 'length', 'max' => 500),
            array('alt', 'length', 'max' => 100),
            array('status', 'in', 'range' => array_keys($this->statusMain->getList())),
            array(
                'image',
                'file',
                'types'      => Yii::app()->getModule('gallery')->uploadAllowExt,
                'allowEmpty' => true,
                'safe'       => false
            ),
            array('description', 'safe'),
            array(
                'id, gallery_id, name, description, sort_order, file_name, alt, type, status, author_search, create_time, create_user_id, update_user_id, changeAuthor_search, gallery_search',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * Returns a list of behaviors that this model should behave as.
     * @return array the behavior configurations (behavior name=>behavior configuration)
     */
    public function behaviors()
    {
        return array(
            'SaveBehavior' => array(
                'class' => 'application.components.behaviors.SaveBehavior',
            ),
            'statusMain' => array(
                'class' => 'application.components.behaviors.StatusBehavior'
            ),
            'galleria' => array(
                'class'       => 'application.extensions.galleria.GalleriaBehavior',
                'image'       => 'file_name', //required, will be image name of src
                'imagePrefix' => 'id', //optional, not required
                'description' => 'description', //optional, not required
                'title'       => 'name', //optional, not required
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'author'       => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'gallery'      => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                  => 'ID',
            'gallery_id'          => 'Галерея',
            'name'                => 'Название',
            'title'               => 'Заголовок (title)',
            'keywords'            => 'Ключевые слова',
            'description'         => 'Поисание',
            #'rank' => 'Rank',
            'file_name'           => 'Файл',
            'create_time'         => 'Создано',
            'create_user_id'      => 'Автор',
            'update_user_id'      => 'Изменил',
            'alt'                 => 'Alt',
            'type'                => 'Тип',
            'status'              => 'Статус',
            'sort_order'          => 'Порядок',
            'author_search'       => Yii::t('gallery', 'Автор'),
            'changeAuthor_search' => Yii::t('gallery', 'Изменил'),
            'gallery_search'      => Yii::t('gallery', 'Альбом'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {

        $criteria       = new CDbCriteria;
        $criteria->with = array('author', 'changeAuthor', 'gallery');

        $criteria->compare('id', $this->id, true);
        $criteria->compare('gallery_id', $this->gallery_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.sort_order', $this->sort_order);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);

        $criteria->compare('author.username', $this->author_search, true);
        $criteria->compare('changeAuthor.username', $this->changeAuthor_search, true);
        $criteria->compare('gallery.title', $this->gallery_search, true);

        $sort               = new CSort;
        $sort->defaultOrder = 't.sort_order ASC';
        $sort->attributes = array(
            'author_search'       => array(
                'asc'  => 'author.username',
                'desc' => 'author.username DESC',
            ),
            'changeAuthor_search' => array(
                'asc'  => 'changeAuthor.username',
                'desc' => 'changeAuthor.username DESC',
            ),
            'gallery_search'      => array(
                'asc'  => 'gallery.title',
                'desc' => 'gallery.name DESC',
            ),
            '*',
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'     => $sort
        ));
    }

    public function save($runValidation = true, $attributes = null)
    {
        parent::save($runValidation, $attributes);
        if ($this->sort_order == null) {
            $this->sort_order = $this->id;
            $this->setIsNewRecord(false);
            $this->save(false);
        }
        return true;
    }

    public function setImage($path)
    {
        /** @var $image Image */
        $image = Yii::app()->image->load($path);

        /** resize image to Max width x height */
        $image->cresize(Yii::app()->getModule('gallery')->maxWidth, Yii::app()->getModule('gallery')->maxHeight);
        //save image
        $image->save($this->getUploadPath() . DIRECTORY_SEPARATOR . $this->getFileName() . '.' . $this->galleryExt);

        // set thumb max width from module setting
        $this->versions['thumb']['resize'][0] = Yii::app()->getModule('gallery')->thumbMaxWidth;
        /** resize images to user versions and put-sort it to versions-named folders */
        foreach ($this->versions as $version => $actions) {
            $_uploadPath = $this->getUploadPath() . DIRECTORY_SEPARATOR . $version;
            if (!is_dir($_uploadPath)) {
                mkdir($_uploadPath);
            }

            $image = Yii::app()->image->load($path);
            foreach ($actions as $method => $args) {
                # if it width >= version->width image no need to resize
                if ($image->width >= $args['0']) {
                    call_user_func_array(array($image, $method), is_array($args) ? $args : array($args));
                    $image->save($_uploadPath . DIRECTORY_SEPARATOR . $this->getFileName() . '.' . $this->galleryExt);
                }
            }
        }
    }

    public function delete()
    {
        $_uploadPath = $this->getUploadPath();
        $_fileName   = $this->getFileName();
        $this->removeFile($_uploadPath . DIRECTORY_SEPARATOR . $_fileName . '.' . $this->galleryExt);

        //create image preview for gallery manager
        foreach ($this->versions as $version => $actions) {
            $this->removeFile(
                $_uploadPath . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $_fileName . '.' . $this->galleryExt
            );
        }

        return parent::delete();
    }

    private function removeFile($fileName)
    {
        if (file_exists($fileName)) {
            @unlink($fileName);
        }
    }

    public function removeImages()
    {
        foreach ($this->versions as $version => $actions) {
            $this->removeFile(
                $this->getUploadPath() . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $this->getFileName(
                ) . '.' . $this->galleryExt
            );
        }
    }

    /**
     * Regenerate image versions
     */
    public function updateImages()
    {
        foreach ($this->versions as $version => $actions) {
            $_uploadPath = $this->getUploadPath();
            $_fileName   = $this->getFileName();
            $this->removeFile(
                $_uploadPath . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $_fileName . '.' . $this->galleryExt
            );
            /** @var $image Image */
            $image = Yii::app()->image->load(
                $_uploadPath . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $_fileName . '.' . $this->galleryExt
            );
            foreach ($actions as $method => $args) {
                call_user_func_array(array($image, $method), is_array($args) ? $args : array($args));
            }
            $image->save(
                $_uploadPath . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $_fileName . '.' . $this->galleryExt
            );
        }
    }

    public function getPreview($version = 'thumb')
    {
        return Yii::app()->getRequest()->baseUrl . '/' . Yii::app()->getModule('admin')->uploadDir . '/' . Yii::app(
        )->getModule('gallery')->uploadDir . '/' . $this->gallery->slug . '/' . $version . '/' . $this->getFileName(
        ) . '.' . $this->galleryExt;
    }

    /**
     * Return upload path of gallery album
     * @return string
     */
    private function getUploadPath()
    {
        $_uploadPath = Yii::app()->getModule('gallery')->uploadPath . DIRECTORY_SEPARATOR . $this->gallery->slug;
        if (!is_dir($_uploadPath)) {
            mkdir($_uploadPath, 0777);
        }

        return $_uploadPath;
    }

    private function getFileName()
    {
        return $this->id . '-' . pathinfo($this->file_name, PATHINFO_FILENAME);
    }

    public function getUrl()
    {
        return Yii::app()->getRequest()->baseUrl . '/' . Yii::app()->getModule('admin')->uploadDir . '/' . Yii::app(
        )->getModule('gallery')->uploadDir . '/' . $this->getFileName() . '.' . $this->galleryExt;
    }
}
