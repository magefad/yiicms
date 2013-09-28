<?php
/**
 * Class m130816_104840_addType
 * Added new type of Page statusType - now catalog only
 */
class m130816_104840_addType extends EDbMigration
{
	public function safeUp()
	{
        $after = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema ? ' AFTER status' : '';//sqlite not support AFTER
        $this->addColumn('{{page}}', 'type', 'tinyint(4) DEFAULT NULL' . $after);
	}

	public function safeDown()
	{
        $this->dropColumn('{{page}}', 'type');
	}
}
