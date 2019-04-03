<?php 
/**
 * 
 * Class PHPLogController
 * 
 * Controls the request when access to php logs is requested.
 * 
 */
class PHPLogController extends Controller {

    /**
     * Return the protected view. Created within the controller itself to minimise security risks by having a public function.
     */
    private function createView(string $pathToView, array $payload) {
        if(!empty($payload)) {
            extract($payload);
        }
        ob_start();
        include(APP_ROOT."vendor/BasicMVC/views/".$pathToView.".view.php");
        return ob_get_clean();
    }

    /**
     * Function when a get request is made to this controller.
     * Will return the PHP Logs and a basic interface to interact with it.
     */
    public function get() {
        // Getting all the PHP Logs and reversing it to show the latest log.
        $pathToLogFiles = array_reverse(glob(APP_ROOT."logs/php/*.log"));
        if (!empty($pathToLogFiles)) {
            // If log is set and isnt empty set the requested variable.
            if (isset($_GET['log']) && !empty($_GET['log'])) {
                $requestedLog = APP_ROOT."logs/php/".$_GET['log'];
            }
            // If $requestedLog isset and exists then will set $logToLoad to the requestedLog
            if (isset($requestedLog) && file_exists($requestedLog)) {
                $logToLoad = $requestedLog;
            } else {
                // Else will get the latest log in the folder
                $logToLoad = $pathToLogFiles[0];
            }
            $logFileContents = nl2br(file_get_contents($logToLoad));
            // Getting the file loaded
            $logToLoadExploded = explode('/', $logToLoad);
            $logFileLoadedName = array_pop($logToLoadExploded);
        }


        // Creating the view via the protected createView function.
        return $this->createView("logs/php/index", [
            'pathToLogFiles' => $pathToLogFiles ?? [],
            'logFileContents' => $logFileContents ?? '',
            'title' => $logFileLoadedName ?? '',
            'logFileLoadedName' => $logFileLoadedName ?? ''
        ]);
        
    }

    /**
     * Function will be run when a post request has been sent to this controller via router.
     * Will return the log file contents requested.
     */
    public function post() {
        $logFileRequest = $_POST['log'] ?? null;
        $returnObj = new StdClass();
        $fullLogFileLoadPath = APP_ROOT."logs/php/".$logFileRequest;
        if ( file_exists($fullLogFileLoadPath) ) {
            $returnObj->body =  nl2br(file_get_contents($fullLogFileLoadPath));
        } else {
            $returnObj->body = "Log file $logFileRequest doesn't exist.";
        }
        return json_encode($returnObj);
    }

}

return new PHPLogController();