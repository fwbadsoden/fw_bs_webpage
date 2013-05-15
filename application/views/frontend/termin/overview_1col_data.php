<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

<li>    
    <h3><span class="date"><?=cp_get_ger_date($datum).' - '.$beginn?></span> / <?=$ort?></h3>
    <h2><?=$name?></h2>
</li>