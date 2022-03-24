<?php

namespace fortrabbit\ObjectStorage;

use Aws\Handler\GuzzleV6\GuzzleHandler;
use Craft;
use craft\base\FlysystemVolume;
use craft\helpers\App;
use craft\helpers\DateTimeHelper;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\base\Exception;

/**
 * Class Volume
 *
 * @property mixed  $settingsHtml
 * @property string $rootUrl
 * @property integer $id
 * @property integer $fieldLayoutId
 * @property integer $sortOrder
 */
class Volume extends FlysystemVolume
{
    /**
     * @var string Subfolder to use
     */
    public $subfolder = '';
    /**
     * @var string AWS key ID
     */
    public $keyId = '';
    /**
     * @var string AWS key secret
     */
    public $secret = '';
    /**
     * @var string Bucket to use
     */
    public $bucket = '';
    /**
     * @var string Region to use
     */
    public $region = '';
    /**
     * @var string Cache expiration period.
     */
    public $expires = '';
    /**
     * @var string API endpoint
     */
    public $endpoint = '';
    /**
     * @var bool Whether this is a local source or not. Defaults to false.
     */
    protected $isVolumeLocal = false;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return 'fortrabbit Object Storage';
    }

    /**
     * Get the Amazon S3 client.
     *
     * @param array $config
     *
     * @return S3Client
     */
    protected static function client(array $config = []): S3Client
    {
        return new S3Client($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules   = parent::rules();
        $rules[] = [['bucket', 'keyId', 'secret', 'endpoint'], 'required'];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        try {
            return Craft::$app->getView()->renderTemplate('fortrabbit-object-storage/volumeSettings', [
                'volume' => $this,
            ]);
        } catch (LoaderError | RuntimeError | SyntaxError | Exception $e) {
            Craft::error([
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ], 'craft-object-storage'
            ]);
        }
        return null;
    }

    /**
     * @inheritdoc
     *
     * @return AwsS3Adapter
     */
    protected function createAdapter(): AwsS3Adapter
    {
        $endpoint = App::parseEnv($this->endpoint);

        if(!(str_contains($endpoint, 'https') || str_contains($endpoint, 'http'))) {
            $endpoint = 'https://' .  $endpoint;
        }

        $config = [
            'version' => 'latest',
            'region' => App::parseEnv($this->region),
            'endpoint' => $endpoint,
            'http_handler' => new GuzzleHandler(Craft::createGuzzleClient()),
            'use_path_style_endpoint' => (boolean)App::parseEnv('$OBJECT_STORAGE_PATH_STYLE') ?? false,
            'credentials' => [
                'key' => App::parseEnv($this->keyId),
                'secret' => App::parseEnv($this->secret)
            ]
        ];

        $client  = static::client($config);

        return new AwsS3Adapter($client, App::parseEnv($this->bucket), App::parseEnv($this->subfolder));
    }

    /**
     * @inheritdoc
     */
    protected function addFileMetadataToConfig(array $config): array
    {
        if (!empty($this->expires) && DateTimeHelper::isValidIntervalString($this->expires)) {
            $expires = new \DateTime();
            $now = new \DateTime();
            $expires->modify('+' . $this->expires);
            $diff = $expires->format('U') - $now->format('U');
            $config['CacheControl'] = 'max-age=' . $diff . ', must-revalidate';
        }

        return parent::addFileMetadataToConfig($config);
    }

}
