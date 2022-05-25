Changelog
=========
## 3.0.0 - 2022-05-25
* Craft 4 and PHP 8 support

## 2.1.0 - 2021-03-03

* Allow PHP ^8.0
* Remove `version` from composer.json (better rely on tags)

## 2.0.0 - 2020-11-23

* Craft 3.5 - config/volume.php deprecation
* Settings fields use ENV vars by default
* New command to generate .env config `php vendor/bin/object-storage-init`
* Requires PHP 7.3 or higher

## 1.1.0 - 2019-12-11

* Requires at least Craft 3.1
* Added [Craft::parseEnv()](https://docs.craftcms.com/api/v3/craft.html#public-methods) support for `keyId` and `secret` to prevent storing credentials in the DB and project config
* Fixed: Added missing `fieldLayoutId` when syncing config

## 1.0.3.1 - 2019-03-14

Prevent multipart uploads for files smaller than 100MB (`mup_threshold` was 16MB) by using a custom S3Client class 

## 1.0.3 - 2019-03-14

Prevent multipart uploads for files smaller than 100MB (`mup_threshold` was 16MB)

## 1.0.2 - 2018-05-15

No need to set the `OBJECT_STORAGE_URL` ENV var


## 1.0.1 - 2018-04-27

Explicitly require PHP 7.1


## 1.0.0 - 2018-02-27

Initial release
