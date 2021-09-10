<?php

namespace fortrabbit\ObjectStorage;

use craft\errors\VolumeException;
use craft\errors\VolumeObjectExistsException;
use craft\helpers\FileHelper;
use spacecatninja\imagerx\externalstorage\ImagerStorageInterface;
use yii\base\Event;
use yii\di\NotInstantiableException;

class ImagerXExternalStorage implements ImagerStorageInterface
{
    public const IMAGERX_PLUGIN_CLASS = "spacecatninja\\imagerx\\ImagerX";
    public const IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT = "imagerxRegisterExternalStorages";
    public const NAME = "object-storage";

    public static function register()
    {
        if (!class_exists(ImagerXExternalStorage::IMAGERX_PLUGIN_CLASS)) {
            return;
        }

        Event::on(ImagerXExternalStorage::IMAGERX_PLUGIN_CLASS,
            ImagerXExternalStorage::IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT,
            static function (\spacecatninja\imagerx\events\RegisterExternalStoragesEvent $event) {
                $event->storages[ImagerXExternalStorage::NAME] = ImagerXExternalStorage::class;
            }
        );
    }


    public static function upload(string $file, string $uri, bool $isFinal, array $settings): bool
    {
        if (isset($settings['folder']) && $settings['folder'] !== '') {
            $uri = FileHelper::normalizePath($settings['folder'].'/'.$uri);
        }

        try {
            $config = [];
            $volume = \Craft::$container->get(Volume::class);
            $volume->createFileByStream($uri, fopen($file, 'rb') , $config);
        } catch (NotInstantiableException | VolumeException | VolumeObjectExistsException $e) {
            \Craft::error($e->getMessage(), 'fortrabbit-object-storage');
            return false;
        }

        return true;
    }
}
