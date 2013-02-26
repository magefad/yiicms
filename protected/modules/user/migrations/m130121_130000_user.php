<?php

class m130121_130000_user extends EDbMigration
{
    public function safeUp()
    {
        $options           = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $onUpdateTimeStamp = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' ON UPDATE CURRENT_TIMESTAMP' : '';
        $tinyint           = Yii::app()->getDb()->getSchema() instanceof CPgsqlSchema ? 'smallint' : 'tinyint(1)';

        $this->createTable('{{user}}', array(
                'id'                => 'pk',
                'firstname'         => 'varchar(150) DEFAULT NULL',
                'lastname'          => 'varchar(150) DEFAULT NULL',
                'username'          => 'varchar(150) NOT NULL',
                'sex'               => $tinyint.' NOT NULL DEFAULT \'0\'',
                'birth_date'        => 'date DEFAULT NULL',
                'country'           => 'varchar(50) NOT NULL DEFAULT \'\'',
                'city'              => 'varchar(50) NOT NULL DEFAULT \'\'',
                'phone'             => 'varchar(32) NOT NULL DEFAULT \'\'',
                'email'             => 'varchar(150) DEFAULT NULL',
                'password'          => 'varchar(32) NOT NULL',
                'salt'              => 'varchar(32) NOT NULL',
                'status'            => $tinyint.' NOT NULL DEFAULT \'0\'',
                'access_level'      => 'boolean NOT NULL DEFAULT \'0\'',
                'last_visit'        => 'datetime DEFAULT NULL',
                'registration_date' => 'datetime NOT NULL',
                'registration_ip'   => 'varchar(20) NOT NULL',
                'activation_ip'     => 'varchar(20) NOT NULL',
                'photo'             => 'varchar(100) DEFAULT NULL',
                'avatar'            => 'varchar(100) DEFAULT NULL',
                'use_gravatar'      => 'boolean NOT NULL DEFAULT \'0\'',
                'activate_key'      => 'varchar(32) NOT NULL',
                'email_confirm'     => 'boolean NOT NULL DEFAULT \'0\'',
                'create_time'       => 'timestamp NULL DEFAULT NULL',
                'update_time'       => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP' . $onUpdateTimeStamp,
            ),
            $options
        );
        $this->createIndex('ux_{{user}}_username', '{{user}}', 'username', true);
        $this->createIndex('ux_{{user}}_email', '{{user}}', 'email', true);
        $this->createIndex('ix_{{user}}_status', '{{user}}', 'status', false);
        $this->createIndex('ix_{{user}}_email_confirm', '{{user}}', 'email_confirm', false);

        $this->createTable('{{auth_item}}', array(
                'name'        => 'varchar(64) NOT NULL PRIMARY KEY',
                'type'        => 'integer',
                'description' => 'text',
                'bizrule'     => 'text',
                'data'        => 'text',
            ),
            $options
        );

        $this->createTable('{{auth_item_child}}', array(
                'parent' => 'varchar(64) NOT NULL',
                'child'  => 'varchar(64) NOT NULL',
                'PRIMARY KEY (parent, child)'
            ),
            $options
        );
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{auth_item_child}}_{{auth_item}}_parent', '{{auth_item_child}}', 'parent', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_{{auth_item_child}}_{{auth_item}}_child', '{{auth_item_child}}', 'child', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE');
        }

        $this->createTable('{{auth_assignment}}', array(
                'itemname' => 'varchar(64) NOT NULL',
                'userid'   => 'varchar(64) NOT NULL',
                'bizrule'  => 'text',
                'data'     => 'text',
                'PRIMARY KEY (itemname, userid)'
            ),
            $options
        );
        if ((Yii::app()->getDb()->getSchema() instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{auth_assignment}}_{{auth_item}}_name', '{{auth_assignment}}', 'itemname', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{auth_assignment}}');
        $this->dropTable('{{auth_item_child}}');
        $this->dropTable('{{auth_item}}');
        $this->dropTable('{{user}}');
    }
}