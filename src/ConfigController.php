<?php namespace fortrabbit\ObjectStorage;

use Craft;
use craft\web\Controller;
use fortrabbit\ObjectStorage\Plugin as ObjectStoragePlugin;

class ConfigController extends Controller
{

    /**
     * @return \yii\web\Response
     */
    public function actionSync()
    {
        if (ObjectStoragePlugin::$plugin->syncConfig()) {
            Craft::$app->getSession()->setNotice(Craft::t('app', 'Volumes synced.'));
        }
        else {
            Craft::$app->getSession()->setError(Craft::t('app', 'Sync failed.'));
        }

        return $this->redirect(Craft::$app->getRequest()->referrer);

    }
}
