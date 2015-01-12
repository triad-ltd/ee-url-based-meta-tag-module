<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url_metas_mcp {

  var $version			= '0.2';
  var $base				= '';
  
  
  
		  /** ----------------------------------------
		  /**  Module Setup
		  /** ----------------------------------------*/  
  		function Url_metas_CP( $switch = TRUE )
  		{
  				global $IN;
  				
  				
  				$this->base	= BASE.AMP.'C=modules'.AMP.'M=Url_metas'.AMP;
  				
  				
  				if ($switch){
  						switch($IN->GBL('P'))
  						{
								case 'add'			:			$this->edit_url_metas();
									break;  									
  									
  								case 'edit'			:			$this->edit_url_metas();
  									break;

  								case 'view'			:			$this->view_url_metas();
  									break;
  									
  								case 'create'		:			$this->update_url_metas("create");
  									break;
  									
  								case 'update'		:			$this->update_url_metas();
  									break;
  									
  								case 'defaults'		:			$this->default_url_metas();
  									break;

  								default				:			$this->url_metas_home();
  									break;
  									
  						}
  				}
  		} 
  	
  	
  
 		  /** ----------------------------------------
	    /**  Module Homepage
	    /** ----------------------------------------*/
	    function url_metas_home()
	    {
	        global $DSP, $LANG;
	        	        
	        // show the view metas page by default.
	        $this->view_url_metas();                

	        $DSP->crumb .= $DSP->crumb_item($LANG->line('url_metas_menu')); 	                                   

	    }
	    /** END **/
  
	
	
		  /** ----------------------------------------
		  /**  Module installer
		  /** ----------------------------------------*/
		  function url_metas_header($page="",$msg="")
		  {
		  		global $DSP, $LANG;
		  		
	        $DSP->title = $LANG->line('url_metas_module_name');

	        $DSP->crumb = $DSP->anchor(BASE.
	                                   AMP.'C=modules'.
	                                   AMP.'M=Url_metas',
	                                   $LANG->line('url_metas_module_name'));
	                                   
					$DSP->right_crumb($LANG->line('add_url_metas'), BASE.AMP.'C=modules'.AMP.'M=Url_metas'.AMP.'P=add_url_metas');
					
					$r = $this->url_metas_nav(
							array(
									'view_url_metas'	=> array('P' => ''),
									'add_url_metas'	=> array('P' => 'add'),
									'edit_url_metas'	=> '#',
									'default_url_metas'			=> array('P' => 'defaults'),
							),
							$page
					);


	        if ($msg != '')
	        {
						$r .= $DSP->qdiv('successBox', $DSP->qdiv('success', $msg));
	        }
        		
					if ($r != '')
					{
						$DSP->body	.= $r;
					}		
	                                   

		  }  
		  /** END **/
  
  
		
		  /** ----------------------------------------
		  /**  Module installer
		  /** ----------------------------------------*/
		  function url_metas_nav($nav_array,$page="")
		  {
	        global $IN, $DSP, $LANG;
        
       
					/**	----------------------------------------
					/**	Build menus
					/**	----------------------------------------
					/*	Equalize the text length. We do this so
					/*	that the tabs will all be the same length.
					/**	----------------------------------------*/		
					$temp		= array();
					foreach ($nav_array as $k => $v)
					{
						$temp[$k]	= $LANG->line($k);
					}
					
					$temp		= $DSP->equalize_text($temp);

	        $page		= $page == "" ? $IN->GBL('P') : $page;
        
	        $highlight	= array(
	        					'view_url_metas'					=> 'view_url_metas',
	        					'add_url_metas'				=> 'add_url_metas',
	        					'edit_url_metas'					=> 'edit_url_metas',
	        					'default_url_metas'					=> 'default_url_metas',
					);
       

	        if ( isset($highlight[$page]) )
	        {
	        	$page	= $highlight[$page];
	        }
        
            
					$r		= <<<EOT
        
    <script type="text/javascript"> 
    <!--
			function styleswitch(link)
			{                 
				if (document.getElementById(link).className == 'altTabs')
				{
					document.getElementById(link).className = 'altTabsHover';
				}
			}
		
			function stylereset(link)
			{                 
				if (document.getElementById(link).className == 'altTabsHover')
				{
					document.getElementById(link).className = 'altTabs';
				}
			}
		-->
		</script>
EOT;
    
					$r		.= $DSP->table_open( array('width' => '100%') );
			
					$nav	= array();
					
					foreach ( $nav_array as $key => $val )
					{
						$url	= '';
					
						if ( is_array($val) )
						{
							$url	= $this->base;		
						
							foreach ( $val as $k => $v )
							{
								$url	.= $k.'='.$v;
							}					
						}
			
						$url	= ( $url == '' ) ? $val: $url;
			
						$div	= ( ( ( ! $page ) ? 'home': $page ) == $key ) ? 'altTabSelected': 'altTabs';
						$linko	= '<div class="'.$div.'" id="'.$key.'"  onClick="navjump(\''.$url.'\');" onmouseover="styleswitch(\''.$key.'\');" onmouseout="stylereset(\''.$key.'\');">'.$temp[$key].'</div>';
								
						$nav[]	= array( 'text' => $DSP->anchor( $url, $linko ) );
					}
			
					$r		.= $DSP->table_row( $nav );		
					$r		.= $DSP->table_close();
			
					return $r;          
		  }
	    /** END **/
  	
  	
	
		  /** ----------------------------------------
		  /**  Module installer
		  /** ----------------------------------------*/
		  function url_metas_module_install()
		  {
		      global $DB;        
		      
		      $sql[] = "INSERT INTO exp_modules (module_id, module_name, module_version, has_cp_backend) VALUES ('', 'Url_metas', '$this->version', 'y')";
		      $sql[] = "INSERT INTO exp_actions (action_id, class, method) VALUES ('', 'Url_metas', 'output_metas')";
		      $sql[] = "INSERT INTO exp_actions (action_id, class, method) VALUES ('', 'Url_metas_CP', 'add_new_metas')";
			
					$sql[] = "CREATE TABLE `exp_url_metas` (
										  `url_id` mediumint(6) NOT NULL auto_increment,
										  `url` varchar(255) default NULL,
										  `title` varchar(255) default NULL,
										  `keywords` varchar(255) default NULL,
										  `description` varchar(255) default NULL,
										  `def` enum('YES','NO') default 'NO',
										  PRIMARY KEY  (`url_id`)
										)";
										
		      $sql[] = "INSERT INTO exp_url_metas (`title`, `keywords`, `description`, `def`) VALUES ('default, keywords, here', 'default, keywords, here', 'default keywords in here', 'YES')";
		
		      foreach ($sql as $query)
		      {
		          $DB->query($query);
		      }
		      
		      return true;
		  }
		  /** END **/
	    
	    	    	    
	    
	    /** ----------------------------------------
	    /**  Module de-installer
	    /** ----------------------------------------*/
	    function url_metas_module_deinstall()
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
	    
	    
	    
	    /** ----------------------------------------
	    /**  Add URL Metas
	    /** ----------------------------------------*/
	    function add_url_metas()
	    {
	        global $DB, $IN, $DSP, $LANG;
	        
	        $this->url_metas_header();    
//	        $DSP->crumb .= $DSP->crumb_item($LANG->line('add_url_metas')); 
//	
//					$DSP->body = "";
//		  		global $DSP, $LANG;
//		  		
//		  		$folder = '';
//		  		
//		  		$DSP->body = $DSP->form_open(array('action' => 'C=modules'.AMP.'M=gallery'.AMP.'P=new_gallery_step_two'))
//					.$DSP->qdiv('tableHeading', $LANG->line('gallery_step_one'))
//					.$DSP->div('box')
//					.$DSP->qdiv('itemWrapper', $DSP->qspan('defaultBold', $LANG->line('url_metas_')))
//					.$DSP->qdiv('itemWrapper', $LANG->line('gallery_create_info'))
//					.$DSP->qdiv('itemWrapper', $LANG->line('gallery_create_info2'))
//					.$DSP->qdiv('itemWrapper', $DSP->qspan('defaultBold', $LANG->line('gallery_upload_path')))
//					.$DSP->qdiv('itemWrapper', $LANG->line('gallery_if_path_unknown'))
//					.$DSP->input_text('gallery_folder', $folder, '30', '100', 'input', '400px').BR.BR
//					.$DSP->qdiv('itemWrapper', BR.$DSP->input_submit($LANG->line('submit')))
//					.$DSP->div_c()
//					.$DSP->form_close();
						
	        return true;
	    }
	    /** END **/

	    
	    

	    /** ----------------------------------------
	    /**  View URL Metas
	    /** ----------------------------------------*/
	    function view_url_metas($msg = "")
	    {
	        global $DB, $IN, $DSP, $LANG;
	        
	        $this->url_metas_header("view_url_metas",$msg);    
	        $DSP->crumb .= $DSP->crumb_item($LANG->line('view_url_metas'));

	        $row_limit		= 15; // you may change this.
	        $row_count		= 0;
	        
	        $url_id			= ( $IN->GBL('url_id') ) ? AMP.'url_id='.$IN->GBL('url_id'): '';

	    	
				/**	----------------------------------------
				/**	Start page
				/**	----------------------------------------*/
				$r			= $DSP->qdiv('itemWrapper', '&nbsp;');
				$r			.= $DSP->qdiv('tableHeading', $LANG->line('url_metas'));
	    	
	
	
				/**	----------------------------------------
				/**	Page content
				/**	----------------------------------------*/
	
					$urls				= $DB->query("SELECT count(url) as totalurls FROM exp_url_metas WHERE url != '' AND `def` = 'NO' ORDER BY url ASC");
					$totalrows 			= $urls->row['totalurls'];
	
					if ($totalrows < 1)
					{
						$r						.= $DSP->qdiv('itemWrapper', '&nbsp;');
						$r						.=	$DSP->qdiv('highlight', $LANG->line('no_entries'));
					}
					
			
					if ($totalrows > 0){

				/**	----------------------------------------
				/**	Table header
				/**	----------------------------------------*/
						
						
					$r					.=	$DSP->toggle();
			        $DSP->body_props	.= ' onload="magic_check()" ';
			        $r					.= $DSP->magic_checkboxes();
			        
		
			        $form_url			= 'C=modules'.AMP.'M=Url_metas'.AMP.'P=edit_url_metas';
			        
			        $r					.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));
							$r			.= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));
						
		
							$top[]		= array(
												'text'	=> $LANG->line("table_id_header"),
												'class'	=> 'tableHeadingAlt',
												'width'	=>  '5%'
												);					
																	
							$top[]		= array(
												'text'	=> $LANG->line("table_url_header"),
												'class'	=> 'tableHeadingAlt',
												'width'	=>  '35%'
												);
																	
							$top[]		= array(
												'text'	=> $LANG->line("table_keywords_header"),
												'class'	=> 'tableHeadingAlt',
												'width'	=>  '60%'
												);
							
							$r			.= $DSP->table_row( $top );
							
		

				/**	----------------------------------------
				/**	Table contents
				/**	----------------------------------------*/
							if ($IN->GBL('row','GET') != "")
							{		
								$row_count = $IN->GBL('row','GET');
							}

							//print $IN->GBL('row','GET');

							$urls		= $DB->query("SELECT * FROM exp_url_metas WHERE url != '' AND `def` = 'NO' ORDER BY url ASC LIMIT ".$row_count.", ".$row_limit);
												
							$rows = array();
							$i = 0;
							
							foreach ( $urls->result as $row )
							{
								unset($rows);
								$rows[]					= $row['url_id'];
								$rows[]					= $DSP->anchor( BASE.AMP.'C=modules'.AMP.'M=Url_metas'.AMP.'P=edit'.AMP.'url_id='.$row['url_id'], $row['url'] );
								$rows[]					= $row['keywords'];
								$r			 			.= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $rows);
							}
							
							
							$r							.= $DSP->table_c();
		
		
		
				/** --------------------------------------------
        /**  Pagination
        /** --------------------------------------------*/
					
							if ($totalrows > $row_limit)
							{
								$row_count				= ( ! $IN->GBL('row')) ? 0 : $IN->GBL('row');
											
								$url					= BASE.AMP.'C=modules'.AMP.'M=Url_metas'.AMP.'P=view';
								
								if ( $IN->GBL('url') )
								{
									$url				.= AMP.'url_id='.$IN->GBL('url_id');
								}
								
								$r						.= $DSP->pager(
																$url,
																$totalrows, 
																$row_limit,
																$row_count,
																'row'
															);
							}
				
					}
					
			
				$DSP->body .= $r;
				return $r;	        
					
						
	    }
	    /** END **/
	    
	    
	    
	    /** ----------------------------------------
	    /**  Add URL Metas
	    /** ----------------------------------------*/
	    function default_url_metas($msg="")
	    {
	        global $DB, $IN, $DSP, $LANG;
	        
			
	        $this->url_metas_header("default_url_metas",$msg);    			
	        $DSP->crumb .= $DSP->crumb_item($LANG->line("default_url_metas")); 
	        
					$query			= $DB->query("SELECT * FROM exp_url_metas WHERE `def` = 'YES'");
	    		
//					$form_url		= 'C=modules'.AMP.'M=Freeform'.AMP.'P=update_url_metas';
        
		  		$r					= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Url_metas'.AMP.'P=update')).BR;

					$r					.= $DSP->input_hidden('url_id', $query->row['url_id'], '', '', 'input', '');
					$r					.= $DSP->input_hidden('type', 'default', '', '', 'input', '');

					$r					.= $DSP->table('tableBorder', '0', '0', '100%').
					
					$r					.= $DSP->tr();
					$r					.= $DSP->table_qcell('tableHeadingAlt', array("Field", "Value"));
					$r 					.= $DSP->tr_c();
		
					
					$style			= 'tableCellOne';
					$passedurl	= $IN->GBL('url') != "" ? $IN->GBL('url') : "";
					
					/**	----------------------------------------
					/**	Start entry id
					/**	----------------------------------------*/
							  
					$r 				.= $DSP->qdiv('tableHeading', $LANG->line("default_url_metas"));

					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "Page Title"), '40%');
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea('title', $query->row['title'], '3', '15', 'input', TRUE))), '60%');
					$r				.= $DSP->tr_c();
					
					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "Meta Title"), '40%');
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea('keywords', $query->row['keywords'], '6', '35', 'input', TRUE))), '60%');
					$r				.= $DSP->tr_c();

					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "Description"), '40%');
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea('description', $query->row['description'], '6', '15', 'input', TRUE))), '60%');
					$r				.= $DSP->tr_c();

					$r				.= $DSP->table_qcell($style, "", '40%');
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('itemWrapper', $DSP->input_submit("Save")), '60%');
					
					$r				.= $DSP->table_c();
					
					$r				.= $DSP->div_c();
					$r 				.= $DSP->form_close();
						
					$DSP->body .= $r;
					return $r;	 
	    }
	    /** END **/
	    
	    
	    
	    /** ----------------------------------------
	    /**  Add URL Metas
	    /** ----------------------------------------*/
	    function edit_url_metas($msg="")
	    {
	        global $DB, $IN, $DSP, $LANG;
	        
					$update_mode	= ( $IN->GBL('url_id') ) ? 'update': 'create';
					$_pagetitle = $update_mode == "update" ? "edit_url_metas" : "add_url_metas";
					
	        $this->url_metas_header($_pagetitle,$msg);    			
	        $DSP->crumb .= $DSP->crumb_item($LANG->line($_pagetitle)); 
	        
	        
					if ($update_mode == "update")
					{
						$query			= $DB->query("SELECT * FROM exp_url_metas WHERE url_id = '".$IN->GBL('url_id')."'");
	    		}
	    		
					$form_url		= 'C=modules'.AMP.'M=Freeform'.AMP.'P=update_url_metas';
        
		  		$r					= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Url_metas'.AMP.'P='.$update_mode)).BR;

					$r					.= $update_mode == "update" ? $DSP->input_hidden('url_id', $query->row['url_id'], '', '', 'input', '') : "";

					$r					.= $DSP->table('tableBorder', '0', '0', '100%').
					
					$r					.= $DSP->tr();
					$r					.= $DSP->table_qcell('tableHeadingAlt', array("Field", "Value"));
					$r 					.= $DSP->tr_c();
		
					
					$style			= 'tableCellOne';
					$passedurl	= $IN->GBL('url') != "" ? $IN->GBL('url') : "";
					
					/**	----------------------------------------
					/**	Start entry id
					/**	----------------------------------------*/
							  
					$r 				.= $DSP->qdiv('tableHeading', $LANG->line($_pagetitle));
//					$r				.= $DSP->div('box');
		  		
					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "URL"), '40%');
					$val			= $update_mode == "update" ? $query->row['url'] : base64_decode($passedurl);
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('url', $val, '35', '255', 'input', '55%'))), '60%');
					$r				.= $DSP->tr_c();		  		
					
					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "Page Title"), '40%');
					$val			= $update_mode == "update" ? $query->row['title'] : "";
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper',  $DSP->input_textarea('title', $val, '3', '15', 'input', TRUE))), '60%');
					$r				.= $DSP->tr_c();

					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "Meta Keywords"), '40%');
					$val			= $update_mode == "update" ? $query->row['keywords'] : "";
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea('keywords', $val, '6', '15', 'input', TRUE))), '60%');
					$r				.= $DSP->tr_c();

					$r				.= $DSP->tr();
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', "Description"), '40%');
					$val			= $update_mode == "update" ? $query->row['description'] : "";
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea('description', $val, '6', '15', 'input', TRUE))), '60%');
					$r				.= $DSP->tr_c();

					$r				.= $DSP->table_qcell($style, "", '40%');
					$r				.= $DSP->table_qcell($style, $DSP->qdiv('itemWrapper', $DSP->input_submit("Save")), '60%');
					
					$r				.= $DSP->table_c();
					
					$r				.= $DSP->div_c();
					$r 				.= $DSP->form_close();
						
					$DSP->body .= $r;
					return $r;	 
	    }
	    /** END **/
	    
	    
	    
	    /** ----------------------------------------
	    /**  Add URL Metas
	    /** ----------------------------------------*/
	    function update_url_metas($type="update")
	    {
	        global $DB, $IN, $DSP, $LANG;
	        
					$type = $IN->GBL('type') == "" ? $type : $IN->GBL('type'); 

					unset( $_POST['submit'] );
					unset( $_POST['type'] );
			        
					/**	----------------------------------------
					/**	Update
					/**	----------------------------------------*/
								
					
					
//					$row 		$DB->query();
					if ($type == "update")
					{
						$DB->query( $DB->update_string('exp_url_metas', $_POST, 'url_id='.$IN->GBL('url_id')) );
						$msg = "URL Metas Updated";
						$this->edit_url_metas($msg);
					} 
					elseif ($type == "create") 
					{
						$DB->query( $DB->insert_string('exp_url_metas', $_POST) );
						$msg = "URL Metas Added";
						$this->view_url_metas($msg);
					} 
					elseif ($type == "default") 
					{
						$DB->query( $DB->update_string('exp_url_metas', $_POST, 'url_id='.$IN->GBL('url_id')) );
						$msg = "URL Meta Defaults Updated";
						$this->default_url_metas($msg);
					}
					
	        
	        return true;
	    }
	    /** END **/


}
// END CLASS