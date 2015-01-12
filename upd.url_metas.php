<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class URL_metas_upd
{
	
	var $version = '0.2';

	function install()
	{
		$sql[] = "INSERT INTO exp_modules (module_id, module_name, module_version, has_cp_backend) 
			VALUES ('', 'Url_metas', '$this->version', 'y')";
		$sql[] = "INSERT INTO exp_actions (action_id, class, method) 
			VALUES ('', 'Url_metas', 'output_metas')";
		$sql[] = "INSERT INTO exp_actions (action_id, class, method) 
			VALUES ('', 'Url_metas_CP', 'add_new_metas')";

		$sql[] = "CREATE TABLE `exp_url_metas` (
		`url_id` mediumint(6) NOT NULL auto_increment,
		`url` varchar(255) default NULL,
		`title` varchar(255) default NULL,
		`keywords` varchar(255) default NULL,
		`description` varchar(255) default NULL,
		`def` enum('YES','NO') default 'NO',
		PRIMARY KEY  (`url_id`)
		)";

		$sql[] = "INSERT INTO exp_url_metas (`title`, `keywords`, `description`, `def`) 
			VALUES ('default, keywords, here', 'default, keywords, here', 'default keywords in here', 'YES')";

		foreach ($sql as $query) {
			ee()->db->query($query);
		}

		return true;
	}

	function uninstall()
	{
		global $DB;    

		$query = $DB->query("SELECT module_id FROM exp_modules WHERE module_name = 'Weblog'"); 

		$sql[] = "DELETE FROM exp_module_member_groups WHERE module_id = '".$query->row['module_id']."'";        

		$sql[] = "DELETE FROM exp_modules WHERE module_name = 'Url_metas'";
		$sql[] = "DELETE FROM exp_actions WHERE class = 'Weblog'";
		$sql[] = "DELETE FROM exp_actions WHERE class = 'Weblog_CP'";

		$sql[] = "DROP TABLE IF EXISTS exp_url_metas";

		foreach ($sql as $query)
		{
			$DB->query($query);
		}

		return true;
	}

	function update($current = '')
	{
	    return FALSE;
	}
}
