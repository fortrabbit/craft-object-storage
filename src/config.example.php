<?php
$objectStorageAccess = [
    'url'      => "https://" . getenv('OBJECT_STORAGE_HOST'),
    'endpoint' => "https://" . getenv('OBJECT_STORAGE_SERVER'),
    'keyId'    => '$OBJECT_STORAGE_KEY',
    'secret'   => '$OBJECT_STORAGE_SECRET',
    'bucket'   => getenv('OBJECT_STORAGE_BUCKET'),
    'region'   => getenv('OBJECT_STORAGE_REGION'),
];

return [
    // Default volume
    'objectStorageAssets' => array_merge($objectStorageAccess, [
        'name'      => 'Object Storage Assets',
        'subfolder' => 'assets',
        'type'      => 'fortrabbit\ObjectStorage\Volume',
    ]),

    // Define more volumes like this:
    //
    // 'objectStorageVolume2' => array_merge($objectStorageAccess, [
    //    'name'      => 'Object Storage Volume 2',
    //    'subfolder' => 'vol2',
    //]),
];
