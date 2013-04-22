<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>


/* ++++++++++++++++ Anzahl Einsatzkräfte Slider +++++++++++++++++++++++++++ */
/* slider root */
.slider {
    background:url(../../../images/admin/layout/small-horizontal.png) no-repeat  0 -5px;
    width:94px;
    height:5px;
    cursor:pointer;
    position: relative;
    float:left;
}

/* drag handle */
.handle {
    background:transparent url(../../../images/admin/layout/small-horizontal.png) no-repeat scroll -97px 0;
    height:13px;
    position:absolute;
    top:-5px;
    width:12px;
    cursor:move;
}

/* input field */
.range {
	font: 11px Arial, Helvetica, sans-serif;
	border: 1px solid #CCCCCC;
    background:none;
    width: 30px;
    margin:-5px 0 10px 0;
    float:left;
    color:#000;
    text-align:center;
    -moz-border-radius:2px;
    -webkit-border-radius:2px;
}

/* input field while focused */
.range:focus {
    background-color:#fff;
}

/* cute little CSS3 selector */
.range[readonly]:focus {
    background-color:transparent;
}
</style>