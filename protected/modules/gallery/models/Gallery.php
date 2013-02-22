<?php

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $slug
 * @property string $status
 * @property integer $sort_order
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 *
 * The followings are the available model relations:
 * @property Photo[] $photos
 *
 * The followings are the available model behaviors:
 * @property StatusBehavior $statusMain
 */
class Gallery extends CActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT     = 0;
    /** @var array versions for resize images */
    public $versions = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Gallery the static model class
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
        return '{{gallery}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
            array('sort_order, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('title, slug', 'length', 'max' => 75),
            array('keywords, description', 'length', 'max' => 200),
            array('slug', 'unique'), #slug is a URL address
            array('status', 'in', 'range' => array_keys($this->statusMain->getList())),
            array('description', 'safe'),
            array('id, title, description, keywords, slug, status, sort_order, create_user_id, update_user_id, create_time, update_time', 'safe', 'on' => 'search'),
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
            'syncTranslit' => array(
                'class' => 'ext.syncTranslit.SyncTranslitBehavior',
            ),
            'statusMain' => array(
                'class' => 'application.components.behaviors.StatusBehavior',
                'list'  => array(
                    self::STATUS_PUBLISHED => Yii::t('gallery', 'Опубликовано'),
                    self::STATUS_DRAFT     => Yii::t('gallery', 'Скрыто'),
                )
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'photos' => array(self::HAS_MANY, 'Photo', 'gallery_id', 'order' => 'sort_order asc'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'title'       => 'Заголовок',
            'description' => 'Описание',
            'keywords'    => 'Ключевые слова',
            'slug'        => 'Ссылка',
            'status'      => 'Статус',
            'sort_order'  => 'Порядок',
        );
    }

    public function scopes()
    {
        return array(
            'public' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_PUBLISHED)
            ),
            'draft'  => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_DRAFT)
            )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort_order', $this->sort_order, true);

        $sort               = new CSort;
        $sort->defaultOrder = 'sort_order ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'     => $sort
        ));
    }

    /**
     * @param string $slug
     * @return CActiveRecord
     */
    public function findBySlug($slug)
    {
        return $this->find('slug = :slug', array(':slug' => trim($slug)));
    }

    /**
     * Delete all photos in album of gallery when remove album
     * @return bool
     */
    public function delete()
    {
        foreach ($this->photos as $photo) {
            $photo->delete();
        }
        return parent::delete();
    }


    public function renamePath($newPathName)
    {
        $_uploadPath = $this->getUploadPath();
        if (is_dir($_uploadPath)) {
            rename(
                $_uploadPath,
                Yii::app()->getModule('gallery')->uploadDir . DIRECTORY_SEPARATOR . $newPathName
            );
        }
    }

    /**
     * Return upload path of gallery album
     * @return string
     */
    private function getUploadPath()
    {
        $_uploadPath = Yii::app()->getModule('gallery')->uploadPath . DIRECTORY_SEPARATOR . $this->slug;
        if (!is_dir($_uploadPath)) {
            mkdir($_uploadPath, 0777);
        }
        return $_uploadPath;
    }

    public function getSlugById($id)
    {
        $data = $this->model()->find(
            array(
                'select'    => 'slug',
                'condition' => 'id = :id',
                'params'    => array(':id' => $id)
            )
        );
        return $data->slug;
    }

    public function getIdBySlug($slug)
    {
        $data = $this->model()->find(
            array(
                'select'    => 'id',
                'condition' => 'slug = :slug',
                'params'    => array(':slug' => $slug)
            )
        );
        return $data->id;
    }
}
