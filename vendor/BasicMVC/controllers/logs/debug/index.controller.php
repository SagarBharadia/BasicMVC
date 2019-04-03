<?php 
/**
 * 
 * Class PHPDebugController
 * 
 * Controls the request when access to php debug logs is requested.
 * 
 * The debug files can be manipulated via the basicmvc_debug() function which will emulate error_logs
 * behaviour but allows the developer to incorporate their own without triggering php
 * to break.
 * 
 */
class PHPDebugController extends Controller {

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
     * Will return the PHP Debug and a basic interface to interact with it.
     */
    public function get() {
        // Getting all the PHP Debugs and reversing it to show the latest log.
        $pathToDebugFiles = array_reverse(glob(DEBUG_FILES_DIR."*.debug"));
        if (!empty($pathToDebugFiles)) {
            // If debug is set and isnt empty set the requested variable.
            if (isset($_GET['debug']) && !empty($_GET['debug'])) {
                $requestedDebug = APP_ROOT."logs/debug/".$_GET['debug'];
            }
            // If $requestedDebug isset and exists then will set $debugToLoad to the requestedLog
            if (isset($requestedDebug) && file_exists($requestedDebug)) {
                $debugToLoad = $requestedDebug;
            } else {
                // Else will get the latest debug in the folder
                $debugToLoad = $pathToDebugFiles[0];
            }
    
            $debugFileContents = nl2br(file_get_contents($debugToLoad));
    
            // Getting the file loaded
            $debugToLoadExploded = explode('/', $debugToLoad);
            $debugFileLoadedName = array_pop($debugToLoadExploded);
        }


        // Creating the view via the protected createView function.
        return $this->createView("logs/debug/index", [
            'pathToDebugFiles' => $pathToDebugFiles ?? [],
            'debugFileContents' => $debugFileContents ?? '',
            'title' => $debugFileLoadedName ?? '',
            'debugFileLoadedName' => $debugFileLoadedName ?? ''
        ]);
        
    }

    /**
     * Function will be run when a post request has been sent to this controller via router.
     * Will return the log file contents requested.
     */
    public function post() {
        $debugFileRequest = $_POST['debug'] ?? null;
        $returnObj = new StdClass();
        $fullDebugFileLoadPath = APP_ROOT."logs/debug/".$debugFileRequest;
        if ( file_exists($fullDebugFileLoadPath) ) {
            $returnObj->body =  nl2br(file_get_contents($fullDebugFileLoadPath));
        } else {
            $returnObj->body = "Debug file $debugFileRequest doesn't exist.";
        }
        return json_encode($returnObj);
    }

}

return new PHPDebugController();