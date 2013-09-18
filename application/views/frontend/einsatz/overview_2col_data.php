<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

<a href="<?=base_url('einsatz/'.$id)?>">
<li>
    <h2><span class="date"><?=cp_get_ger_date($datum_beginn).' '.$uhrzeit_beginn?></span> / <?=$type_name?></h2>
    <h1><?=$name?></h1>
    <p><?=$lage?></p>
</li>
</a>