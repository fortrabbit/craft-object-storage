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
     * @var Plugin
     */
    public static $plugin;

    /**
     * @inheritdoc
     */
    public function init()
    {
        self::$plugin = $this;
        parent::init();


        \Craft::$app->controllerMap['setup'] = [
            'class' => SetupController::class,
        ];

        Event::on(
            Volumes::class,
            Volumes::EVENT_REGISTER_VOLUME_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = Volume::class;
            }
        );
    }
}
