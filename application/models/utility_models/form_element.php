<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class FormElement {
        public $id, $name, $value, $class, $checked, $optional, $label;
        public $list = array();
        
        public function __construct() {
            
        }
    }

/* End of file form_element.php */
/* Location: ./application/models/utility_models/form_element.php */