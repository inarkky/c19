<?php
define('TITLE', 'COVID-19 Analytics');
define('ENVIRONMENT', 'dev');
define('ROOT_URI_PATH', '/'); //or if you are on xampp name of the project folder in htdocs
define('TIMEZONE', 'UTC'); 
define('SOURCE', 'https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/');
define('FORMAT', '.csv');
define('REALTIME_DATA_SOURCE', "https://www.koronavirus.hr/");

//TWITTER CREDENTIALS
define("API_KEY", "gQm44fubF10dLHBiFLlb9agIz");
define("API_KEY_SECRET", "CuwZnxnyhG5ZihpSzv2qJiyjZVoJ7Ha5OiePkumhhqNg1Hs1Qx");
define("ACCESS_TOKEN", "1247522664681369600-5y9uPVbTM9gASP6VRer3oPbuyJsFZy");
define("ACCESS_TOKEN_SECRET", "IErsgWEVrXusWCMOUNJd9GXA7iRoItvdecdiBVUailCC9");

//DB CONNECTIONS
define ('CONNECTIONS', [
    'DEFAULT' => [
        'DB_TYPE' => 'mysql',
        'DB_HOST' => '127.0.0.1',
        'DB_PORT' => '3306',
        'DB_NAME' => 'covid-19',
        'DB_USER' => 'root',
        'DB_PASS' => 'root',
        'DB_CHARSET' => 'utf8'
    ]
]);

//WEB STRUCTURE
define('URL_PROTOCOL',      '//'); //protocol independent
define('URL_DOMAIN',        $_SERVER['HTTP_HOST']);
define('URL',               URL_PROTOCOL . URL_DOMAIN);
    define('PUBLIC_FOLDER_URL', URL_PROTOCOL . URL_DOMAIN . '/public/');
    define('RESOURCES_URL',     URL_PROTOCOL . URL_DOMAIN . '/application/resources/');
        define('CSS_URL',           RESOURCES_URL . 'css/');
        define('JS_URL',            RESOURCES_URL . 'js/');
        define('PLUGINS_URL',       RESOURCES_URL . 'plugins/');
        define('ASSETS_URL',        RESOURCES_URL . 'assets/');
        define('IMAGES_URL',        RESOURCES_URL . 'images/');

//FILE STRUCTURE
define('APPLICATION_PATH',   ROOT_PATH              . 'application/');
    define('RESOURCES_PATH',    APPLICATION_PATH    . 'resources/');
        define('ASSETS_PATH',       RESOURCES_PATH  . 'assets/');
        define('IMAGES_PATH',       RESOURCES_PATH  . 'images/');
    define('LOGS_PATH',        APPLICATION_PATH     . 'storage/');
define('PUBLIC_PATH',        ROOT_PATH              . 'public/');
    define('COMPONENTS_PATH',   PUBLIC_PATH         . 'components/');
        define('HEAD',         COMPONENTS_PATH . 'head.php');
        define('HEADER',       COMPONENTS_PATH . 'header.php');
        define('FOOTER',       COMPONENTS_PATH . 'footer.php');
        define('SIDEBAR',      COMPONENTS_PATH . 'sidebar.php');
        define('JS_INCLUDES',  COMPONENTS_PATH . 'js_includes.php');
        define('CSS_INCLUDES', COMPONENTS_PATH . 'css_includes.php');