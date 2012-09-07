<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $status
 */
class Menu extends CActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLED = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return '{{menu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, code', 'required'),
			array('status', 'numerical', 'integerOnly'=> true),
			array('name, code, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
			array('name, description', 'length', 'max'=> 300),
			array('code', 'length', 'max'=> 100),
			array(
				'code',
				'match',
				'pattern' => '/^[a-zA-Z0-9_\-]+$/',
				'message' => Yii::t('menu', 'Строка содержит запрещенные символы {attribute}')
			),
			array('code', 'unique'),
			array('status', 'in', 'range' => array_keys($this->getStatusList())),
			array('id, name, code, description, status', 'safe', 'on'=> 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'menuItems' => array(self::HAS_MANY, 'Item', 'menu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'          => Yii::t('menu', 'ID'),
			'name'        => Yii::t('menu', 'Название'),
			'code'        => Yii::t('menu', 'Уникальный код'),
			'description' => Yii::t('menu', 'Описание'),
			'status'      => Yii::t('menu', 'Статус'),
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
		$criteria->compare('name', $this->name, true);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('status', $this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=> $criteria,
		));
	}

	/**
	 * @return array statuses
	 */
	public function getStatusList()
	{
		return array(
			self::STATUS_DISABLED => Yii::t('menu', 'не активно'),
			self::STATUS_ACTIVE	  => Yii::t('menu', 'активно'),
		);
	}

	/**
	 * @return string status text
	 */
	public function getStatus()
	{
		$data = $this->getStatusList();

		return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', 'неизвестно');
	}

	// @todo добавить кэширование
	/**
	 * @param $code
	 * @param int $parent_id
	 * @return array
	 */
	public function getItems($code, $parent_id = 0)
	{
		$command = Yii::app()->getDb()->createCommand();
		$results = $command->select('item.id, item.title, item.href, item.access')
			->from('{{menu_item}} item')
			->join('{{menu}} menu', 'item.menu_id=menu.id')
			->where('menu.code=:code AND item.parent_id=:pid AND item.status=1', array(':code' => $code, ':pid' => (int)$parent_id))
			->order('item.sort ASC')
			->queryAll();

		$items = array();
		if ( empty($results) )
			return $items;

		foreach ( $results as $result )
		{
			$childItems = Menu::getItems($code, $result['id']);

			$items[] = array(
				'label'         => $result['title'],
				'url'           => array($result['href']),
				'itemOptions'   => array('class'=>'listItem'),
				'linkOptions'   => array('class'=>'listItemLink', 'title' => $result['title']),
				'submenuOptions'=> array(),
				'items'         => $childItems,
				'visible' 		=> (isset($result['access']) && $result['access']) ? Yii::app()->user->checkAccess($result['access']) : 1,
			);
		}
		return $items;
	}
}