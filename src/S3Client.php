<?php

namespace fortrabbit\ObjectStorage;

/**
 * Class S3Client
 *
 * @package fortrabbit\ObjectStorage
 */
class S3Client extends \Aws\S3\S3Client
{
    /**
     * fortrabbit Object Storage doesn't support multipart uploads,
     * so files up to the S3 single request limit (5 GB) are sent with one request
     */
    const DEFAULT_MULTIPART_THRESHOLD = 5368709120;

    /**
     * @see S3ClientInterface::upload()
     */
    public function upload(
        $bucket,
        $key,
        $body,
        $acl = 'private',
        array $options = []
    ) {

        $defaults = [
            'mup_threshold' => self::DEFAULT_MULTIPART_THRESHOLD,
        ];

        return $this
            ->uploadAsync($bucket, $key, $body, $acl, $options + $defaults)
            ->wait();
    }
}
