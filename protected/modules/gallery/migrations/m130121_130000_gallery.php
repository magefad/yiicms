<?php

class m130121_130000_gallery extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{gallery}}', array(
                'id'             => 'int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'status'         => 'enum("draft","published") NOT NULL DEFAULT "published"',
                'sort_order'     => 'int(11) unsigned NOT NULL',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ),
            $options
        );
        $this->createIndex('ix_{{gallery}}_status', '{{gallery}}', 'status', false);
        $this->createIndex('ix_{{gallery}}_create_user_id', '{{gallery}}', 'create_user_id', false);
        $this->createIndex('ix_{{gallery}}_update_user_id', '{{gallery}}', 'update_user_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{gallery}}_{{user}}_create_user_id', '{{gallery}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{gallery}}_{{user}}_update_user_id', '{{gallery}}', 'update_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }

        $this->createTable('{{gallery_photo}}', array(
                'id'             => 'int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'gallery_id'     => 'int(11) unsigned NOT NULL',
                'name'           => 'varchar(50) NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'file_name'      => 'varchar(500) NOT NULL',
                'alt'            => 'varchar(100) NOT NULL',
                'type'           => 'tinyint(4) NOT NULL DEFAULT "0"',
                'status'         => 'enum("draft","published","moderation") NOT NULL DEFAULT "published"',
                'sort_order'     => 'int(11) unsigned NOT NULL',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ),
            $options
        );
        $this->createIndex('ix_{{gallery_photo}}_gallery_id', '{{gallery_photo}}', 'gallery_id', false);
        $this->createIndex('ix_{{gallery_photo}}_type', '{{gallery_photo}}', 'type', false);
        $this->createIndex('ix_{{gallery_photo}}_status', '{{gallery_photo}}', 'status', false);
        $this->createIndex('ix_{{gallery_photo}}_create_user_id', '{{gallery_photo}}', 'create_user_id', false);
        $this->createIndex('ix_{{gallery_photo}}_update_user_id', '{{gallery_photo}}', 'update_user_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{gallery_photo}}_{{gallery}}_gallery_id', '{{gallery_photo}}', 'gallery_id', '{{gallery}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{gallery_photo}}_{{user}}_create_user_id', '{{gallery_photo}}', 'create_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey('fk_{{gallery_photo}}_{{user}}_update_user_id', '{{gallery_photo}}', 'update_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{gallery_photo}}');
        $this->dropTable('{{gallery}}');
    }
}