<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
	$this->load->helper('form');    
    
    $form = array(
        'id'   => 'einsatzFilter',
        'name' => 'einsatzFilter'
    );
	
	$year_options = array();
	if(isset($_POST['einsatzJahr'])) $year_selected = $_POST['einsatzJahr']; 
	else 							 $year_selected = 0;
	$year_attr = "class = 'input_dropdown' id = 'input_dropdown' onChange='this.form.submit()'";
	foreach($years as $year)
	{
		$year_options[$year] = $year;	
	}
	
	$type_options = array();
	if(isset($_POST['einsatzArt'])) $type_selected = $_POST['einsatzArt']; 
	else 							$type_selected = 0;
	$type_attr = 'class = "input_dropdown" id = "input_dropdown" onChange="this.form.submit()"';
    $type_options[0] = 'Alle Einsätze';
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
                        <?=form_dropdown('einsatzJahr', $year_options, $year_selected, $year_attr)?>
                	</div>
                    <div class="styled-select">
                        <?=form_dropdown('einsatzArt', $type_options, $type_selected, $type_attr)?>
                	</div>
                    <div><a href="#top" class="backToTop"></a></div>
                </div>
            </div>
        
        </div>