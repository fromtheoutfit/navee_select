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

if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

// config
require_once PATH_THIRD . 'navee_select/config' . EXT;

/**
 * NavEE Select Model
 *
 * @package        NavEE Select
 * @category       model
 * @author         The Outfit, Inc
 * @link           http://fromtheoutfit.com/navee_select
 * @copyright      Copyright (c) 2012 - 2014, The Outfit, Inc.
 */

class Navee_select_model
{

    public function __construct()
    {
        // ee super object
        $this->EE      =& get_instance();
        $this->site_id = $this->EE->config->item('site_id');

        // comment out the following line to enable caching
        $this->EE->db->cache_off();
    }

    /**
     * Returns an object of all available navs
     *
     * @access public
     * @param array $hidden
     * @return object
     */

    public function get_navs($hidden = array())
    {
        $this->EE->db->select('navigation_id, nav_name, nav_title');
        $this->EE->db->where('site_id', $this->site_id);

        if (sizeof($hidden) > 0)
        {
            $this->EE->db->where_not_in('navigation_id', $hidden);
        }

        $this->EE->db->order_by('nav_name', 'asc');

        return $this->EE->db->get('navee_navs');
    }

    /**
     * Returns the nav_title for a particular navigation from the navigation_id
     *
     * @access public
     * @param int $navigation_id
     * @return string
     */

    public function get_nav_title_by_id($navigation_id = 0)
    {
        $data = '';
        if ($this->navee_installed() && is_int($navigation_id) && $navigation_id > 0)
        {
            $this->EE->db->select('nav_title');
            $this->EE->db->where('site_id', $this->site_id);
            $this->EE->db->where('navigation_id', $navigation_id);
            $nav = $this->EE->db->get('navee_navs');

            if ($nav->num_rows() == 1)
            {
                $data = $nav->row()->nav_title;
            }

        }

        return $data;
    }

    /**
     * Check to see if NavEE is installed
     *
     * @access public
     * @return boolean
     */

    public function navee_installed()
    {
        $this->EE->db->where('module_name', 'Navee');
        $q = $this->EE->db->get('modules');

        if ($q->num_rows() == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


}

/* End of file navee_select_model.php */
/* Location: ./system/expressionengine/third_party/navee_select/models/navee_select_model.php */