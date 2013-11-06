<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('load_controller'))
{
    /**
     * load_controller()
     * Funktion, um in einem Controller einen weiteren Controller instanziieren zu können
     * 
     * @param mixed $controller
     * @return
     */
    function load_controller($controller)
    {
        $arr_controller = explode('/', $controller);
        if(count($arr_controller) == 2) {
            $path = $arr_controller[0].'/';
            $controller = $arr_controller[1];
        }

        require_once(FCPATH . APPPATH . 'controllers/' . $path . $controller . '.php');

        $controller = new $controller();

        return $controller;
    }
}
/* End of file load_controller_helper.php */
/* Location: ./application/helpers/load_controller_helper.php */