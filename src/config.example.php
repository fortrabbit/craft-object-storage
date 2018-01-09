<?php
$objectStorageAccess = [
    'url'      => getenv('OBJECT_STORAGE_URL'),
    'keyId'    => getenv('OBJECT_STORAGE_KEY'),
    'secret'   => getenv('OBJECT_STORAGE_SECRET'),
    'bucket'   => getenv('OBJECT_STORAGE_BUCKET'),
    'region'   => getenv('OBJECT_STORAGE_REGION'),
    'endpoint' => "https://" . getenv('OBJECT_STORAGE_SERVER'),
];

return [
    // Default volume
    'objectStorageAssets' => array_merge($objectStorageAccess, [
        'name'      => 'Object Storage Assets',
        'subfolder' => 'assets',
    ]),

    // Define more volumes like this:
    //
    // 'objectStorageVolume2' => array_merge($objectStorageAccess, [
    //    'name'      => 'Object Storage Volume 2',
    //    'subfolder' => 'vol2',
    //]),

];
