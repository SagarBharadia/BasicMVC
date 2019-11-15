<?php

/**
 * Function used to return views from the controller.
 *
 * @var $pathToView will be searched in /views/.
 * @var $payload will be the variables to pass the view. $key => $value pairs.
 */
function view(string $pathToView, array $payload = [])
{
    $view = new View($pathToView, $payload);
    $view->create();
    return $view->htmlOutput;
}

/**
 * Add a new line to the days debug file.
 *
 * @var string $message This will be the message for the line stored in the debug file.
 * @var integer $type This will be the type of the debug to be stored. 1 = BasicMVC, 2 = info, 3 = debug, 4 = log.
 * @var bool $showTrace If true, a trace will be added to the debug entry.
 */
function debug(string $message, int $type = 2, $showTrace = false)
{
    // Starting the string to be added to the debug file.
    $debugString = "[".date('Y-m-d H:i:s')."] ";
    // Adding the type of debug to the output string.
    switch ($type) {
    case 1:
        $debugString .= "[BasicMVC] ";
        break;
    case 2:
        $debugString .= "[INFO] ";
        break;
    case 3:
        $debugString .= "[DEBUG] ";
        break;
    case 4:
        $debugString .= "[LOG] ";
        break;
    default:
        $debugString .= "[INFO] ";
        break;
    }
    // Adding the message to the string
    $debugString .= $message."\n";
    // If the developer has requested the trace, then the trace will be added.
    if ($showTrace) {
        $trace = new \Exception;
        $debugString .= "Stack Trace:\n".$trace->getTraceAsString()."\n";
    }
    // Setting the debug file path.
    $debugFilePath = DEBUG_FILES_DIR.CURRENT_DEBUG_FILE;
    // Adding the string to the file.
    file_put_contents($debugFilePath, $debugString, FILE_APPEND);
}

/**
 * Kill anymore processing and return a error view.
 *
 * @var int $status is the status code to be returned.
 */
function abort(int $status)
{

    http_response_code($status);

    $pathToErrorView = "errors/".strval($status);

    if(!View::exists($pathToErrorView)) {
        error_log("Error view file for $status does not exist.", 0);
        die();
    } else {
        return view($pathToErrorView);
    }

}

/**
 * Check if a string ends with specified string, typical if $haystack ends with $needle
 *
 * @var string $haystack the string to search in
 * @var string $needle the string to compare the ending of $haystack with
 */
function endsWith($haystack, $needle)
{
    return substr($haystack, -strlen($needle))===$needle;
}