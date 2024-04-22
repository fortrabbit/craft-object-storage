fortrabbit Object Storage Volume for Craft CMS
==============================================

This plugin provides an [Object Storage](https://help.fortrabbit.com/object-storage) integration for [Craft CMS](https://craftcms.com/).


## Requirements

The 4.0 release of this plugin requires Craft CMS 5 and PHP 8.0 or later. 


## Installation

To install the plugin, follow these instructions.


**1. Install the plugin via composer**

```
cd /path/to/project

composer require fortrabbit/craft-object-storage
```

**2. Update your local .env file** 

Run this command in the terminal to update your .env automatically:

```
./vendor/bin/object-storage-init {your-app}
```

If it fails for some reason, update your .env file manually. Learn how to [access credentials](https://help.fortrabbit.com/object-storage#toc-obtaining-credentials) on fortrabbit.

```
OBJECT_STORAGE_BUCKET="(YOUR_APP_NAME)"
OBJECT_STORAGE_HOST="(YOUR_APP_NAME).objects.frb.io"
OBJECT_STORAGE_KEY="(YOUR_APP_NAME)"
OBJECT_STORAGE_REGION="(us-east-1|eu-west-1)"
OBJECT_STORAGE_SECRET="(OBJECT_STORAGE_SECRET)"
OBJECT_STORAGE_SERVER="objects.(us1|eu2).frbit.com"
```



**3. Install the plugin**
```
./craft plugin/install fortrabbit-object-storage
```

Or browse to  CP > Settings > Plugins to enable the plugin.


**4. Configure**

Configure filesystems under: Settings > Filesystems >> **[New Filesystem]**.

- Select `fortrabbit Object Storage` as Filesystem Type.
- For the Base URL field use `$OBJECT_STORAGE_HOST` ENV variable. 
All other fields are pre-configured with ENV vars already. 
- Set a value for Expires (Cache expiration period)

Configure volumes under: Settings > Assets > **[New Volume]**.  

- Select the filesystem created above as the Asset Filesystem. 

