<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
	$this->load->helper('form');    
    
    $form = array(
        'id'   => 'einsatzFilter',
        'name' => 'einsatzFilter'
    );
	
	$year_options = array();
	$year_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($years as $key => $year)
	{
		$year_options[$key] = $year;	
	}
	
	$type_options = array();
	$type_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($types as $type)
	{
		$type_options[$type['typeID']] = $type['typeName'];	
	}    
?> 

        <div class="oneColumnBox" id="submenue">
        
        	<div class="filter">
            	<div class="filterBox" id="einsatzJahr">
                <?=form_open(current_url(), $form);?>
                    <div class="styled-select">
                        <?=form_dropdown('einsatzJahr', $year_options, 0, $year_attr)?>
                	</div>
                    <div class="styled-select">
                        <?=form_dropdown('einsatzArt', $type_options, 0, $type_attr)?>
                	</div>
                    <div><a href="#top" class="backToTop"></a></div>
                </div>
            </div>
        
        </div>