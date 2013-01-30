<?php

class m130121_130003_page extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{page}}', array(
                'id'             => 'int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'parent_id'      => 'int(11) unsigned DEFAULT NULL',
                'level'          => 'tinyint(3) unsigned NOT NULL DEFAULT "1"',
                'name'           => 'varchar(50) NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'content'        => 'text NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'rich_editor'    => 'tinyint(1) NOT NULL DEFAULT "1"',
                'status'         => 'enum("draft","published","moderation") NOT NULL DEFAULT "published"',
                'is_protected'   => 'tinyint(1) NOT NULL DEFAULT "0"',
                'sort_order'     => 'int(11) NOT NULL',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
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
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{page}}_{{page}}_parent_id', '{{page}}', 'parent_id', '{{page}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{page}}_{{user}}_create_user_id', '{{page}}', 'create_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey('fk_{{page}}_{{user}}_update_user_id', '{{page}}', 'update_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
        }
        $this->insert('{{page}}', array(
                'name'           => 'Главная страница (Main page)',
                'title'          => 'Заголовок страница (Page title)',
                'description'    => 'Yii Fad Cms',
                'content'        => '<h1>Главная страница</h1><p>Начальная страница. Зайдите в управление страницами, чтобы изменить текст.</p><p>' . Yii::t('yii', 'Создано на {yii}.', array('{yii}' => '<a href="http://yiifad.ru/" rel="external">Yii Fad CMS</a>')) . '</p>',
                'slug'           => 'index',
                'sort_order'     => 1,
                'create_user_id' => 1,
                'create_time'    => new CDbExpression('NOW()')
        ));
    }

    public function safeDown()
    {
        $this->dropTable('{{page}}');
    }
}