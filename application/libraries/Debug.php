<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Debug {
    public function dump($var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}   

/* End of file Debug.php */
/* Location: ./application/libraries/Debug.php */