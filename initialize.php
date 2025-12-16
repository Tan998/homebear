<?php
$host = $_SERVER['HTTP_HOST'];

//basic
if(!defined('base_url')) define('base_url','http://localhost/homebear');
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );

if(!defined('base_logo_img_url')) define('base_logo_img_url', base_url.'/admin/uploads/company_logo/');

if(!defined('base_ttl_img_url')) define('base_ttl_img_url', base_url.'/admin/uploads/posts/title_img/');
if(!defined('base_sub_img_url')) define('base_sub_img_url', base_url.'/admin/uploads/posts/sub_img/');

if(!defined('hp_bg_img_lg')) define('hp_bg_img_lg', base_url.'/admin/uploads/HP_TopBackgroundIMG/BG_lg/');
if(!defined('hp_bg_img_sm')) define('hp_bg_img_sm', base_url.'/admin/uploads/HP_TopBackgroundIMG/BG_sm/');

//company profile img path
if(!defined('company_profile_title_img')) define('company_profile_title_img', base_url.'/admin/uploads/company_profile/title_img/1/');
if(!defined('company_profile_top_bg_img')) define('company_profile_top_bg_img', base_url.'/admin/uploads/company_profile/sub_img/1/');

//company profile VER 2 img path
if(!defined('company_profile_ver2_title_img')) define('company_profile_ver2_title_img', base_url.'/admin/uploads/company_profile_ver2/title_img/1/');
if(!defined('company_profile_ver2_top_bg_img')) define('company_profile_ver2_top_bg_img', base_url.'/admin/uploads/company_profile_ver2/sub_img/1/');

//database
if ($host === 'localhost') {
    define('DB_SERVER', 'localhost');
    define('DB_PORT', '3306');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'homebear_local');
} else {
    define('DB_SERVER', 'localhost');
    define('DB_PORT', 3308);
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'homebear_prod');
}

//mail
if(!defined('config_mail_to_gpro')) define('config_mail_to_gpro','tanclone0001@gmail.com'); //sales@mujin24.com

//captchaV3
if(!defined('captcha_site_key')) define('captcha_site_key','6LcJbxcsAAAAAFTpobPTVcS_I2tfn86M4lWPmVQc');
if(!defined('captcha_secret_key')) define('captcha_secret_key','6LcJbxcsAAAAALLyTaJOcfkMC4hxOA48gUrHmxen');
if(!defined('captcha_verifyURL')) define('captcha_verifyURL','https://www.google.com/recaptcha/api/siteverify');

//Version
if(!defined('version')) define('version','1.1.0'); // mỗi khi thay đổi file css vs js
?>