<?php

class m130121_130000_user extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{user}}', array(
                'id'                => 'int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'firstname'         => 'varchar(150) DEFAULT NULL',
                'lastname'          => 'varchar(150) DEFAULT NULL',
                'username'          => 'varchar(150) NOT NULL',
                'sex'               => 'enum("m","f","n") NOT NULL DEFAULT "n"',
                'birth_date'        => 'date NOT NULL',
                'country'           => 'varchar(50) NOT NULL',
                'city'              => 'varchar(50) NOT NULL',
                'phone'             => 'varchar(32) NOT NULL',
                'email'             => 'varchar(150) DEFAULT NULL',
                'password'          => 'varchar(32) NOT NULL',
                'salt'              => 'varchar(32) NOT NULL',
                'status'            => 'enum("blocked","active","not_active") NOT NULL DEFAULT "not_active"',
                'access_level'      => 'tinyint(1) NOT NULL DEFAULT "0"',
                'last_visit'        => 'datetime DEFAULT NULL',
                'registration_date' => 'datetime NOT NULL',
                'registration_ip'   => 'varchar(20) NOT NULL',
                'activation_ip'     => 'varchar(20) NOT NULL',
                'photo'             => 'varchar(100) NOT NULL',
                'avatar'            => 'varchar(100) DEFAULT NULL',
                'use_gravatar'      => 'tinyint(1) NOT NULL DEFAULT "0"',
                'activate_key'      => 'varchar(32) NOT NULL',
                'email_confirm'     => 'tinyint(1) NOT NULL DEFAULT "0"',
                'create_time'       => 'timestamp NULL DEFAULT NULL',
                'update_time'       => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ),
            $options
        );
        $this->createIndex('ux_{{user}}_username', '{{user}}', 'username', true);
        $this->createIndex('ux_{{user}}_email', '{{user}}', 'email', true);
        $this->createIndex('ix_{{user}}_status', '{{user}}', 'status', false);
        $this->createIndex('ix_{{user}}_email_confirm', '{{user}}', 'email_confirm', false);

        $this->createTable('{{auth_item}}', array(
                'name'        => 'varchar(64) NOT NULL PRIMARY KEY',
                'type'        => 'int(11) NOT NULL',
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
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
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
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
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