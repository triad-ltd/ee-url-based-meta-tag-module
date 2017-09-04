<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url_metas {

	var $return_data 	= '';
	var $tagdata 		= '';
	var $url 			= '';
	var $adminlink 		= '';

	/**	----------------------------------------
	/**	Output Metas for the URL
	/**	----------------------------------------*/
	function __construct() {
		global $DB, $TMPL, $FNS;

		$url 			= ee()->uri->uri_string;
		$url 			= substr($url,-1) == '/' ? substr($url,0,-1) : $url;
		$query			= ee()->db->select('*')
								  ->from('url_metas')
								  ->where(array('url' => $url))
								  ->get();

		$sys_folder 	= ee()->config->item('system_folder');

		if ($query->num_rows < 1) {
			$query		= ee()->db->select('*')->from('url_metas')->where(array('def' => 'YES'))->get();
			$adminlink	= $url == '' ? '' : '<a href=/'.$sys_folder.'/'.ee('CP/URL','addons/settings/url_metas/add/'.base64_encode($url)).' target=blank>'.
											'Add URL Specific Metas for This Page (Currently Using Defaults)'.
											'</a>';
		} else {
			$adminlink	= $url == '' ? '' : '<p><a href=/'.$sys_folder.'/'.ee('CP/URL','addons/settings/url_metas/edit/'.$query->row('url_id')).' target=blank>'.
											'Edit Metas for This Page'.
											'</a>';
		}

		$tagdata 		= ee()->TMPL->tagdata;
		$tagdata		= ee()->TMPL->swap_var_single('meta_title', $query->row('title'), $tagdata);
		$tagdata		= ee()->TMPL->swap_var_single('meta_keywords', $query->row('keywords'), $tagdata);
		$tagdata		= ee()->TMPL->swap_var_single('meta_description', $query->row('description'), $tagdata);
		$tagdata		= ee()->TMPL->swap_var_single('meta_admin_link', $adminlink, $tagdata);

		$this->return_data = $tagdata;
	}

}
// END CLASS
