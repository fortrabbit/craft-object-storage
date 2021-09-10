<?php

use fortrabbit\ObjectStorage\ImagerXExternalStorage;
use spacecatninja\imagerx\events\RegisterExternalStoragesEvent;
use spacecatninja\imagerx\ImagerX;
use yii\base\Event;

test('imagerx class name did not change', function () {
    $ourName = ImagerXExternalStorage::IMAGERX_PLUGIN_CLASS;
    $theirName = ImagerX::class;
    expect($ourName)->toBe($theirName);
});

test('imagerx event name did not change', function () {
    $ourName = ImagerXExternalStorage::IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT;
    $theirName = ImagerX::EVENT_REGISTER_EXTERNAL_STORAGES;
    expect($ourName)->toBe($theirName);
});

test('external storage is registered using event', function () {
    ImagerXExternalStorage::register();

    $event = new RegisterExternalStoragesEvent([
        'storages' => [],
    ]);
    Event::trigger(
        ImagerX::class,
        ImagerX::EVENT_REGISTER_EXTERNAL_STORAGES,
        $event
    );

    $class = $event->storages['fortrabbit-object-storage'];
    expect($class)->toBe(ImagerXExternalStorage::class);
});
