<?php
/*
 __    __                                   __       ___     __
/\ \__/\ \                                 /\ \__  /'___\ __/\ \__
\ \ ,_\ \ \___      __         ___   __  __\ \ ,_\/\ \__//\_\ \ ,_\
 \ \ \/\ \  _ `\  /'__`\      / __`\/\ \/\ \\ \ \/\ \ ,__\/\ \ \ \/
  \ \ \_\ \ \ \ \/\  __/     /\ \L\ \ \ \_\ \\ \ \_\ \ \_/\ \ \ \ \_
   \ \__\\ \_\ \_\ \____\    \ \____/\ \____/ \ \__\\ \_\  \ \_\ \__\
    \/__/ \/_/\/_/\/____/     \/___/  \/___/   \/__/ \/_/   \/_/\/__/
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Include config file
require_once PATH_THIRD . 'navee_select/config' . EXT;

/**
 * NavEE Select
 *
 * @package        NavEE Select
 * @author         The Outfit, Inc
 * @link           http://fromtheoutfit.com/navee_select
 */

class Navee_select_ft extends EE_Fieldtype
{
    var $info = array(
        'name'    => NAVEE_SELECT_NAME,
        'version' => NAVEE_SELECT_VERSION,
    );

    /**
     * Install
     *
     * @access public
     * @return array
     */

    function install()
    {
        return array();
    }

    /**
     * Replaces the template tag
     *
     * @param       $data
     * @param array $params
     * @param bool  $tagdata
     * @return string
     */
    function replace_tag($data, $params = array(), $tagdata = FALSE)
    {
        static $script_on_page = FALSE;

        // Models & Libraries
        $this->EE->load->model('navee_select_model', 'navee_sel');

        $nav_title = $this->EE->navee_sel->get_nav_title_by_id((int)$data);

        return $nav_title;
    }

    /**
     * Display Field
     *
     * @access public
     * @param $data
     * @return mixed
     */

    public function display_field($data)
    {
        // Models & Libraries
        $this->EE->load->model('navee_select_model', 'navee_sel');
        $this->EE->lang->loadfile('navee_select');
        $this->EE->load->library('table');

        // Variables
        $entry_id = $this->EE->input->get('entry_id');
        $vars     = array(
            'field_name' => $this->field_name,
            'selected' => $data,
        );
        $hidden   = array();

        if ($this->EE->navee_sel->navee_installed())
        {
            foreach ($this->settings as $k => $v)
            {
                if (substr($k, 0, 7) == 'hidden_')
                {
                    $hidden[] = $v;
                }
            }

            $navs = $this->EE->navee_sel->get_navs($hidden);


            if ($navs->num_rows() > 0)
            {
                foreach ($navs->result() as $n)
                {
                    $vars['navs'][$n->navigation_id] = $n->nav_name;
                }
            }
            return $this->EE->load->view('mod/index', $vars, TRUE);
        }
        else
        {
            return $this->EE->load->view('mod/navee_not_installed', $vars, TRUE);
        }
    }

    /**
     * Saves posted data
     *
     * @param $data
     * @return string
     */
    function save($data)
    {
        return $data;
    }

    /**
     * Displays Individual Settings
     *
     * @access public
     * @param array $data
     * @return mixed
     */

    public function display_settings($data)
    {
        // Models & Libraries
        $this->EE->load->model('navee_select_model', 'navee_sel');
        $this->EE->lang->loadfile('navee_select');
        $this->EE->load->library('table');

        // Variables
        $vars = array();

        if ($this->EE->navee_sel->navee_installed())
        {
            $navs = $this->EE->navee_sel->get_navs();

            if ($navs->num_rows() > 0)
            {
                foreach ($navs->result() as $n)
                {
                    $is_hidden      = (array_key_exists('hidden_' . $n->navigation_id, $data)) ? TRUE : FALSE;
                    $vars['navs'][] = array(
                        'id'        => $n->navigation_id,
                        'name'      => $n->nav_name,
                        'is_hidden' => $is_hidden,
                    );

                }
            }

            return $this->EE->load->view('mcp/display_settings', $vars, TRUE);
        }
        else
        {
            return $this->EE->load->view('mod/navee_not_installed', $vars, TRUE);
        }

    }

    /**
     * Saves Individual Settings
     *
     * @access public
     * @param array $data
     * @return array
     */

    function save_settings($data)
    {
        $settings = array();
        foreach ($_POST as $k => $v)
        {
            if (substr($k, 0, 7) == 'hidden_')
            {
                $settings[$k] = $v;
            }
        }
        return $settings;
    }
}

/* End of file ft.navee_select.php */
/* Location: ./system/expressionengine/third_party/navee_select/ft.navee_select.php */