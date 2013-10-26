<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    if($class == 'first')
        $class_first = ' class="first"';
?> 

<div class="dates">
<h1<?=$class_first?>><?=$title?></h1>
<ul>  