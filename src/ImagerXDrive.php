<?php

namespace fortrabbit\ObjectStorage;

use spacecatninja\imagerx\externalstorage\ImagerStorageInterface;

class ImagerXDrive implements ImagerStorageInterface
{
    public const IMAGERX_PLUGIN_CLASS = "spacecatninja\\imagerx\\ImagerX";
    public const IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT = "imagerxRegisterExternalStorages";
    public const NAME = "object-storage";


    public static function upload(string $file, string $uri, bool $isFinal, array $settings)
    {
        // TODO: Implement upload() method.
    }
}
