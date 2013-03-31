<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Crazypixls Date Helper
 * erweitert den Standard Date Helper von CI um wichtige Funktionen
 *
 * @package		com.cp.feuerwehr.helpers.date
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Habib Pleines
 */

// ------------------------------------------------------------------------

/**
 * Validate english date
 * Input must be in enghlish date format to work
 *
 * Input Y-m-d
 * Returns Boolean
 *
 * @access	public
 * @return	boolean
 */	

if ( ! function_exists('cp_is_valid_date'))
{
	function cp_is_valid_date($date, $format = 'DD.MM.YYYY')
	{
		if(strlen($date) >= 8 && strlen($date) <= 10)
		{
	        $separator_only = str_replace(array('M','D','Y'),'', $format);
	        $separator = $separator_only[0];
	        if($separator)
	        {
	            $regexp = str_replace($separator, "\\" . $separator, $format);
	            $regexp = str_replace('MM', '(0[1-9]|1[0-2])', $regexp);
	            $regexp = str_replace('M', '(0?[1-9]|1[0-2])', $regexp);
	            $regexp = str_replace('DD', '(0[1-9]|[1-2][0-9]|3[0-1])', $regexp);
	            $regexp = str_replace('D', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
	            $regexp = str_replace('YYYY', '\d{4}', $regexp);
	            $regexp = str_replace('YY', '\d{2}', $regexp);
	            if($regexp != $date && preg_match('/'.$regexp.'$/', $date)){
	                foreach (array_combine(explode($separator,$format), explode($separator,$date)) as $key=>$value) {
	                    if ($key == 'YY') $year = '20'.$value;
	                    if ($key == 'YYYY') $year = $value;
	                    if ($key[0] == 'M') $month = $value;
	                    if ($key[0] == 'D') $day = $value;
	                }
	                if (checkdate($month,$day,$year)) return true;
	            }
	        }
	    }
    	return false;        	
	}
}

/**
 * Validate time
 *
 * Input H:i:s
 * Returns Boolean
 *
 * @access	public
 * @return	boolean
 */	

if ( ! function_exists('cp_is_valid_time'))
{
	function cp_is_valid_time($time)
	{
		$arr = explode(":",$time);     // splitting the array
        if($arr[0] >= 0 || $arr[0] < 24 || $arr[1] >= 0 || $arr[1] < 60 || $arr[2] >= 0 || $arr[2] < 60)
        	return true;
        else return false;
	}
}

/**
 * Transform german to english datetime
 *
 * Input d.m.Y H:i:s
 * Returns Y-m-d H:i:s
 *
 * @access	public
 * @return	datetime
 */	
 
if ( ! function_exists('cp_get_eng_datetime'))
{
	function cp_get_eng_datetime($date)
	{
		if($date != null)
		{
			$var=explode(" ", $date); 
			$var2=explode(".", $var[0]); 
			$date=$var2[2]."-".$var2[1]."-".$var2[0]." ".$var[1];"error";
			return($date);
		} else return "";
	}
}
 
/**
 * Transform german to english date
 *
 * Input d.m.Y
 * Returns Y-m-d
 *
 * @access	public
 * @return	datetime
 */	
 
if ( ! function_exists('cp_get_eng_date'))
{
	function cp_get_eng_date($date)
	{
		if($date != null)
		{
			$var=explode(".", $date); 
			$date=$var[2]."-".$var[1]."-".$var[0];
			return $date;
		} else return "";
	}
} 
 
/**
 * Transform english to german datetime
 *
 * Input Y-m-d H:i:s
 * Returns d.m.Y H:i:s
 *
 * @access	public
 * @return	datetime
 */
 
if ( ! function_exists('cp_get_ger_datetime'))
{
	function cp_get_ger_datetime($date)
	{
		if($date != null)
		{
			$a = explode(" ", $date);
			$date = cp_get_ger_date($a[0]);
			return $date." ".$a[1];
		} else return "";
	}
}
	 
/**
 * Transform english to german date
 *
 * Input Y-m-d 
 * Returns d.m.Y
 *
 * @access	public
 * @return	datetime
 */
 
if ( ! function_exists('cp_get_ger_date'))
{
	function cp_get_ger_date($date)
	{
		if($date != null)
		{
			$a = explode("-", $date);
			return "".$a[2].".".$a[1].".".$a[0]."";
		} else return "";
	}
}

if ( ! function_exists('cp_get_year'))
{
	function cp_get_year($date)
	{
		if(strpos($date, '-') == 5)
			return substr($date, 0, 4);
		else
			return substr($date, 6, 4);
	}
}
?>