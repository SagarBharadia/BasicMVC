<?php

// Sets include path from outside document_root
define('APP_ROOT', $_SERVER['DOCUMENT_ROOT'].'/../');

/* Loading config.json which contains all the settings for the site. */
$config = json_decode(file_get_contents(APP_ROOT.'/config.json'));

/* Defining constant database variables for environment. */
foreach( $config->database as $key => $value) {
    define($key, $value);
}

// Getting applications environment
define('APP_ENV', $config->env);

// Setting error handling settings
ini_set('display_errors', false);
if(APP_ENV == 'dev') { ini_set('display_errors', true);
}
ini_set('log_errors', true);
ini_set('error_log', APP_ROOT.'logs/php/'.date("d-m-y").'.log');

// Setting debug handling settings
define('DEBUG_FILES_DIR', APP_ROOT.'logs/debug/');
define('CURRENT_DEBUG_FILE', date("d-m-y").'.debug');

// Getting if fallback routes is active or not
define('FALLBACK_ROUTES', $config->fallbackRoutes);

/* Namespaces and files to load from BasicMVC. */
$BMVCConfig = json_decode(file_get_contents(__DIR__.'/BMVCConfig.json'));

/* Loading BasicMVC protected routes. */
$protectedRoutes = $BMVCConfig->protectedRoutes;

/* Assigning required files and dir of BasicMVC */
$reqBasicMVCDir = $BMVCConfig->requiredFilesAndDir->namespaces;
$reqBasicMVCFiles = $BMVCConfig->requiredFilesAndDir->files;

/* Loops over the required files in the basicmvcconfig.json and loads the file */
foreach ($reqBasicMVCFiles as $file) {
    $pathToFile = __DIR__.$file;
    if (file_exists($pathToFile)) {
        if (!is_dir($pathToFile)) {
            $fileInfo = pathinfo($pathToFile);
            if($fileInfo['extension'] == "php") {
                include_once $pathToFile;
            }
        }
    }
}

/* Loops over the required namespaces in the basicmvcconfig.json and loads the namespace */
foreach ( $reqBasicMVCDir as $namespace ) {
    $dir = __DIR__.$namespace;
    if (file_exists($dir)) {
        if ($files = scandir($dir)) {
            foreach( $files as $file ) {
                if (!is_dir($file)) {
                    $fileInfo = pathinfo($dir.$file);
                    if($fileInfo['extension'] == "php") {
                        include_once $dir.$file;
                    }
                }
            }
        }
    }  
}

/* Loading files from the lib_php directory */
if(is_dir(APP_ROOT."lib_php/")) {
    if($files = scandir(APP_ROOT."lib_php/")) {
        foreach ($files as $file) {
            $filePath = APP_ROOT."lib_php/".$file;
            if (!is_dir($filePath)) {
                $fileInfo = pathinfo($filePath);
                if($fileInfo['extension'] == "php") {
                    include_once $filePath;
                }
            }
        }
    }
}
