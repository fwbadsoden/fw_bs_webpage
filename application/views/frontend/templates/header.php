<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $this->load->helper('form');
    
    $search_form = array(
        'id'    => 'search',
        'name'  => 'search'
    );   
    $search_input = array(
        'id'    => 'searchitem',
        'name'  => 'searchitem',
        'class' => 'text'
    );
    $meta = array(
        array('name' => 'keywords', 'content' => 'feuerwehr-bs.de, Feuerwehr, Freiwillige Feuerwehr, Bad Soden'),
        array('name' => 'description', 'content' => 'Alle Infos rund um die freiwillige Feuerwehr der Stadt Bad Soden am Taunus'),
        array('name' => 'page-topic', 'content' => 'feuerwehr-bs.de - Freiwillige Feuerwehr der Stadt Bad Soden am Taunus'),
        array('name' => 'revisit-after', 'content' => '1 days'),
        array('name' => 'language', 'content' => 'de'),
        array('name' => 'copyright', 'content' => 'feuerwehr-bs.de'),
        array('name' => 'author', 'content' => 'info[at]feuerwehr-bs.de'),
        array('name' => 'publisher', 'content' => 'Freiwillige Feuerwehr Bad Soden am Taunus'),
        array('name' => 'audience', 'content' => 'Alle'),
        array('name' => 'expires', 'content' => 'never'),
        array('name' => 'page-type', 'content' => 'Portal'),
        array('name' => 'robots', 'content' => 'INDEX,FOLLOW'),
        array('name' => 'rating', 'content' => 'General'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
        array('name' => 'viewport', 'content' => 'width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;'),
        array('name' => 'X-UA-Compatible', 'content' => 'edge'),
        array('name' => 'imagetoolbar', 'content' => 'no', 'type' => 'equiv')
    );
    echo doctype('html5');
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-de" lang="de-de">
<head>
<title><?=$title?></title>
<?=meta($meta)?>	
<link rel="shortcut icon" href="<?=base_url('images/favicon.ico')?>" type="image/x-icon" />
<link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?=base_url('css/frontend/styles.css')?>" type="text/css" />

<!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="<?=base_url('js/respond.js')?>"></script>
<![endif]-->
     <!--[if IE 7]>
    	<link rel="stylesheet" type="text/css" href="<?=base_url('css/frontend/styles_ie7.css')?>"/>
     <![endif]-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<header id="top">
	<div class="site">
    	<h1>
        	<a href="/" title="Home"><?=$title?></a>
        </h1>
        <div class="navBox">  
            <div class="metanavigation"> 
                <ul>
     <?  foreach($menue_meta as $key => $item) {     
            if($key == 0) echo '<li class="first">'; else echo '<li>';    
            echo'<a href="'.$item['link'].'" target="'.$item['target'].'">'.$item['name'].'</a></li>';
        } ?>
                </ul>
            </div>
            <nav> 
                <ul>
<?  foreach($menue as $item) { ?>            
                    <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<? } ?> 
                    <li><a href="#" class="desktopsearch">Suche</a></li>
                </ul>
                <div id="searchBox">
                    <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                        <?=form_input($search_input);?>
                        <input type="submit" value="Go" class="button_black" />
                        <a href="#" class="closeSearch">x</a>
                    </form>
            		
                </div>
            </nav>
            <div class="mobileHeader">
            	<a href="#"><img src="<?=base_url('images/layout/nav_mobileButton.png')?>" width="18" height="18" id="mobileNavButton" /></a>
            </div>
        </div>
    </div>
</header>

<div id="mobileNavigation">    
   <ul class="mobileMainNavContainer">
<?  foreach($menue as $item) { ?>            
        <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
<?  } ?> 
        <li class="metanav">
          	<ul>
     <?  foreach($menue_meta as $key => $item) { ?>  
                <li><a href="<?=$item['link']?>" target="<?=$item['target']?>"><?=$item['name']?></a></li>
     <?  } ?>            
            </ul>
        </li>
        <li class="search">
            <?=form_open(base_url(FRONTEND_SEARCH_LINK), $search_form);?>
                <?=form_input($search_input);?>
                <input type="button" value="Go" class="button_black" />
            </form>
        </li>
   </ul>
</div>