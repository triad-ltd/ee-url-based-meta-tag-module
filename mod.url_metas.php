<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Url_metas
{

    public $return_data = '';
    public $tagdata = '';
    public $url = '';
    public $adminlink = '';

    public function __construct()
    {
        $this->url = ee()->uri->uri_string;
        $this->url = substr($this->url, -1) == '/' ? substr($this->url, 0, -1) : $this->url;
        $this->url = ee()->TMPL->fetch_param('url', $this->url);

        $tagdata = ee()->TMPL->tagdata;

        // fetch page specific tags if there are any
        $query = ee()->db->select('*')
            ->from('url_metas')
            ->where(['url' => $this->url])
            ->get();

        if ($query->num_rows() > 0) {
            $tagdata = ee()->TMPL->swap_var_single('meta_title', $this->cleanse($query->row('title')), $tagdata);
            $tagdata = ee()->TMPL->swap_var_single('meta_keywords', $this->cleanse($query->row('keywords')), $tagdata);
            $tagdata = ee()->TMPL->swap_var_single('meta_description', $this->cleanse($query->row('description')), $tagdata);
            $tagdata = ee()->TMPL->swap_var_single('escaped_meta_description', addslashes($query->row('description')), $tagdata);
        }

        // fetch defaults if they are set
        $query = ee()->db->select('*')
            ->from('url_metas')
            ->where(['def' => 'YES'])
            ->get();
        if ($query->num_rows() > 0) {
            $tagdata = ee()->TMPL->swap_var_single('default_meta_title', $this->cleanse($query->row('title')), $tagdata);
            $tagdata = ee()->TMPL->swap_var_single('default_meta_keywords', $this->cleanse($query->row('keywords')), $tagdata);
            $tagdata = ee()->TMPL->swap_var_single('default_meta_description', $this->cleanse($query->row('description')), $tagdata);
        }

        $this->return_data = $tagdata;
    }

    private function cleanse($str) {
        return str_replace("'",'&#39;', $str);
    }

    public function meta_admin_link()
    {
        $query = ee()->db->select('*')
            ->from('url_metas')
            ->where(['url' => $this->url])
            ->get();

        $sys_folder = ee()->config->item('cp_url');

        if ($query->num_rows < 1) {
            $query = ee()->db->select('*')->from('url_metas')->where(['def' => 'YES'])->get();
            $url = ee('CP/URL')->make('addons/settings/url_metas/add', ['u' => $this->url]);
            $adminlink = '<div class="url_meta_admin_link">
                <a href=' . $sys_folder . '/' . $url . ' target=_blank>' .
                'Add meta data for this page (currently using defaults).' .
                '</a></div>';
        } else {
            $adminlink = '<div class="url_meta_admin_link">
            <a href=' . $sys_folder . '/' . ee('CP/URL', 'addons/settings/url_metas/edit/' . $query->row('url_id')) . ' target=_blank>' .
                'Edit meta data for this page' .
                '</a></div>';
        }

        return $adminlink;
    }
}
// END CLASS
