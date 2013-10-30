<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $level
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $annotation
 * @property string $content
 * @property string $slug
 * @property string $image
 * @property integer $rich_editor
 * @property string $status
 * @property string $type
 * @property boolean $is_protected
 * @property integer $sort_order
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Page[] $children
 * @property Page $parent
 * @property User $author
 * @property User $changeAuthor
 * @property CatalogItem[] $catalogItems if has module "catalog"
 *
 * The followings are the available model behaviors:
 * @property AdjacencyListBehavior $treeArray
 * @property StatusBehavior $statusMain
 * @property StatusBehavior $statusType
 * @property StatusBehavior $statusProtected
 *
 * @method Page published()
 * @method Page protected()
 * @method Page public()
 * @method Page root()
 * @method Page catalog()
 */
class Page extends CActiveRecord
{
    public $onlyThumbnail = true;
    public $versions = array(
        'thumb'    => array( //thumb is required
            'resize' => array(300, null),
        ),
    );

    public $author_search;
    public $changeAuthor_search;

    const ROOT_YES = 0;

    const TYPE_CATALOG = 0;
    const TYPE_ARTICLE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Page the static model class
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
        return '{{page}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, title, description, content, status', 'required'),
            array('parent_id, level, rich_editor, sort_order, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('title, slug', 'length', 'max' => 75),
            array('image', 'length', 'max' => 300),
            array('keywords, description', 'length', 'max' => 200),
            array('annotation', 'length', 'max' => 400),
            array(
                'image',
                'file',
                'types'      => 'jpg,jpeg,gif,png',
                'allowEmpty' => true,
                'safe'       => false
            ),
            array('slug', 'unique'), #slug is a link of page
            array('status', 'in', 'range' => array_keys($this->statusMain->getList())),
            array('type', 'in', 'range' => array_keys($this->statusType->getList())),
            array('is_protected', 'boolean'),
            array('name, title, keywords, description, annotation, content, slug', 'filter', 'filter' => 'trim'),
            array(
                'title, slug, description, annotation, keywords, name',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array(
                'slug',
                'match',
                'pattern' => '/^[a-zA-Z0-9_\-]+$/',
                'message' => Yii::t('yii', 'The format of {attribute} is invalid.')
            ),
            array('create_time', 'date', 'format'=>'yyyy-M-d H:m:s'),
            array(
                'id, parent_id, level, name, title, keywords, description, annotation, content, slug, image, status, type, sort_order, create_time, update_time, author_search, changeAuthor_search',
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
            'syncTranslit' => array(
                'class' => 'ext.syncTranslit.SyncTranslitBehavior',
            ),
            'treeArray' => array(
                'class' => 'application.components.behaviors.AdjacencyListBehavior',
                'textAttribute' => 'name'
            ),
            'sortable' => array(
                'class' => 'application.components.behaviors.SortableBehavior',
            ),
            'statusMain' => array(
                'class' => 'application.components.behaviors.StatusBehavior'
            ),
            'statusProtected' => array(
                'class'     => 'application.components.behaviors.StatusBehavior',
                'attribute' => 'is_protected',
                'list'      => array(
                    Yii::t('yii', 'No'),
                    Yii::t('yii', 'Yes')
                )
            ),
            'statusType' => array(
                'class'     => 'StatusBehavior',
                'attribute' => 'type',
                'list' => array(
                    Yii::t('PageModule.page', 'Catalog module'),
                    Yii::t('PageModule.page', 'Articles — shows a list of subpages'),
                )
            )
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'children'     => array(self::HAS_MANY, 'Page', 'parent_id', 'order' => 'sort_order ASC'),
            'parent'       => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'author'       => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'update_user_id'),
        );
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = 1',
            ),
            'protected' => array(
                'condition' => 'is_protected = 1',
            ),
            'public'    => array(
                'condition' => 'is_protected = 0',
            ),
            'root'      => array(
                'condition' => 'parent_id = :parent_id',
                'params'    => array(':parent_id' => self::ROOT_YES)
            ),
            'catalog' => array(
                'condition' => 'type = :type',
                'params'    => array(':type' => self::TYPE_CATALOG)
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                  => 'ID',
            'parent_id'           => Yii::t('PageModule.page', 'Parent'),
            'level'               => Yii::t('PageModule.page', 'Parent Level'),
            'name'                => Yii::t('PageModule.page', 'Name in Menu'),
            'title'               => Yii::t('PageModule.page', 'Title'),
            'keywords'            => Yii::t('PageModule.page', 'META Keywords'),
            'description'         => Yii::t('PageModule.page', 'META Description'),
            'annotation'          => Yii::t('PageModule.page', 'Annotation to a page'),
            'content'             => Yii::t('PageModule.page', 'Text'),
            'slug'                => Yii::t('PageModule.page', 'Link'),
            'image'               => Yii::t('PageModule.page', 'Picture'),
            'rich_editor'         => Yii::t('PageModule.page', 'Use HTML Editor'),
            'status'              => Yii::t('PageModule.page', 'Status'),
            'type'                => Yii::t('PageModule.page', 'Type'),
            'is_protected'        => Yii::t('PageModule.page', 'Only for registered users'),
            'sort_order'          => Yii::t('PageModule.page', 'Sorting'),
            'create_user_id'      => Yii::t('PageModule.page', 'Author'),
            'update_user_id'      => Yii::t('PageModule.page', 'Update user'),
            'create_time'         => Yii::t('PageModule.page', 'Created'),
            'update_time'         => Yii::t('PageModule.page', 'Updated'),
            'author_search'       => Yii::t('PageModule.page', 'Author'),
            'changeAuthor_search' => Yii::t('PageModule.page', 'Update user'),
        );
    }

    public function beforeValidate()
    {
        if (strlen($this->create_time) == 16) {
            $this->create_time .= ':00';
        }
        return parent::beforeValidate();
    }

    /**
     * @todo move to helper
     * @see News::beforeSave()
     * @return bool
     */
    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($imageFile = CUploadedFile::getInstance($this, 'image')) {
                $uploadPath = $this->getUploadPath();
                #echo $uploadPath;exit;
                if (!$this->isNewRecord && is_dir($uploadPath)) {
                    $this->deleteImage($uploadPath); // удаляем старое изображение, если обновляем новость
                }
                mkdir($uploadPath, 0777);
                $this->image = pathinfo($imageFile->getName(), PATHINFO_FILENAME) . '.jpg';
                $this->setImage($imageFile->getTempName(), $uploadPath);
            }
        }
        return true;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleteImage($this->getUploadPath()); // удалили модель? удаляем и файл
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        if (Yii::app()->hasModule('catalog')) {
            $this->getMetaData()->addRelation('catalogItems', array(self::HAS_MANY, 'CatalogItem', 'page_id'));
        }
        parent::afterFind();
    }

    private function setImage($path, $uploadPath)
    {
        Yii::import('ext.image.Image');
        /** @var $image Image */
        $image = Yii::app()->image->load($path);

        /** resize image to Max width x height */
        if (!$this->onlyThumbnail) {
            $image->cresize(800, 600);
            $image->save($uploadPath . '/' . $this->getFileName('') . '.jpg');
        }
        #$image->cresize(300, 200);
        #$image->save($uploadPath . '/' . $this->getFileName('') . '.jpg');
        // set thumb max width from module setting
        #$this->versions['thumb']['resize'][0] = 294;
        /** resize images to user versions and put-sort it to versions-named folders */
        foreach ($this->versions as $version => $actions) {
            $image = Yii::app()->image->load($path);
            foreach ($actions as $method => $args) {
                # if it width >= version->width image no need to resize
                #if ($image->width >= $args['0']) {
                    if (!is_dir($uploadPath . DIRECTORY_SEPARATOR . $version)) {
                        mkdir($uploadPath . DIRECTORY_SEPARATOR . $version);
                    }
                    call_user_func_array(array($image, $method), $args);
                    $image->save(
                        $uploadPath . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $this->getFileName(
                        ) . '.jpg'
                    );
                #}
            }
        }
    }

    private function deleteImage($uploadPath)
    {
        $this->removeFile($uploadPath . DIRECTORY_SEPARATOR . $this->getFileName() . '.jpg');

        foreach ($this->versions as $version => $actions) {
            $this->removeFile(
                $uploadPath . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $this->getFileName() . '.jpg'
            );
            $this->removeDir($uploadPath . DIRECTORY_SEPARATOR . $version);
        }
        $this->removeDir($uploadPath);
    }

    public function renamePath($newPathName)
    {
        if (is_dir($this->getUploadPath())) {
            rename(
                $this->getUploadPath(),
                'page' . DIRECTORY_SEPARATOR . $newPathName
            );
        }
    }

    private function removeFile($fileName)
    {
        if (file_exists($fileName)) {
            @unlink($fileName);
        }
    }

    private function removeDir($dirName)
    {
        if (is_dir($dirName)) {
            rmdir($dirName);
        }
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
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->with = array('author', 'changeAuthor');

        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('level', $this->level);

        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('annotation', $this->annotation, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('rich_editor', $this->rich_editor, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('author.username', $this->author_search, true);
        $criteria->compare('changeAuthor.username', $this->changeAuthor_search, true);

        $sort               = new CSort;
        $sort->defaultOrder = 't.sort_order ASC';
        $sort->attributes   = array(
            'author_search'       => array(
                'asc'  => 'author.username',
                'desc' => 'author.username DESC',
            ),
            'changeAuthor_search' => array(
                'asc'  => 'changeAuthor.username',
                'desc' => 'changeAuthor.username DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => array('pageSize' => Yii::app()->getModule('page')->pageSize),
            'sort'       => $sort
        ));
    }

    /**
     * @return string $module->uploadPath.'/'.$this->slug
     */
    private function getUploadPath()
    {
        return Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'page' . DIRECTORY_SEPARATOR . $this->slug;
    }

    private function getFileName()
    {
        return pathinfo($this->image, PATHINFO_FILENAME);
    }

    public function getThumbnailUrl()
    {
        if ($this->image) {
            return Yii::app()->baseUrl . '/' . Yii::app()->getModule('admin')->uploadDir . '/page/' . $this->slug . '/thumb/' . $this->image;
        }

        return false;
    }

    public function getImageUrl()
    {
        if ($this->image) {
            return Yii::app()->baseUrl . '/' . Yii::app()->getModule('admin')->uploadDir . '/page/' . $this->slug . '/' . $this->image;
        }

        return false;
    }
}
