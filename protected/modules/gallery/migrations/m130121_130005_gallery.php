<?php

class m130121_130005_gallery extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(1)';

        $this->createTable('{{gallery}}', array(
                'id'             => 'pk',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'status'         => 'boolean NOT NULL DEFAULT \'1\'',
                'sort_order'     => 'integer NOT NULL',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp,
            ),
            $options
        );
        $this->createIndex('ix_{{gallery}}_status', '{{gallery}}', 'status', false);
        $this->createIndex('ix_{{gallery}}_create_user_id', '{{gallery}}', 'create_user_id', false);
        $this->createIndex('ix_{{gallery}}_update_user_id', '{{gallery}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{gallery}}_{{user}}_create_user_id', '{{gallery}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{gallery}}_{{user}}_update_user_id', '{{gallery}}', 'update_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }

        $tinyint4 = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(4)';
        $this->createTable('{{gallery_photo}}', array(
                'id'             => 'pk',
                'gallery_id'     => 'integer NOT NULL',
                'name'           => 'varchar(50) NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'file_name'      => 'varchar(500) NOT NULL',
                'alt'            => 'varchar(100) NOT NULL',
                'type'           => $tinyint4.' NOT NULL DEFAULT \'0\'',
                'status'         => $tinyint.' NOT NULL DEFAULT \'1\'',
                'sort_order'     => 'integer NOT NULL',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp,
            ),
            $options
        );
        $this->createIndex('ix_{{gallery_photo}}_gallery_id', '{{gallery_photo}}', 'gallery_id', false);
        $this->createIndex('ix_{{gallery_photo}}_type', '{{gallery_photo}}', 'type', false);
        $this->createIndex('ix_{{gallery_photo}}_status', '{{gallery_photo}}', 'status', false);
        $this->createIndex('ix_{{gallery_photo}}_create_user_id', '{{gallery_photo}}', 'create_user_id', false);
        $this->createIndex('ix_{{gallery_photo}}_update_user_id', '{{gallery_photo}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
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