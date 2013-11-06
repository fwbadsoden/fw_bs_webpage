<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name: flexi auth lang - English
* 
* Author: 
* Rob Hussey
* flexiauth@haseydesign.com
* haseydesign.com/flexi-auth
*
* Released: 13/09/2012
*
* Description:
* English language file for flexi auth
*
* Requirements: PHP5 or above and Codeigniter 2.0+
*/

// Account Creation
$lang['account_creation_successful']				= 'Ihr Benutzerkonto wurde erfolgreich erstellt.';
$lang['account_creation_unsuccessful']				= 'Benutzerkonto kann nicht erstellt werden.';
$lang['account_creation_duplicate_email']			= 'Ein Konto mit dieser E-Mail-Adresse ist bereits vorhanden.'; 
$lang['account_creation_duplicate_username']		= 'Ein Konto mit diesem Benutzername existiert bereits.'; 
$lang['account_creation_duplicate_identity'] 		= 'Ein Konto mit dieser Identität ist bereits vorhanden.';
$lang['account_creation_insufficient_data']			= 'Nicht genügend Informationen, um ein Konto zu erstellen. Stellen Sie sicher, dass eine gültige Identität und ein Passwort angegeben sind.';

// Password
$lang['password_invalid']							= "Das Feld %s ist nicht korrekt gefüllt.";
$lang['password_change_successful'] 	 	 		= 'Passwort erfolgreich geändert.';
$lang['password_change_unsuccessful'] 	  	 		= 'Das angegebene Passwort stimmt nicht mit der Datenbank überein.';
$lang['password_token_invalid']  					= 'Das übermittelte Passwort-Token ist ungültig oder abgelaufen.'; 
$lang['email_new_password_successful']				= 'Ein neues Passwort wurde Ihnen per Email gesendet.';
$lang['email_forgot_password_successful']	 		= 'Eine Email zum zurücksetzen des Passworts wurde an Ihre Emailadresse gesendet.';
$lang['email_forgot_password_unsuccessful']  		= 'Das Zurücksetzen des Passworts hat leider nicht geklappt. Bitte überprüfen Sie die angegebene Emailadresse und versuchen Sie es noch einmal.'; 

// Activation
$lang['activate_successful']						= 'Account wurde aktiviert.';
$lang['activate_unsuccessful']						= 'Der Account konnte nicht aktiviert werden.';
$lang['deactivate_successful']						= 'Account wurde deaktiviert.';
$lang['deactivate_unsuccessful']					= 'Der Account konnte nicht deaktiviert werden.';
$lang['activation_email_successful'] 	 			= 'Aktivierungsemail wurde versendet.';
$lang['activation_email_unsuccessful']  	 		= 'Aktivierungsemail konnte nicht versendet werden.';
$lang['account_requires_activation'] 				= 'Ihr Account muss über den Code in der Aktivierungsemail aktiviert werden.';
$lang['account_already_activated'] 					= 'Ihr Account wurde bereits aktiviert.';
$lang['email_activation_email_successful']			= 'Zur Aktivierung der neuen Emailadresse wurde eine Email gesendet.';
$lang['email_activation_email_unsuccessful']		= 'Die Email zur Aktivierung Ihrer neuen Emailadresse konnte nicht gesendet werden.';

// Login / Logout
$lang['login_successful']							= 'Sie haben Sich erfolgreich angemeldet.';
$lang['login_unsuccessful']							= 'Die angegebenen Login-Daten sind ungültig.';
$lang['logout_successful']							= 'Sie haben Sich erfolgreich abgemeldet.';
$lang['login_details_invalid'] 						= 'Ihre Login-Daten sind ungültig.';
$lang['captcha_answer_invalid'] 					= 'CAPTCHA nicht korrekt.';
$lang['login_attempts_exceeded'] 					= 'Die maximale Anzahl an Login-Versuchen wurde überschritten. Bitte warten Sie einen Moment, bevor Sie es noch einmal probieren.';
$lang['login_session_expired']						= 'Ihre Login Session ist abgelaufen.';
$lang['account_suspended'] 							= 'Ihr Account wurde suspendiert.';

// Account Changes
$lang['update_successful']							= 'Accountdaten erfolgreich aktualisiert.';
$lang['update_unsuccessful']						= 'Accountdaten konnten nicht aktualisiert werden.';
$lang['delete_successful']							= 'Account wurde erfolgreich gelöscht.';
$lang['delete_unsuccessful']						= 'Account konnte nicht gelöscht werden.';

// Form Validation
$lang['form_validation_duplicate_identity'] 		= "Ein Account mit dieser Emailadresse/diesem Benutzernamen existiert bereits.";
$lang['form_validation_duplicate_email'] 			= "Emailadresse bereits vergeben.";
$lang['form_validation_duplicate_username'] 		= "Benutzername bereits vergeben.";
$lang['form_validation_current_password'] 			= "Das Passwort ist falsch.";

/* End of file flexi_auth_lang.php */
/* Location: ./application/language/de/flexi_auth_lang.php */