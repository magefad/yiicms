<?php

class m130121_130003_page extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(1)';
        $tinyint3          = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(3)';

        $this->createTable('{{page}}', array(
                'id'             => 'pk',
                'parent_id'      => 'integer DEFAULT NULL',
                'level'          => $tinyint3.' NOT NULL DEFAULT \'1\'',
                'name'           => 'varchar(50) NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL DEFAULT \'\'',
                'description'    => 'varchar(200) NOT NULL',
                'content'        => 'text NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'rich_editor'    => 'boolean NOT NULL DEFAULT \'1\'',
                'status'         => $tinyint.' NOT NULL DEFAULT \'1\'',
                'is_protected'   => 'boolean NOT NULL DEFAULT \'0\'',
                'sort_order'     => 'integer',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp,
            ),
            $options
        );
        $this->createIndex('ux_{{page}}_slug', '{{page}}', 'slug', true);
        $this->createIndex('ix_{{page}}_parent_id', '{{page}}', 'parent_id', false);
        $this->createIndex('ix_{{page}}_status', '{{page}}', 'status', false);
        $this->createIndex('ix_{{page}}_is_protected', '{{page}}', 'is_protected', false);
        $this->createIndex('ix_{{page}}_sort_order', '{{page}}', 'sort_order', false);
        $this->createIndex('ix_{{page}}_create_user_id', '{{page}}', 'create_user_id', false);
        $this->createIndex('ix_{{page}}_update_user_id', '{{page}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{page}}_{{page}}_parent_id', '{{page}}', 'parent_id', '{{page}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{page}}_{{user}}_create_user_id', '{{page}}', 'create_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey('fk_{{page}}_{{user}}_update_user_id', '{{page}}', 'update_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
        }
        echo 'Create "' . Yii::t('zii', 'Home') . '" page' . PHP_EOL;
        $this->insert('{{page}}', array(
                'name'           => 'Главная страница (Main page)',
                'title'          => 'Заголовок страница (Page title)',
                'description'    => 'Yii Fad Cms',
                'content'        => '<h1>Главная страница</h1><p>Начальная страница. Зайдите в управление страницами, чтобы изменить текст.</p><p>' . Yii::t('yii', 'Создано на {yii}.', array('{yii}' => '<a href="http://yiifad.ru/" rel="external">Yii Fad CMS</a>')) . '</p>',
                'slug'           => 'index',
                'sort_order'     => 1,
                'create_user_id' => 1,
                'create_time' => (strncasecmp(
                    'sqlite',
                    $this->dbConnection->driverName,
                    6
                ) === 0) ? new CDbExpression("date('now')") : new CDbExpression('NOW()')
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{page}}');
    }
}