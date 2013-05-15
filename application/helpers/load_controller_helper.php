<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('load_controller'))
{
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