<?php if (!defined('BASEPATH')) exit('No direct script access allowed');$route["admin/content/einsatz"] = "einsatz/einsatz_admin/einsatz_liste";$route["admin/content/einsatz/(:num)"] = "einsatz/einsatz_admin/einsatz_liste/$1";$route["admin/content/einsatz/create"] = "einsatz/einsatz_admin/create_einsatz";$route["admin/content/einsatz/create/(:any)"] = "einsatz/einsatz_admin/create_einsatz/$1";$route["admin/content/einsatz/delete/(:num)"] = "einsatz/einsatz_admin/delete_einsatz/$1";$route["admin/content/einsatz/edit/(:any)"] = "einsatz/einsatz_admin/edit_einsatz/$1";$route["admin/content/einsatz/image/delete"] = "einsatz/einsatz_admin/image_delete";$route["admin/content/einsatz/image/edit/(:any)"] = "einsatz/einsatz_admin/image_uploader/$1";$route["admin/content/einsatz/status/(:num)/(:num)/(:num)"] = "einsatz/einsatz_admin/switch_online_state/$1/$2/$3";$route["admin"] = "admin/admin";$route["admin/change_pw"] = "admin/admin/change_pw_login";$route["admin/change_pw/check"] = "admin/admin/check_change_pw_login";$route["admin/check_login"] = "admin/admin/check_login";$route["admin/content"] = "admin/admin/mContent";$route["admin/edit_profile"] = "admin/admin/edit_profile";$route["admin/files"] = "admin/admin/mFiles";$route["admin/forgot_password"] = "admin/admin/forgot_password";$route["admin/logout"] = "admin/admin/logout";$route["admin/menue"] = "admin/admin/mMenue";$route["admin/menue/backend"] = "menue/menue_admin/menue_liste/backend";$route["admin/menue/delete/(:num)"] = "menue/menue_admin/delete_menue/$1";$route["admin/menue/frontend"] = "menue/menue_admin/menue_liste/frontend";$route["admin/menue/order/(:any)/(:num)"] = "menue/menue_admin/change_order/$1/$2";$route["admin/menue/status/(:num)/(:num)"] = "menue/menue_admin/switch_online_state/$1/$2";$route["admin/system"] = "admin/admin/mSystem";$route["admin/system/language"] = "module/module_admin/language_liste";$route["admin/system/route"] = "module/module_admin/route_liste";$route["admin/system/route/create"] = "module/module_admin/create_route";$route["admin/system/route/create/(:any)"] = "module/module_admin/create_route/$1";$route["admin/system/route/delete/(:num)"] = "module/module_admin/delete_route/$1";$route["admin/system/route/edit/(:any)"] = "module/module_admin/edit_route/$1";$route["admin/system/route/write"] = "module/module_admin/rewrite_routes";$route["admin/system/setting/create"] = "module/module_admin/create_setting";$route["admin/system/setting/create/(:any)"] = "module/module_admin/create_setting/$1";$route["admin/system/setting/delete/(:num)"] = "module/module_admin/delete_setting/$1";$route["admin/system/setting/edit/(:any)"] = "module/module_admin/edit_setting/$1";$route["admin/system/setting/write"] = "module/module_admin/rewrite_settings";$route["admin/system/settings"] = "module/module_admin/setting_liste";$route["admin/system/settings/(:any)"] = "module/module_admin/setting_liste/$1";$route["admin/user"] = "admin/admin/mUser";$route["admin/content/news"] = "news/news_admin/news_liste";$route["admin/content/news/(:num)"] = "news/news_admin/news_liste/$1";$route["admin/content/news/status/(:num)/(:num)/(:num)"] = "news/news_admin/switch_online_state/$1/$2/$3";$route["admin/user/backend"] = "user/user_admin/user_liste";$route["admin/user/backend/create"] = "user/user_admin/create_user";$route["admin/user/backend/create/(:any)"] = "user/user_admin/create_user/$1";$route["admin/user/backend/delete/(:num)"] = "user/user_admin/delete_user/$1";$route["admin/user/backend/edit/(:any)"] = "user/user_admin/edit_user/$1";$route["admin/user/backend/status/(:num)/(:num)"] = "user/user_admin/switch_online_state/$1/$2";$route["admin/user/frontend"] = "user/user_admin/user_liste";$route["admin/user/frontend/status/(:num)/(:num)/(:num)"] = "user/user_admin/switch_online_state/$1/$2/$3";$route["admin/content/fahrzeug"] = "fahrzeug/fahrzeug_admin/fahrzeug_liste";$route["admin/content/fahrzeug/create"] = "fahrzeug/fahrzeug_admin/create_fahrzeug";$route["admin/content/fahrzeug/create/(:any)"] = "fahrzeug/fahrzeug_admin/create_fahrzeug/$1";$route["admin/content/fahrzeug/delete/(:num)"] = "fahrzeug/fahrzeug_admin/delete_fahrzeug/$1";$route["admin/content/fahrzeug/edit/(:any)"] = "fahrzeug/fahrzeug_admin/edit_fahrzeug/$1";$route["admin/content/fahrzeug/image/delete"] = "fahrzeug/fahrzeug_admin/image_delete";$route["admin/content/fahrzeug/image/edit/(:any)"] = "fahrzeug/fahrzeug_admin/image_uploader/$1";$route["admin/content/fahrzeug/status/(:num)/(:num)"] = "fahrzeug/fahrzeug_admin/switch_online_state/$1/$2";$route["admin/content/pages"] = "pages/pages_admin/pages_liste";?>