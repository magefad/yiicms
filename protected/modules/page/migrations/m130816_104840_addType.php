<?php
/**
 * Class m130816_104840_addType
 * Added new type of Page statusType - now catalog only
 */
class m130816_104840_addType extends EDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{page}}', 'type', 'tinyint(4) DEFAULT NULL AFTER status');
	}

	public function safeDown()
	{
        $this->dropColumn('{{page}}', 'type');
	}
}
