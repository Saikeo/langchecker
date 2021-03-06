<?php
namespace Langchecker;

use Json\Json;

date_default_timezone_set('Europe/Paris');

// Server shortcuts
$root_folder        = realpath(__DIR__ . '/../../') . '/';
$app_folder         = $root_folder . 'app/';
$conf_folder        = $app_folder . 'config/';
$controllers_folder = $app_folder . 'controllers/';
$libs_folder        = $app_folder . 'libs/';
$templates_folder   = $app_folder . 'templates/';
$views_folder       = $app_folder . 'views/';

// Autoloading of composer dependencies
require_once $root_folder . 'vendor/autoload.php';

// App-wide variables
require $conf_folder . 'locales.inc.php';
require $conf_folder . 'sources.inc.php';

// Override sources for functional tests both locally and on Travis
if (getenv('AUTOMATED_TESTS')) {
    require $root_folder . 'tests/testfiles/config/sources.php';
}

// Re-usable JSON object
$json_object = new Json;

// User provided variables
$action   = Utils::getQueryParam('action');
$filename = Utils::getQueryParam('file');
$json     = Utils::getQueryParam('json', false);   // Do we want json data for the webdashboard?
$locale   = Utils::getQueryParam('locale');        // Which locale are we analysing? No default
$project  = Utils::getQueryParam('project');
$serial   = Utils::getQueryParam('serial', false); // Do we want serialize data for the webdashboard?
$website  = Utils::getQueryParam('website');       // Which website are we looking at?

// Cache class
define('CACHE_ENABLED', true);
define('CACHE_PATH', $root_folder . 'cache/');
define('CACHE_TIME', 7200);

// URL used to include web assets
if (! isset($webroot_folder)) {
    die('$webroot_folder setting is missing from app/config/settings.inc.php. Please update your settings file.');
} else {
    $assets_folder = $webroot_folder . 'assets';
}
