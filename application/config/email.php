<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/


$config['useragent'] 	= 'FeuerwehrBadSoden';
$config['protocol'] 	= 'smtp';
$config['mailpath'] 	= '/usr/lib/sendmail';
$config['smtp_host'] 	= 'smtp.feuerwehr-bs.de';
$config['smtp_user']	= 'noreply@feuerwehr-bs.de';
$config['smtp_pass']	= 'qam5Qzp%pg6e';

$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";


/* End of file email.php */
/* Location: ./application/config/email.php */