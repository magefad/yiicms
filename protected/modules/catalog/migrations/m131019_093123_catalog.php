<?php

class m131019_093123_catalog extends EDbMigration
{

	public function safeUp()
	{
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(1)';
        $this->createTable('{{catalog_item}}', array(
                'id'             => 'pk',
                'page_id'        => 'integer NOT NULL',
                'name'           => 'varchar(50) NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'status'         => $tinyint.' NOT NULL DEFAULT \'1\'',
                'create_user_id' => 'integer NOT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp
            ),
            $options
        );
        $this->createIndex('ix_{{catalog_item}}_create_user_id', '{{catalog_item}}', 'create_user_id');
        $this->createIndex('ix_{{catalog_item}}_update_user_id', '{{catalog_item}}', 'update_user_id');

        $this->createTable('{{catalog_item_data}}', array(
                'item_id' => 'integer NOT NULL',
                'key'     => 'varchar(32) NOT NULL',
                'value'   => 'varchar(500) NOT NULL',
            ),
            $options
        );
        $this->createIndex('ux_{{catalog_item}}_item_id', '{{catalog_item_data}}', 'item_id', true);
        $this->createIndex('ix_{{catalog_item}}_key', '{{catalog_item_data}}', 'key');

        $tinyint = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(4)';
        $this->createTable('{{catalog_item_template}}', array(
                'id'         => 'pk',
                'key'        => 'varchar(32) NOT NULL',
                'name'       => 'varchar(50) NOT NULL',
                'input_type' => $tinyint . ' NOT NULL DEFAULT \'0\'',
            ),
            $options
        );
        $this->createIndex('ux_{{catalog_item_template}}_key', '{{catalog_item_template}}', 'key', true);

        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{catalog_item}}_{{page}}_page_id', '{{catalog_item}}', 'page_id', '{{page}}', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey('fk_{{catalog_item}}_{{user}}_create_user_id', '{{catalog_item}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{catalog_item}}_{{user}}_update_user_id', '{{catalog_item}}', 'update_user_id', '{{user}}', 'id', 'NO ACTION', 'NO ACTION');

            $this->addForeignKey('fk_{{catalog_item_data}}_{{catalog_item}}_item_id', '{{catalog_item_data}}', 'item_id', '{{catalog_item}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{catalog_item_data}}_{{catalog_item}}_key', '{{catalog_item_data}}', 'key', '{{catalog_item_template}}', 'key', 'CASCADE', 'NO ACTION');
        }
    }

	public function safeDown()
	{
        $this->dropTable('{{catalog_item_data}}');
        $this->dropTable('{{catalog_item_template}}');
        $this->dropTable('{{catalog_item}}');
	}
}
