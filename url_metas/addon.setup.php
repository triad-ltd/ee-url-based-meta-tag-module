<?php
namespace Url_metas;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once PATH_THIRD . 'url_metas/common.php';

return [
    'author' => 'Triad Ltd',
    'author_url' => 'http://triad.uk.com',
    'description' => 'Set custom meta tag values based on URL',
    'namespace' => 'Url_metas',
    'name' => 'URL Metas',
    'settings_exist' => true,
    'version' => URL_METAS_VERSION,
];
