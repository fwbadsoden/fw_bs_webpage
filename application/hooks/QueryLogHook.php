<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * QueryLogHook
 * 
 * @package   
 * @author Habib Pleines
 * @copyright Feuerwehr Bad Soden
 * @version 2013
 * @access public
 */
class QueryLogHook {

    /**
     * QueryLogHook::log_queries()
     * 
     * @return
     */
    function log_queries() {    
        $CI =& get_instance();
        $times = $CI->db->query_times;
        $dbs    = array();
        $output = NULL;     
        $queries = $CI->db->queries;

        if (count($queries) == 0)
        {
            $output .= "no queries\n";
        }
        else
        {
            foreach ($queries as $key=>$query)
            {
                $output .= $query . "\n";
            }
            $took = round(doubleval($times[$key]), 3);
            $output .= "===[took:{$took}]\n\n";
        }

        $CI->load->helper('file');
        if ( ! write_file(APPPATH  . "/logs/queries.log.txt", $output, 'a+'))
        {
             log_message('debug','Unable to write query the file');
        }   
    }

}
?>