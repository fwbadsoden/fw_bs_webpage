<? include_once('header.php'); 

switch($_GET['op']) {
    case 'php': include_once('general/php.php'); break;
    case 'db': include_once('general/db.php'); break;
    case 'konfiguration': include_once('general/configuration.php'); break;
    case 'requirements': include_once('general/requirements.php'); break;
    case 'changelog': include_once('general/changelog.php'); break;
    case 'auth': include_once('libraries/auth.php'); break;
    case 'debug': include_once('libraries/debug.php'); break;
    case 'form_validation': include_once('libraries/form_validation.php'); break;
    case 'image_lib': include_once('libraries/image_lib.php'); break;
    case 'image_moo': include_once('libraries/image_moo.php'); break;
    case 'routing': include_once('libraries/routing.php'); break;
    case 'weather': include_once('libraries/weather.php'); break;
    case 'whence': include_once('libraries/whence.php'); break;
    case 'date_helper': include_once('helper/date_helper.php'); break;
    case 'html_helper': include_once('helper/html_helper.php'); break;
    case 'loadcontroller_helper': include_once('helper/loadcontroller_helper.php'); break;
    case 'admin': include_once('controller/admin.php'); break;
    case 'einsatz_admin': include_once('controller/einsatz_admin.php'); break;
    case 'fahrzeug_admin': include_once('controller/fahrzeug_admin.php'); break;
    case 'file_admin': include_once('controller/file_admin.php'); break;
    case 'maintenance': include_once('controller/maintenance.php'); break;
    case 'menue_admin': include_once('controller/menue_admin.php'); break;
    case 'module_admin': include_once('controller/module_admin.php'); break;
    case 'news_admin': include_once('controller/news_admin.php'); break;
    case 'pages_admin': include_once('controller/pages_admin.php'); break;
    case 'termin_admin': include_once('controller/termin_admin.php'); break;
    case 'user_admin': include_once('controller/user_admin.php'); break;
    case 'einsatz': include_once('controller/einsatz.php'); break;
    case 'fahrzeug': include_once('controller/fahrzeug.php'); break;
    case 'frontend': include_once('controller/frontend.php'); break;
    case 'news': include_once('controller/news.php'); break;
    case 'pages': include_once('controller/pages.php'); break;
    case 'termin': include_once('controller/termin.php'); break;
    case 'admin_model': include_once('models/admin_model.php'); break;
    case 'auth_model': include_once('models/auth_model.php'); break;
    case 'einsatz_model': include_once('models/einsatz_model.php'); break;
    case 'fahrzeug_model': include_once('models/fahrzeug_model.php'); break;
    case 'file_model': include_once('models/file_model.php'); break;
    case 'maintenance_model': include_once('models/maintenance_model.php'); break;
    case 'menue_model': include_once('models/menue_model.php'); break;
    case 'module_model': include_once('models/module_model.php'); break;
    case 'news_model': include_once('models/news_model.php'); break;
    case 'pages_model': include_once('models/pages_model.php'); break;
    case 'termin_model': include_once('models/termin_model.php'); break;
    case 'user_model': include_once('models/user_model.php'); break;
    default: include_once('general/homepage.php'); break;
}
?>

<? include_once('footer.php'); ?>