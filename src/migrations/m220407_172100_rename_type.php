<?php

namespace fortrabbit\ObjectStorage\migrations;

use Craft;
use craft\db\Migration;

/**
 * m220407_172100_rename_type migration.
 */
class m220407_172100_rename_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        // Don't make the same changes twice
        $schemaVersion = Craft::$app->getProjectConfig()->get('plugins.fortrabbit-object-storage.schemaVersion', true);
        if (version_compare($schemaVersion, '2.0', '>=')) {
            return true;
        }

        // Just re-run the install migration
        (new Install())->safeUp();
        return true;
    }


    public function safeDown(): bool
    {
        echo "m220407_172100_rename_type cannot be reverted.\n";
        return false;
    }
}
