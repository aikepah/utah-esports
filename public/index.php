<?php

date_default_timezone_set('America/Denver');
// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )));

require 'less/lessc.inc.php';

function auto_compile_less($less_fname, $css_fname) {
    // load the cache
    $cache_fname = $less_fname . ".cache";
    if (file_exists($cache_fname)) {
        $cache = unserialize(file_get_contents($cache_fname));
    } else {
        $cache = $less_fname;
    }

    $new_cache = lessc::cexecute($cache);
    if (!is_array($cache) || $new_cache['updated'] > $cache['updated']) {
        file_put_contents($cache_fname, serialize($new_cache));
        file_put_contents($css_fname, $new_cache['compiled']);
    }
}

try {
    auto_compile_less('less/global.less', 'css/global.css');
} catch (exception $ex) {
    exit('lessc fatal error:<br />' . $ex->getMessage());
}

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();