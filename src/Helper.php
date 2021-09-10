<?php

namespace fortrabbit\ObjectStorage;

use craft\events\RegisterComponentTypesEvent;
use craft\services\Volumes;
use yii\base\Event;

class Helper
{

    public static function registerVolumeType(): bool
    {
        if (!class_exists(Volumes::class)) {
            return false;
        }

        Event::on(
            Volumes::class,
            Volumes::EVENT_REGISTER_VOLUME_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = Volume::class;
            }
        );

        return true;
    }

    public static function registerImagerXStorage(): bool
    {
        if (!class_exists(ImagerXDrive::IMAGERX_PLUGIN_CLASS)) {
            return false;
        }

        Event::on(ImagerXDrive::IMAGERX_PLUGIN_CLASS,
            ImagerXDrive::IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT,
            static function (\spacecatninja\imagerx\events\RegisterExternalStoragesEvent $event) {
                $event->storages[ImagerXDrive::NAME] = ImagerXDrive::class;
            }
        );

        return true;
    }
}
