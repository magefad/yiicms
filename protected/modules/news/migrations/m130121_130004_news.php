<?php

class m130121_130004_news extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(1)';

        $this->createTable('{{news}}', array(
                'id'             => 'pk',
                'date'           => 'date NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'content_short'  => 'varchar(400) NOT NULL',
                'content'        => 'text NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'image'          => 'varchar(300) NOT NULL',
                'status'         => $tinyint.' NOT NULL DEFAULT \'1\'',
                'is_protected'   => 'boolean NOT NULL DEFAULT \'0\'',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp,
            ),
            $options
        );
        $this->createIndex('ux_{{news}}_slug', '{{news}}', 'slug', true);
        $this->createIndex('ix_{{news}}_status', '{{news}}', 'status', false);
        $this->createIndex('ix_{{news}}_is_protected', '{{news}}', 'is_protected', false);
        $this->createIndex('ix_{{news}}_create_user_id', '{{news}}', 'create_user_id', false);
        $this->createIndex('ix_{{news}}_update_user_id', '{{news}}', 'update_user_id', false);
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{news}}_{{user}}_create_user_id', '{{news}}', 'create_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey('fk_{{news}}_{{user}}_update_user_id', '{{news}}', 'update_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{news}}');
    }
}