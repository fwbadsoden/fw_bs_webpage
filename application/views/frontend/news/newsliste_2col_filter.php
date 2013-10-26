<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
	$this->load->helper('form');    
    
    $form = array(
        'id'   => 'newsFilter',
        'name' => 'newsFilter'
    );
	
	$category_options = array();
	if(isset($_POST['newsArt']))    $category_selected = $_POST['newsArt']; 
	else 							$category_selected = 0;
	$category_attr = 'class = "input_dropdown" id = "input_dropdown" onChange="this.form.submit()"';
    $category_options[0] = 'Alle News';
	foreach($categories as $category)
	{
		$category_options[$category['categoryID']] = $category['title'];	
	}    
?> 

        <div class="oneColumnBox" id="submenue">
        
        	<div class="filter">
            	<div class="filterBox" id="newsJahr">
                <?=form_open(current_url(), $form);?>
                    <div class="styled-select">
                        <?=form_dropdown('newsArt', $category_options, $category_selected, $category_attr)?>
                	</div>
                    <div><a href="#top" class="backToTop" rel="nicescrolling"></a></div>
	                <hr class="clear" />
                </div>
            </div>
        
        </div>
        <div class="jsplatzhalter"></div>