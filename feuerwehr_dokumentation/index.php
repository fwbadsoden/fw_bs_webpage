<? include_once('header.php'); 

switch($op) {
    case 'php': include_once('general/php.php'); break;
    case 'db': include_once('general/php.php'); break;
    case 'konfiguration': include_once('general/php.php'); break;
    case 'toc': include_once('general/php.php'); break;
    case 'requirements': include_once('general/php.php'); break;
    case 'changelog': include_once('general/php.php'); break;
    case 'auth': include_once('general/php.php'); break;
    case 'debug': include_once('general/php.php'); break;
    case 'form_validation': include_once('general/php.php'); break;
    case 'image_lib': include_once('general/php.php'); break;
    case 'image_moo': include_once('general/php.php'); break;
    case 'routing': include_once('general/php.php'); break;
    case 'whence': include_once('general/php.php'); break;
    case 'date_helper': include_once('general/php.php'); break;
    case 'html_helper': include_once('general/php.php'); break;
    case 'loadcontroller_helper': include_once('general/php.php'); break;
    case 'admin': include_once('general/php.php'); break;
    case 'einsatz_admin': include_once('general/php.php'); break;
    case 'fahrzeug_admin': include_once('general/php.php'); break;
    case 'file_admin': include_once('general/php.php'); break;
    case 'maintenance': include_once('general/php.php'); break;
    case 'menue_admin': include_once('general/php.php'); break;
    case 'module_admin': include_once('general/php.php'); break;
    case 'news_admin': include_once('general/php.php'); break;
    case 'pages_admin': include_once('general/php.php'); break;
    case 'termin_admin': include_once('general/php.php'); break;
    case 'user_admin': include_once('general/php.php'); break;
    case 'einsatz': include_once('general/php.php'); break;
    case 'fahrzeug': include_once('general/php.php'); break;
    case 'frontend': include_once('general/php.php'); break;
    case 'news': include_once('general/php.php'); break;
    case 'pages': include_once('general/php.php'); break;
    case 'termin': include_once('general/php.php'); break;
    case 'admin_model': include_once('general/php.php'); break;
    case 'auth_model': include_once('general/php.php'); break;
    case 'einsatz_model': include_once('general/php.php'); break;
    case 'fahrzeug_model': include_once('general/php.php'); break;
    case 'file_model': include_once('general/php.php'); break;
    case 'maintenance_model': include_once('general/php.php'); break;
    case 'menue_model': include_once('general/php.php'); break;
    case 'module_model': include_once('general/php.php'); break;
    case 'news_model': include_once('general/php.php'); break;
    case 'pages_mocel': include_once('general/php.php'); break;
    case 'termin_model': include_once('general/php.php'); break;
    case 'user_model': include_once('general/php.php'); break;
    default: include_once('homepage.php'); break;
}
?>

<? include_once('footer.php'); ?>