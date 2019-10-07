<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use EllisLab\ExpressionEngine\Library\CP\Table;

/**
 * URL Metas
 *
 * @package             Url metas for EE3
 * @author              Stephen Sweetland <stephen@triad.uk.com>
 * @copyright           Copyright (c) 2016 Triad Ltd
 * @link                http://triad.uk.com
 */

class Url_metas_mcp
{

    public $version = URL_METAS_VERSION;
    private $vals = array('url_id' => null,
        'url' => '',
        'disable_url' => false,
        'delete' => false,
        'def' => '',
        'title' => '',
        'keywords' => '',
        'description' => '');

    private $error_msg;
    private $base_url;
    private $url_id;
    private $delete = false;

    /** ----------------------------------------
    /**  Module Setup
    /** ----------------------------------------*/
    public function __construct($switch = true)
    {
        ee()->load->helper('form');
        $this->base_url = ee('CP/URL', 'addons/settings/url_metas');

        $url = ee('CP/URL')->getCurrentUrl();
        $segments = explode('/', $url->path);
        $this->url_id = @$segments[5] ? $segments[5] : '';
    }
    /** END **/

    /** ----------------------------------------
    /**  Module Homepage
    /** ----------------------------------------*/
    public function index()
    {
        $table = ee('CP/Table', ['autosort' => true, 'autosearch' => true, 'limit' => 0]);
        $table->setColumns([
            'URL',
            'Title',
            'manage' => [
                'type' => Table::COL_TOOLBAR,
            ],
        ]);
        $table->setNoResultsText('no_entries', 'add_url_metas', ee('CP/URL', 'addons/settings/url_metas/add'));

        $rows = ee()->db->select('url_id,url,title')->from('url_metas')->where('def', 'NO')->get()->result_array();
        $urls = [];
        foreach ($rows as $row) {
            $urls[] = [
                // the extra white space makes 'Homepage' the first listed item
                'url' => empty($row['url']) ? ' Homepage' : substr($row['url'], 0, 70),
                'title' => $row['title'],
                'toolbar' => [
                    'toolbar_items' => [
                        'edit' => [
                            'href' => ee('CP/URL', 'addons/settings/url_metas/edit/' . $row['url_id']),
                            'title' => lang('edit'),
                        ],
                        'remove' => [
                            'href' => ee('CP/URL', 'addons/settings/url_metas/delete/' . $row['url_id']),
                            'title' => lang('edit'),
                        ],
                    ],
                ],
            ];
        }
        $table->setData($urls);
        $vars['table'] = $table->viewData(ee('CP/URL', 'addons/settings/url_metas'));

        return $this->output($vars, lang('url_metas_list'), 'table');
    }
    /** END **/

    /** ----------------------------------------
    /**  Add URL Metas
    /** ----------------------------------------*/
    public function add()
    {
        $this->vals['def'] = 'NO';
        $this->vals['url'] = !empty($_GET['url']) ? $_GET['url'] : '';

        return $this->metas_form(lang('add_url_metas'));
    }
    /** END **/

    /** ----------------------------------------
    /**  Default URL Metas
    /** ----------------------------------------*/
    public function default_metas()
    {
        $row = ee()->db->select('url_id')->from('url_metas')->where('def', 'YES')->get()->row_array();

        return $this->edit($row['url_id']);
    }
    /** END **/

    /** ----------------------------------------
    /**  Edit URL Metas
    /** ----------------------------------------*/
    public function edit($url_id = false)
    {
        $url_id = $url_id ? $url_id : $this->url_id;
        $row = ee()->db->select('*')->from('url_metas')->where('url_id', $url_id)->get()->row_array();

        $form_heading = $row['def'] == 'NO' ? lang('edit_url_metas') : lang('set_default_url_metas');

        $this->vals['def'] = $row['def'];
        $this->vals['url_id'] = $row['url_id'];
        $this->vals['url'] = $row['url'];
        $this->vals['def'] = $row['def'];
        $this->vals['title'] = $row['title'];
        $this->vals['keywords'] = $row['keywords'];
        $this->vals['description'] = $row['description'];
        $this->vals['disable_url'] = true;

        return $this->metas_form($form_heading);
    }
    /** END **/

