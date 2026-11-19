Changelog
=========

## 3.0.1 - 2026-11-19
* Fix uploads with an empty Expires setting on PHP 8.3 and later ([#26](https://github.com/fortrabbit/craft-object-storage/pull/26))
* Allow `symfony/console` 6 and 7, so the plugin installs next to Craft Copy
* Ignore an invalid Expires setting instead of failing the upload
* Upload files over 100 MB with one request, fortrabbit Object Storage doesn't support multipart uploads
* `object-storage-init` reports an unknown App without a DNS warning

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
