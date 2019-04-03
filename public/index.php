<?php

/**
 * index.php
 * ---------
 * This is where every request will be sent to when a client attempts to contact the website.
 * BasicMVC will do routing and return the appropriate response and html output.
 */

/* Including the global autoload */
include $_SERVER['DOCUMENT_ROOT'].'/../bootstrap.php';

// Creating a new Router with the REQUEST_URI
$router = new Router($_SERVER['REQUEST_URI']);
// Run the route against the controllers and return the html content to show to the user
$htmlcontent = $router->runRoute();
// echo the content to the screen.
echo $htmlcontent;

// Exiting the script
exit();
