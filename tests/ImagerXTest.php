<?php

test('imagerx class name did not change', function () {
    $ourName = \fortrabbit\ObjectStorage\ImagerXDriver::IMAGERX_PLUGIN_CLASS;
    $theirName = \spacecatninja\imagerx\ImagerX::class;
    expect($ourName)->toBe($theirName);
});

test('imagerx event name did not change', function () {
    $ourName = \fortrabbit\ObjectStorage\ImagerXDriver::IMAGERX_REGISTER_EXTERNAL_STORAGES_EVENT;
    $theirName = \spacecatninja\imagerx\ImagerX::EVENT_REGISTER_EXTERNAL_STORAGES;
    expect($ourName)->toBe($theirName);
});
