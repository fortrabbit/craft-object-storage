<?php

namespace fortrabbit\ObjectStorage;

use Craft;
use craft\console\controllers\SetupController;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Volumes;
use yii\base\Event;

/**
 * fortrabbit Object Storage plugin
 * provides a fortrabbit\ObjectStorage\Volume
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Helper::registerVolumeType();
        Helper::registerImagerXStorage();
    }

}
