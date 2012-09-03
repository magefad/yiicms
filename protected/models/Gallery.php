<?php

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $keywords
 * @property string $slug
 * @property integer $status
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property GalleryPhoto[] $galleryPhotos
 */
class Gallery extends CActiveRecord
{
	const STATUS_PUBLIC = 1;
	const STATUS_DRAFT  = 0;

	/** @var array versions for resize images */
	public $versions = array();

	/** @var string directory in web root for galleries */
	public $galleryDir = 'uploads/gallery';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gallery the static model class
	 */
	public static function model($className=__CLASS__)
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 300),
			array('keywords, slug', 'length', 'max' => 150),
			array('sort', 'length', 'max' => 10),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, keywords, slug, status, sort', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'galleryPhotos' => array(self::HAS_MANY, 'GalleryPhoto', 'gallery_id', 'order' => '`sort` asc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'          => 'ID',
			'name'        => 'Название',
			'description' => 'Описание',
			'keywords'    => 'Ключевые слова',
			'slug'        => 'Ссылка',
			'status'      => 'Статус',
			'sort'        => 'Порядок',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort,true);

		$sort = new CSort;
		$sort->defaultOrder = 'sort ASC';

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => $sort
		));
	}
	public function scopes()
	{
		return array(
			'public' => array(
				'condition' => 'status = :status',
				'params' => array(':status' => self::STATUS_PUBLIC)
			),
			'draft' => array(
				'condition' => 'status = :status',
				'params' => array(':status' => self::STATUS_DRAFT)
			),
		);
	}
	/*public function defaultScope()
	{
		return array(
			'condition' => 'status = :status',
			'params' => array(':status' => self::STATUS_PUBLIC)
		);
	}*/

	/**
	 * If slug (link) is empty, translit title to slug (link)
	 * @return bool
	 */
	public function beforeValidate()
	{
		if ( !$this->slug )
		{
			$this->slug = Text::translit($this->name);
		}
		return parent::beforeValidate();
	}

	/**
	 * @param $slug
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
		foreach ($this->galleryPhotos as $photo) {
			$photo->delete();
		}
		return parent::delete();
	}


	public function renamePath($newPathName)
	{
		if ( is_dir($this->getUploadPath()) )
			rename($this->getUploadPath(), $this->galleryDir . '/' . $newPathName);
	}

	/**
	 * Return upload path of gallery album
	 * @return string
	 */
	private function getUploadPath()
	{
		if ( !is_dir($this->galleryDir . '/' . $this->slug) )
		{
			mkdir($this->galleryDir . '/' . $this->slug, 0777);
		}
		return $this->galleryDir . '/' . $this->slug;
	}

	public function getStatusList()
	{
		return array(
			self::STATUS_PUBLIC => Yii::t('gallery', 'опубликовано'),
			self::STATUS_DRAFT => Yii::t('gallery', 'скрыто'),
		);
	}

	public function getStatus()
	{
		$data = $this->getStatusList();

		return isset($data[$this->status]) ? $data[$this->status] : Yii::t('gallery', 'неизвестно');
	}

	public function getSlugById($id)
	{
		$data = $this->model()->find(array(
			'select' => 'slug',
			'condition' => 'id = :id',
			'params' => array(':id' => $id)
		));
		return $data->slug;
	}

	public function getIdBySlug($slug)
	{
		$data = $this->model()->find(array(
			'select' => 'id',
			'condition' => 'slug = :slug',
			'params' => array(':slug' => $slug)
		));
		return $data->id;
	}
}