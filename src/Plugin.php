<?php

namespace fortrabbit\ObjectStorage;

use Craft;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\TemplateEvent;
use craft\helpers\Console as ConsoleHelper;
use craft\services\Volumes;
use craft\web\Application as WebApplication;
use craft\web\UrlManager;
use craft\web\View;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\console\Application as ConsoleApplication;

/**
 * fortrabbit Object Storage plugin
 * provides a fortrabbit\ObjectStorage\Volume
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @var Plugin
     */
    public static $plugin;

    /**
     * @inheritdoc
     */
    public function init()
    {
        self::$plugin = $this;
        parent::init();

        Event::on(
            Volumes::class,
            Volumes::EVENT_REGISTER_VOLUME_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = Volume::class;
            }
        );

        // Register  CP routes
        if (\Craft::$app instanceof WebApplication) {
            $this->registerRoutes();
        }

        // Inject a button to the volumes/_index view
        $this->injectSyncButton();

    }

    /**
     * Syncs the config/volumes.yml with DB
     */
    public function syncConfig(): bool
    {
        $volumesService = Craft::$app->getVolumes();
        $volumesConfig  = Craft::$app->getConfig()->getConfigFromFile('volumes');

        if (!$volumesConfig) {
            return false;
        }

        foreach ($volumesConfig as $handle => $config) {

            /** @var \fortrabbit\ObjectStorage\Volume $existing */
            $existing = $volumesService->getVolumeByHandle($handle);

            $volume = new Volume(array_merge($config, [
                'fieldLayoutId' => ($existing) ? $existing->fieldLayoutId : null,
                'id'            => ($existing) ? $existing->id : null,
                'handle'        => $handle,
                'hasUrls'       => true,
                'sortOrder'     => ($existing) ? $existing->sortOrder : null,
            ]));

            try {
                $volumesService->saveVolume($volume, false);
            } catch (\Throwable $exception) {
                Craft::warning($exception->getMessage());
                return false;
            }

        }

        return true;
    }

    /**
     * Is called before the plugin is installed.
     */
    protected function beforeInstall(): bool
    {
        // We need Env Vars to access the Object Storage
        if (!getenv('OBJECT_STORAGE_SERVER')) {
            throw new InvalidConfigException('OBJECT_STORAGE_* ENV vars missing.');
        }

        // We need a config/volumes.php file
        if (0 === count(\Craft::$app->getConfig()->getConfigFromFile('volumes'))) {

            $configSourceFile = __DIR__ . DIRECTORY_SEPARATOR . 'config.example.php';
            $configTargetFile = \Craft::$app->getConfig()->configDir . DIRECTORY_SEPARATOR . 'volumes.php';

            if (!file_exists($configTargetFile)) {
                copy($configSourceFile, $configTargetFile);
                $this->warning('No volumes configured yet. We created config/volumes.php with a default volume.');
            }
        }

        return true;
    }

    /**
     * Is called after the plugin is installed.
     */
    protected function afterInstall(): void
    {
        $this->syncConfig();
    }

    /**
     * Shorthand to print a warning
     */
    protected function warning(string $message): void
    {
        if (\Craft::$app instanceof ConsoleApplication) {
            ConsoleHelper::error($message);
        } else {
            \Craft::$app->getSession()->setError($message);
        }
    }

    protected function registerRoutes(): void
    {
        // Register ConfigController
        $this->controllerMap['config'] = ConfigController::class;

        // Rules
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                // POST /admin/fortrabbit-object-storage > ConfigController::actionSave()
                $event->rules['POST fortrabbit-object-storage'] = 'fortrabbit-object-storage/config/sync';
            }
        );
    }

    protected function injectSyncButton(): void
    {
        Event::on(
            View::class,
            View::EVENT_AFTER_RENDER_PAGE_TEMPLATE,
            function (TemplateEvent $event) {
                if ($event->template === 'settings/assets/volumes/_index') {

                    // Render the settings template
                    $subview = \Craft::$app->getView();
                    $subview->setTemplatesPath(\Craft::getAlias('@fortrabbit/ObjectStorage/templates'));

                    $search  = '<div class="buttons">';
                    $button  = $subview->renderTemplate('actionButton');
                    $replace = "$search $button";

                    $event->output = str_replace($search, $replace, $event->output);

                }
            }
        );
    }
}
