<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! defined('EXT'))
{
	exit('Invalid file request');
}


class Url_metas_upd {

	var $return_data 	= "";
	var $tagdata 		= "";
	var $url 			= "";
	var $adminlink 		= "";

	function __construct() {
		$this->EE =& get_instance();
	}

	/**	----------------------------------------
	/**	Output Metas for the URL
	/**	----------------------------------------*/
	function Url_metas()
	{
		global $DB, $TMPL, $FNS;

			// $url 			= $FNS->fetch_current_uri();
			// $url 			= substr($url,-1) == "/" ? substr($url,0,-1) : $url;
			// $query			= $DB->query("SELECT * FROM exp_url_metas WHERE Url = '$url' OR Url = '$url/';");
			// if ($query->num_rows < 1) {
			// 	$query		= $DB->query("SELECT * FROM exp_url_metas WHERE `def` LIKE 'YES';");
			// 	$adminlink	= $url == "" ? "" : "<p><a href=\"/sys/index.php?C=modules&amp;M=Url_metas&amp;P=add&amp;".
			// 									"url=".base64_encode($url)."\" target=\"blank\">".
			// 									"Add URL Specific Metas for This Page (Currently Using Defaults)".
			// 									"</a></p>";
			// } else {
			// 	$adminlink	= $url == "" ? "" : "<p><a href=\"/sys/index.php?C=modules&amp;M=Url_metas&amp;P=edit&amp;".
			// 									"url_id=".$query->row['url_id']."\" target=\"blank\">".
			// 									"Edit Metas for This Page".
			// 									"</a></p>";
			// }

			// $tagdata 		= $TMPL->tagdata;
			// $tagdata		= $TMPL->swap_var_single("meta_title", $query->row['title'], $tagdata);
			// $tagdata		= $TMPL->swap_var_single("meta_keywords", $query->row['keywords'], $tagdata);
			// $tagdata		= $TMPL->swap_var_single("meta_description", $query->row['description'], $tagdata);
			// $tagdata		= $TMPL->swap_var_single("admin_link", $adminlink, $tagdata);

			// $this->return_data = $tagdata;
	}

}
// END CLASS
