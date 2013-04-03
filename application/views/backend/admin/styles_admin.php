<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
	<!-- Admin Dashboard Sortierung Styles -->
	.dashboard_column_1 {
		width:32%;
		margin-right:.5%;
		float:left;
	        min-height: 300px;
	}
	.dashboard_column_1 .dashboard_dragbox {
		margin:5px;
		background:#fff;
		position:relative;
		border:1px solid #ddd;
	}
	.dashboard_column_1 .dashboard_dragbox h2 {
		margin:0;
		font-size:12px;
		padding:5px;
		background:#f0f0f0;
		color:#000;
		border-bottom:1px solid #eee;
		font-family:Verdana;
		cursor:move;
	}
	.dashboard_column_2 {
		width:32%;
		margin-right:.5%;
		float:left;
	        min-height: 300px;
	}
	.dashboard_column_2 .dashboard_dragbox {
		margin:5px;
		background:#fff;
		position:relative;
		border:1px solid #ddd;
	}
	.dashboard_column_2 .dashboard_dragbox h2 {
		margin:0;
		font-size:12px;
		padding:5px;
		background:#f0f0f0;
		color:#000;
		border-bottom:1px solid #eee;
		font-family:Verdana;
		cursor:move;
	}
	.dashboard_column_3 {
		width:32%;
		margin-right:.5%;
		float:left;
	        min-height: 300px;
	}
	.dashboard_column_3 .dashboard_dragbox {
		margin:5px;
		background:#fff;
		position:relative;
		border:1px solid #ddd;
	}
	.dashboard_column_3 .dashboard_dragbox h2 {
		margin:0;
		font-size:12px;
		padding:5px;
		background:#f0f0f0;
		color:#000;
		border-bottom:1px solid #eee;
		font-family:Verdana;
		cursor:move;
	}
	.dashboard_dragbox-content{
		background:#fff;
		margin:5px;
		font-family:'Lucida Grande', Verdana; font-size:0.8em; line-height:1.5em;
	}
	.dashboard_column  .dashboard_placeholder{
		background: #f0f0f0;
		border:2px dashed #883533;
	        min-height: 300px;
	}
	
	#content h2.welcomeHead { border-bottom: 1px solid #BDB5A7; width: 350px; }
	#content div.taskHeader { border-bottom: 1px solid #BDB5A7; width: 350px; }
	#content table.taskHead { margin: 0; padding: 0; height: 20px; }
	#content div.adminTask 	{ width: 350px; float:left; }
	#content div.adminTask2 { width: 350px; float:left; margin-left: 20px; }
	#content div.adminTask3 { width: 350px; float:left; margin-left: 20px; }
				
	#content #task { margin-bottom: 1px; margin-top: 1px; padding:5px; }
	#content #task h2 { color: #000000; width: 350px; font: 14px Arial, Helvetica, sans-serif; font-weight: bold; margin-top: 0px; padding-top: 0px; }
	#content #task h2 a { color: #000000; width: 350px; font: 14px Arial, Helvetica, sans-serif; font-weight: bold; margin-top: 0px; padding-top: 0px; }
	#content #task h3 { color: #000000; width: 350px; font: 11px Arial, Helvetica, sans-serif; font-weight: normal; margin-bottom: 0px; padding-top: 0px; }
	#content .logfile_view { font: 10px Arial, Helvetica, sans-serif; color: #000000; }
	
</style>