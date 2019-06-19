<?php 
/**
 * Router.php
 * 
 * This class will handle the routing for the application. Once the environment has been setup,
 * the runRoute() function will be called to process the request.
 */
class Router {
    protected $fullRequestURI;
    protected $path;
    protected $query;
    protected $targetFile;
    protected $dir;
    protected $requestMethod = 'get';
    protected $controller;
    protected $controllerToLoadPath;
    /**
     * Constructor, runs when a new instance is created.
     * @return void
     */
    public function __construct(string $requestURI) {
        // Getting the protectedRoutes that have been loaded.
        global $protectedRoutes;

        // Storing full request uri
        $this->fullRequestURI = $requestURI;

        // Exploding the url
        $parts = explode('/',$requestURI);
        // Getting the file targetted
        $this->targetFile = array_pop($parts);

        // Parsing the URL
        $urlParsed = parse_url($_SERVER['REQUEST_URI']);
        $this->path = ltrim($urlParsed['path'], "/");

        // Removing all instances of php extensions.
        while(preg_match("/.php$/", $this->path)) {
            $this->path = preg_replace("/.php$/", "", $this->path);
        }

        // Getting any queries if any
        $this->query = $urlParsed['query'] ?? null;

        // Getting the directory by rejoining parts (targetted file has already been removed)
        $this->dir = ltrim(join('/', $parts)."/", "/");

        // Storing the protectedRoutes
        $this->protectedRoutes = $protectedRoutes;
        
        // Checking if a alternate request_method has been assigned via a input field named _method
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            if (isset($_POST['_method'])) {
                switch(strtolower($_POST['_method'])) {
                    case 'post':
                        $this->requestMethod = 'post';
                        break;
                    case 'put':
                        $this->requestMethod = 'put';
                        break;
                    case 'update':
                        $this->requestMethod = 'update';
                        break;
                    case 'delete':
                        $this->requestMethod = 'delete';
                        break;
                    default:
                        throw new Exception("Request Method not recognised.");
                        break;
                }
            } else {
                $this->requestMethod = 'post';
            }
        }
    }

    /**
     * Will get the appropriate controller in relation to the request uri.
     */
    private function getController() {
        // Setting path to the controllers directory.
        $pathToControllerDir = APP_ROOT."controllers/";

        // If it ends with "/" then it is a directory that has been requested, 
        // if $this->dir is completely empty that means the absolute root index
        // should be shown as it is requesting the index of the site
        if(empty($this->targetFile) && empty($this->dir)) {
            $pathToController = $pathToControllerDir."index.controller.php";
        } else if (endsWith($this->path, "/")) {
            $pathToController = $pathToControllerDir.$this->dir."index.controller.php";
        } else {
            $pathToController = $pathToControllerDir.$this->path.".controller.php";
        }

        if (file_exists($pathToController)) {
            $this->controllerToLoadPath = $pathToController;
        }

        if(!isset($this->controllerToLoadPath) && FALLBACK_ROUTES == true) {
            $pathToRootControllerIndex = $pathToControllerDir."index.controller.php";
            if (file_exists($pathToRootControllerIndex)) {
                error_log("Controller ({$pathToController}) doesn't exist, falling back to root index controller /controllers/index.controller.php", 0);
                $this->controllerToLoadPath = $pathToRootControllerIndex;
            } else {
                throw new ErrorException("Controller doesn't exist and no index.controller.php created in root of /controllers.<br>Controller Requested: ($pathToController)");
            }
        }
        
    }

    /**
     * Will get a controller corresponding to the protected routes from basicmvc if the environment in config is dev
     */
    private function getProtectedController() {
        $pathToProtectedController = APP_ROOT."vendor/BasicMVC/controllers/".$this->dir."index.controller.php";
        if (file_exists($pathToProtectedController)) {
            $this->controllerToLoadPath = $pathToProtectedController;
        } else {
            throw new ErrorException("Controller ({$pathToProtectedController}) doesn't exist.");
        }
    }

    /**
     * Will run the route against the class.
     */
    public function runRoute() {

        $isProtectedRoute = false;

        // If the url starts with any of the routes in protectedRoutes.json then it will not show the logs unless in dev mode.
        // Otherwise it will show a 403 error.
        foreach($this->protectedRoutes as $pR) {
            if ( substr($this->dir, 0, strlen($pR)) == $pR ) {
                $isProtectedRoute = true;
            }
        }

        if ($isProtectedRoute) {
            $this->getProtectedController();
        } else {
            $this->getController();
        }

        // Loading the controller that has been specified to load.
        
        if (!empty($this->controllerToLoadPath)) {
            $this->controller = include $this->controllerToLoadPath;
        } else {
            return abort(404);
        }

        if ( method_exists($this->controller, $this->requestMethod) )  {
            return $this->controller->{$this->requestMethod}();
        } else {
            error_log("BadMethodCall: $this->requestMethod doesn't exist in Controller ({$this->controllerToLoadPath}). Returned 404.", 0);
            return abort(404);
        }
        
    }

    /**
     * Destructor, runs when a the instance is no longer in use;
     */
    public function __destruct() {}
}