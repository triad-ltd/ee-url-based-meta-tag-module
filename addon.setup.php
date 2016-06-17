<?php

namespace Url_metas;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * URL Metas
 *
 * @package             Url metas for EE3
 * @author              Stephen Sweetland <stephen@triad.uk.com>
 * @copyright           Copyright (c) 2016 Triad Ltd
 * @link                http://triad.uk.com
 */

require_once(PATH_THIRD.'url_metas/common.php');

return array(
	'author'      		=> 'Triad Ltd',
	'author_url'  		=> 'http://triad.uk.com',
	'description' 		=> 'Lets you set url-specific meta information. FTW.',
	'namespace'   		=> 'Url_metas',
	'name'        		=> 'URL Metas',
	'settings_exist' 	=> true,
	'version'     		=> URL_METAS_VER,
);