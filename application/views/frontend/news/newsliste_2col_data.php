<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 

<li>
    <a href="<?=base_url('aktuelles/news/'.$id)?>">
    <h2><span class="date"><?=cp_get_ger_date($valid_from)?></span></h2>
    <h1><?=$title?></h1>
    <p><?=$teaser?></p>
</li>
</a>