<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Crazypixls HTML Helper
 * erweitert den Standard HTML Helper von CI um wichtige Funktionen
 *
 * @package		com.cp.feuerwehr.helpers.html
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Habib Pleines
 */

// ------------------------------------------------------------------------

/**
 * Generiert Farbwechsel für Tabellenreihen
 *
 * Input color (string)
 * Returns color (string
 *
 * @access	public
 * @return	string
 */	
 
if ( ! function_exists('cp_get_color'))
{
	function cp_get_color($color)
	{
		if($color=='#E1E1E1') {
			$color='#FFFFFF';
		} else {
			$color='#E1E1E1';
		} 
		return($color);
	}
}

if (!function_exists('meta')) {

    function meta($name = '', $content = '', $type = 'name', $newline = "\n") {
        // Since we allow the data to be passes as a string, a simple array
        // or a multidimensional one, we need to do a little prepping.
        if (!is_array($name)) {
            $name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
        } else {
            // Turn single array into multidimensional
            if (isset($name['name'])) {
                $name = array($name);
            }
        }
    
        $str = '';
        foreach ($name as $meta) {
            if ((!isset($meta['type']) OR $meta['type'] == 'name')) {
                $type = 'name';
            } else if ($meta['type'] == 'equiv') {
                $type = 'http-equiv';
            } else {
                $type = $meta['type'];
            }
            $name = (!isset($meta['name'])) ? '' : $meta['name'];
            $content = (!isset($meta['content'])) ? '' : $meta['content'];
            $newline = (!isset($meta['newline'])) ? "\n" : $meta['newline'];
    
            $str .= '<meta ' . $type . '="' . $name . '" content="' . $content . '" />' . $newline;
        }
    
        return $str;
    }

}

/* End of file CP_html_helper.php */
/* Location: ./application/helpers/CP_html_helper.php */