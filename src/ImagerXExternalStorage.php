<?php

namespace fortrabbit\ObjectStorage;

use craft\base\VolumeInterface;
use craft\errors\InvalidVolumeException;
use craft\errors\VolumeException;
use craft\errors\VolumeObjectExistsException;
use craft\helpers\FileHelper;
use spacecatninja\imagerx\externalstorage\ImagerStorageInterface;
use yii\base\Event;

class ImagerXExternalStorage implements ImagerStorageInterface
{
    public const IMAGERX_PLUGIN_CLASS = "spacecatninja\\imagerx\\ImagerX";
    public const IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT = "imagerxRegisterExternalStorages";
    public const NAME = "fortrabbit-object-storage";

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
            $volume = self::getVolume($settings['volume'] ?? null);
            $volume->createFileByStream($uri, fopen($file, 'rb') , $config);
        } catch (InvalidVolumeException | VolumeException | VolumeObjectExistsException $e) {
            \Craft::error($e->getMessage(), 'fortrabbit-object-storage');
            return false;
        }

        return true;
    }


    /**
     * @throws \craft\errors\InvalidVolumeException
     */
    protected static function getVolume(string $handle = null):  VolumeInterface
    {
        $volumeService = \Craft::$app->getVolumes();

        if ($handle) {
            return $volumeService->getVolumeByHandle($handle);
        }

        // pick the fist one
        foreach ($volumeService->getAllVolumes() as $volume) {
            if (get_class($volume) === Volume::class) {
                return $volume;
            }
        }

        throw new InvalidVolumeException();
    }
}
