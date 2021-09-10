<?php

namespace fortrabbit\ObjectStorage;

/**
 * fortrabbit Object Storage plugin
 * provides a fortrabbit\ObjectStorage\Volume
 */
class Plugin extends \craft\base\Plugin
{
    public function init()
    {
        parent::init();

        Volume::register();
        ImagerXExternalStorage::register();
    }
}
