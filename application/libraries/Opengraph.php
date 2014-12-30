<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Opengraph
 *
 * Library zum Zugriff auf die Open Graph API
 *
 * @package		com.cp.feuerwehr.libraries.opengraph
 * @subpackage	Library
 * @category	Library
 * @author		Habib Pleines
 */	

class Opengraph {
    
    public function create_ogImage($image) {
        return $this->create_metaProperty("og:image", base_url($image));
    }
    
    public function create_metaProperty($name, $value) {
        $meta["property"] = $name;
        $meta["content"] = $value;
        return $meta;
    }
}

/* End of file Opengraph.php */
/* Location: ./application/libraries/Opengraph.php */