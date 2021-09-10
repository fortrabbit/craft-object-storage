<?php

use fortrabbit\ObjectStorage\Helper;

test('imagerx class name did not change', function () {
    $ourName = \fortrabbit\ObjectStorage\ImagerXDrive::IMAGERX_PLUGIN_CLASS;
    $theirName = \spacecatninja\imagerx\ImagerX::class;
    expect($ourName)->toBe($theirName);
});

test('imagerx event name did not change', function () {
    $ourName = \fortrabbit\ObjectStorage\ImagerXDrive::IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT;
    $theirName = \spacecatninja\imagerx\ImagerX::EVENT_REGISTER_EXTERNAL_STORAGES;
    expect($ourName)->toBe($theirName);
});

test('event RegisterExternalStoragesEvent registered using helper', function () {
    $success = Helper::registerImagerXStorage();
    expect($success)->toBeTrue();
});

test('event RegisterComponentTypesEvent registered  using helper', function () {
    $success = Helper::registerVolumeType();
    expect($success)->toBeTrue();
});
