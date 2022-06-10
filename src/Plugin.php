<?php

namespace fortrabbit\ObjectStorage;

use Craft;
use craft\console\controllers\SetupController;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fs as FsService;
use craft\services\Volumes;
use yii\base\Event;

/**
 * fortrabbit Object Storage plugin
 * provides a fortrabbit\ObjectStorage\Fs
 */
class Plugin extends \craft\base\Plugin
{
    public string $schemaVersion = '2.0';
		
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
				
        Craft::$app->controllerMap['setup'] = [
            'class' => SetupController::class,
        ];
			
       Event::on(
            FsService::class,
            FsService::EVENT_REGISTER_FILESYSTEM_TYPES,
            static function (RegisterComponentTypesEvent $event) {
                $event->types[] = Fs::class;
						});
    }
}