    /** ----------------------------------------
    /**  Save URL Metas
    /** ----------------------------------------*/
    public function save()
    {
        $data = array();
        $data['url'] = ee()->input->get_post('url');
        $data['title'] = ee()->input->get_post('title');
        $data['keywords'] = ee()->input->get_post('keywords');
        $data['description'] = ee()->input->get_post('description');

        if ($_POST['url_id'] == '') {
            if (ee()->db->insert('url_metas', $data)) {
                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas')->setQueryStringVariable('s', 1));
            } else {
                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas')->setQueryStringVariable('es', 1));
            }
        } else {
            ee()->db->where('url_id', ee()->input->get_post('url_id'));
            if (ee()->db->update('url_metas', $data)) {
                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas')->setQueryStringVariable('s', 1));
            } else {
                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas')->setQueryStringVariable('es', 1));
            }
        }

    }
    /** END **/

    /** ----------------------------------------
    /**  Add URL Metas
    /** ----------------------------------------*/
    public function delete()
    {
        $row = ee()->db->select('*')->from('url_metas')->where('url_id', $this->url_id)->get()->row_array();

        $this->vals['def'] = $row['def'];
        $this->vals['url_id'] = $row['url_id'];
        $this->vals['url'] = $row['url'];
        $this->vals['def'] = $row['def'];
        $this->vals['title'] = $row['title'];
        $this->vals['keywords'] = $row['keywords'];
        $this->vals['description'] = $row['description'];
        $this->vals['disable_url'] = true;
        $this->delete = true;

        return $this->metas_form(lang('delete_url_metas'));
    }
    /** END **/

    /** ----------------------------------------
    /**  Save URL Metas
    /** ----------------------------------------*/
    public function confirm_delete()
    {
        if ($_POST['url_id'] == '') {
            ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas'));
        } else {
            ee()->db->where('url_id', ee()->input->get_post('url_id'));
            if (ee()->db->delete('url_metas')) {
                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas')->setQueryStringVariable('d', 1));
            } else {
                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/url_metas')->setQueryStringVariable('ed', 1));
            }
        }

    }
    /** END **/

    /** ----------------------------------------
    /**  Output for Control Panel
    /** ----------------------------------------*/
    public function metas_form($heading)
    {
        $view = 'form';

        $vars['sections'] = array(
            array(
                array(
                    'title' => 'form_url',
                    'fields' => array(
                        'url' => array(
                            'type' => 'text',
                            'value' => $this->vals['url'],
                            'required' => false,
                            'attrs' => $this->vals['disable_url'] | $this->delete ? ' readonly' : '',
                        ),
                        'def' => array(
                            'type' => 'hidden',
                            'value' => $this->vals['def'],
                        ),
                        'url_id' => array(
                            'type' => 'hidden',
                            'value' => $this->vals['url_id'],
                        ),
                    ),
                ),
                array(
                    'title' => 'form_title',
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'value' => $this->vals['title'],
                            'required' => false,
                            'attrs' => $this->delete ? ' readonly' : '',
                        ),
                    ),
                ),
                array(
                    'title' => 'form_keywords',
                    'fields' => array(
                        'keywords' => array(
                            'type' => 'text',
                            'value' => $this->vals['keywords'],
                            'required' => false,
                            'attrs' => $this->delete ? ' readonly' : '',
                        ),
                    ),
                ),
                array(
                    'title' => 'form_description',
                    'fields' => array(
                        'description' => array(
                            'type' => 'textarea',
                            'value' => $this->vals['description'],
                            'required' => false,
                            'attrs' => $this->delete ? ' readonly' : '',
                        ),
                    ),
                ),
            ),
        );

        // Final view variables we need to render the form
        $vars += array(
            'base_url' => !$this->delete ? ee('CP/URL', 'cp/addons/settings/url_metas/save') :
            ee('CP/URL', 'cp/addons/settings/url_metas/confirm_delete'),
            'cp_page_title' => $heading,
            'save_btn_text' => !$this->delete ? 'save_url_metas' : 'delete_url_metas',
            'save_btn_text_working' => !$this->delete ? 'saving_msg' : 'deleting_msg',
            'alerts_name' => 'url_metas_settings',
        );

        return $this->output($vars, $heading, $view);
    }
    /** END **/

    /** ----------------------------------------
    /**  Output for Control Panel
    /** ----------------------------------------*/
    private function output($vars, $heading, $view)
    {
        // do the output.
        return array(
            'body' => ee('View')->make('url_metas:' . $view)->render($vars),
            'breadcrumb' => array(ee('CP/URL')->make('addons/settings/url_metas')->compile() => lang('module_name')),
            'heading' => $heading,
        );
    }
    /** END **/
}
// END CLASS
