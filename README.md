fortrabbit Object Storage Volume for Craft CMS
==============================================

This plugin provides an [Object Storage](https://help.fortrabbit.com/object-storage) integration for [Craft CMS](https://craftcms.com/).


## Requirements

This plugin requires Craft CMS 3.0.0-RC4 or later.


## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

```
cd /path/to/project
```

2. Then tell Composer to load the plugin:

```
composer require fortrabbit/craft-object-storage
```

3. Update your local .env file 

Learn how to [access credentials](https://help.fortrabbit.com/object-storage#toc-obtaining-credentials) on fortrabbit.

```
OBJECT_STORAGE_BUCKET="(YOUR_APP_NAME)"
OBJECT_STORAGE_HOST="(YOUR_APP_NAME).objects.frb.io"
OBJECT_STORAGE_KEY="(YOUR_APP_NAME)"
OBJECT_STORAGE_REGION="(us-east-1|eu-west-1)"
OBJECT_STORAGE_SECRET="(OBJECT_STORAGE_SECRET)"
OBJECT_STORAGE_SERVER="objects.(us1|eu2).frbit.com"
OBJECT_STORAGE_URL="https://(YOUR_APP_NAME).objects.frb.io"
```

4. Install the plugin

Execute the this command `./craft install/plugin fortrabbit-object-storage` in your terminal to install the plugin or in the Craft CP under Settings > Plugins

