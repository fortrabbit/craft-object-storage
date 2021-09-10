<?php

namespace fortrabbit\ObjectStorage;

use spacecatninja\imagerx\externalstorage\ImagerStorageInterface;
use yii\base\Event;

class ImagerXDrive implements ImagerStorageInterface
{
    public const IMAGERX_PLUGIN_CLASS = "spacecatninja\\imagerx\\ImagerX";
    public const IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT = "imagerxRegisterExternalStorages";
    public const NAME = "object-storage";

    public static function register()
    {
        Event::on(ImagerXDrive::IMAGERX_PLUGIN_CLASS,
            ImagerXDrive::IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT,
            static function (\spacecatninja\imagerx\events\RegisterExternalStoragesEvent $event) {
                $event->storages[ImagerXDrive::NAME] = ImagerXDrive::class;
            }
        );
    }

    public static function upload(string $file, string $uri, bool $isFinal, array $settings)
    {
        // TODO: Implement upload() method.
    }
}
