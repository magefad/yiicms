<?php

class m130121_130000_blog extends EDbMigration
{
    public function safeUp()
    {
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';

        $this->createTable('{{blog}}', array(
                'id'             => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'type'           => 'enum("public","private") NOT NULL DEFAULT "public"',
                'status'         => 'enum("active","blocked","deleted") NOT NULL DEFAULT "active"',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ),
            $options
        );
        $this->createIndex('ux_{{blog}}_slug', '{{blog}}', 'slug', true);
        $this->createIndex('ix_{{blog}}_type', '{{blog}}', 'type', false);
        $this->createIndex('ix_{{blog}}_status', '{{blog}}', 'status', false);
        $this->createIndex('ix_{{blog}}_create_user_id', '{{blog}}', 'create_user_id', false);
        $this->createIndex('ix_{{blog}}_update_user_id', '{{blog}}', 'update_user_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{blog}}_{{user}}_create_user_id', '{{blog}}', 'create_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{blog}}_{{user}}_update_user_id', '{{blog}}', 'update_user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
        }

        $this->createTable('{{blog_post}}', array(
                'id'             => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'blog_id'        => 'int(11) unsigned NOT NULL',
                'title'          => 'varchar(75) NOT NULL',
                'keywords'       => 'varchar(200) NOT NULL',
                'description'    => 'varchar(200) NOT NULL',
                'content'        => 'text NOT NULL',
                'slug'           => 'varchar(75) NOT NULL',
                'link'           => 'varchar(200) NOT NULL DEFAULT ""',
                'status'         => 'enum("draft","published","moderation") NOT NULL DEFAULT "published"',
                'comment_status' => 'tinyint(1) NOT NULL DEFAULT "1"',
                'access_type'    => 'enum("public","private") NOT NULL DEFAULT "public"',
                'create_user_id' => 'int(11) unsigned NOT NULL',
                'update_user_id' => 'int(11) unsigned DEFAULT NULL',
                'publish_time'   => 'timestamp NOT NULL DEFAULT "0000-00-00 00:00:00"',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ),
            $options
        );
        $this->createIndex('ux_{{blog_post}}_slug', '{{blog_post}}', 'slug', true);
        $this->createIndex('ix_{{blog_post}}_blog_id', '{{blog_post}}', 'blog_id', false);
        $this->createIndex('ix_{{blog_post}}_status', '{{blog_post}}', 'status', false);
        $this->createIndex('ix_{{blog_post}}_comment_status', '{{blog_post}}', 'comment_status', false);
        $this->createIndex('ix_{{blog_post}}_access_type', '{{blog_post}}', 'access_type', false);
        $this->createIndex('ix_{{blog_post}}_create_user_id', '{{blog_post}}', 'create_user_id', false);
        $this->createIndex('ix_{{blog_post}}_update_user_id', '{{blog_post}}', 'update_user_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{blog_post}}_{{blog}}_blog_id', '{{blog_post}}', 'blog_id', '{{blog}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{blog_post}}_{{user}}_create_user_id', '{{blog_post}}', 'create_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
            $this->addForeignKey('fk_{{blog_post}}_{{user}}_update_user_id', '{{blog_post}}', 'update_user_id', '{{user}}', 'id', 'RESTRICT', 'NO ACTION');
        }

        $this->createTable('{{user_blog}}', array(
                'id'             => 'int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'user_id'        => 'int(11) unsigned NOT NULL',
                'blog_id'        => 'int(11) unsigned NOT NULL',
                'role'           => 'tinyint(3) unsigned NOT NULL DEFAULT "1"',
                'status'         => 'smallint(5) unsigned NOT NULL DEFAULT "1"',
                'note'           => 'varchar(255) NOT NULL DEFAULT ""',
                'create_time'    => 'timestamp NULL DEFAULT NULL',
                'update_time'    => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ),
            $options
        );
        $this->createIndex('ux_{{user_blog}}_user_id_blog_id', '{{user_blog}}', 'user_id,blog_id', true);
        $this->createIndex('ix_{{user_blog}}_blog_user_id', '{{user_blog}}', 'user_id', false);
        $this->createIndex('ix_{{user_blog}}_blog_blog_id', '{{user_blog}}', 'blog_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{user_blog}}_{{user}}_user_id', '{{user_blog}}', 'user_id', '{{user}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{user_blog}}_{{blog}}_blog_id', '{{user_blog}}', 'blog_id', '{{blog}}', 'id', 'CASCADE', 'NO ACTION');
        }

        $this->createTable('{{tag}}', array(
                'id'   => 'int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
                'name' => 'varchar(255) NOT NULL',
            ),
            $options
        );
        $this->createIndex('ux_tag_name', '{{tag}}', 'name', true);

        $this->createTable('{{blog_post_tag}}', array(
                'post_id' => 'int(11) unsigned NOT NULL',
                'tag_id'  => 'int(11) unsigned NOT NULL',
                'PRIMARY KEY (post_id, tag_id)'
            ),
            $options
        );
        $this->createIndex('ix_{{blog_post_tag}}_post_id', '{{blog_post_tag}}', 'post_id', false);
        $this->createIndex('ix_{{blog_post_tag}}_tag_id', '{{blog_post_tag}}', 'tag_id', false);
        if ((Yii::app()->db->schema instanceof CSqliteSchema) == false) {
            $this->addForeignKey('fk_{{blog_post_tag}}_{{blog_post}}_post_id', '{{blog_post_tag}}', 'post_id', '{{blog_post}}', 'id', 'CASCADE', 'NO ACTION');
            $this->addForeignKey('fk_{{blog_post_tag}}_{{tag}}_tag_id', '{{blog_post_tag}}', 'tag_id', '{{tag}}', 'id', 'CASCADE', 'NO ACTION');
        }
    }

    public function safeDown()
    {
        $this->dropTable('{{blog_post_tag}}');
        $this->dropTable('{{tag}}');
        $this->dropTable('{{user_blog}}');
        $this->dropTable('{{blog_post}}');
        $this->dropTable('{{blog}}');
    }
}