<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * URL Metas
 *
 * @package             Url metas for EE3
 * @author              Stephen Sweetland <stephen@triad.uk.com>
 * @copyright           Copyright (c) 2016 Triad Ltd
 * @link                http://triad.uk.com
 */

require_once(PATH_THIRD.'urlmetas/config.php');

return array(
	'namespace'   		=> 'User\Addons\Url_metas',
	'name'        		=> 'URL Metas',
	'author'      		=> 'Triad Ltd',
	'author_url'  		=> 'http://triad.uk.com',
	'description' 		=> 'Lets you set url-specific meta information. FTW.',
	'settings_exist' 	=> true,
	'version'     		=> URL_METAS_VER,
);