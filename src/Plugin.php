<?php

namespace fortrabbit\ObjectStorage;

use Craft;
use craft\console\controllers\SetupController;
use craft\base\Element;
use craft\elements\Asset;
use craft\events\ModelEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Volumes;
use craft\services\Fs as FsService;

use fortrabbit\ObjectStorage\Handlers\AutoFocalPointHandler;
use fortrabbit\ObjectStorage\Handlers\FileSystemTypeHandler;
use yii\base\Event;

/**
 * fortrabbit Object Storage plugin
 * provides a fortrabbit\ObjectStorage\Volume
 */
class Plugin extends \craft\base\Plugin
{

    public string $schemaVersion = '2.0';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        /**
        \Craft::$app->controllerMap['setup'] = [
            'class' => SetupController::class,
        ];
        */

        Event::on(
            FsService::class,
            FsService::EVENT_REGISTER_FILESYSTEM_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ObjectStorageFs::class;
            }
        );
    }
}
