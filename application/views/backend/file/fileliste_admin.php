<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
?>

<div id="content">
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="<?=base_url('admin/files/upload/'.$typeID)?>" class="button_gross"><span class="button_add"><?=$btn_create?></span></a></td>
        </tr>
    </table>
</p>

<h1><?=headline?></h1>