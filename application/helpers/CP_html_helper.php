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
/* End of file CP_html_helper.php */
/* Location: ./application/helpers/CP_html_helper.php */