<?php

namespace App\Core;

class Core
{
    public function __construct()
    {
        add_filter('upload_dir', [$this, 'remoteUploads']);
    }

    /**
     * @param array<string, mixed> $dir
     *
     * @return array<string, mixed>
     */
    public function remoteUploads(array $dir): array
    {
        if (!defined('REMOTE_UPLOADS')) {
            return $dir;
        }

        $dir['baseurl'] = constant('REMOTE_UPLOADS');

        return $dir;
    }
}
