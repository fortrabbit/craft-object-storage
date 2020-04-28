<?php

namespace fortrabbit\ObjectStorage;

use Aws\Handler\GuzzleV6\GuzzleHandler;
use Craft;
use craft\base\FlysystemVolume;
use craft\helpers\DateTimeHelper;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

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
     * @var boolean
     */
    public $usePathStyleEndpoint;
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
     * @param $config
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
    public function rules()
    {
        $rules   = parent::rules();
        $rules[] = [['bucket', 'keyId', 'secret', 'endpoint'], 'required'];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $volumesConfig = \Craft::$app->getConfig()->getConfigFromFile('volumes');

        foreach ($volumesConfig as $handle => $config) {
            if (!isset($config['endpoint'])) {
                unset($volumesConfig[$handle]);
            }
            if ($handle == $this->handle) {
                unset($volumesConfig[$handle]);
            }
        }

        return Craft::$app->getView()->renderTemplate('fortrabbit-object-storage/volumeSettings', [
            'volume'        => $this,
            'volumesConfig' => $volumesConfig
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getRootUrl()
    {
        if (($rootUrl = parent::getRootUrl()) !== false && $this->subfolder) {
            $rootUrl .= rtrim($this->subfolder, '/') . '/';
        }

        return $rootUrl;
    }

    /**
     * @inheritdoc
     *
     * @return AwsS3Adapter
     */
    protected function createAdapter()
    {
        $config = [
            'version'      => 'latest',
            'region'       => $this->region,
            'endpoint'     => $this->endpoint,
            'http_handler' => new GuzzleHandler(Craft::createGuzzleClient()),
            'use_path_style_endpoint' => $this->usePathStyleEndpoint === 'true',
            'credentials'  => [
                'key'    => Craft::parseEnv($this->keyId),
                'secret' => Craft::parseEnv($this->secret)
            ]
        ];

        $client  = static::client($config);

        return new AwsS3Adapter($client, $this->bucket, $this->subfolder);
    }

    /**
     * @inheritdoc
     */
    protected function addFileMetadataToConfig(array $config): array
    {
        if (!empty($this->expires) && DateTimeHelper::isValidIntervalString($this->expires)) {
            $expires = new \DateTime();
            $now     = new \DateTime();
            $expires->modify('+' . $this->expires);
            $diff                   = $expires->format('U') - $now->format('U');
            $config['CacheControl'] = 'max-age=' . $diff . ', must-revalidate';
        }

        return parent::addFileMetadataToConfig($config);
    }

}
