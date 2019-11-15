<?php
/**
 * View.php
 * --------
 * Model to create views from the controller.
 * 
 * @package BasicMVC
 * @author  Sagar Bharadia
 * @version 1.0
 */
class View
{
    /* Protected variables to be initiated with each instance. */
    protected $pathToView;
    protected $payload;
    public $htmlOutput;

    /**
     * Constructor, will be run when a new instance of View is created.
     *
     * @return void
     */
    public function __construct(string $pathToView, array $payload = [])
    {
        // Path to the view directory
        $pathToViewDir = APP_ROOT."views/";
        // Path to view dir and view itself, appended with .view.php
        $pathToView = $pathToViewDir.$pathToView.".view.php";

        $this->pathToView = $pathToView;
        $this->payload = $payload;
        $this->create();
    }

    /**
     * Create the view.
     *
     * @return void
     */
    public function create()
    {
        if(!empty($this->payload)) {
            extract($this->payload);
        }
        ob_start();
        include $this->pathToView;
        $this->htmlOutput = ob_get_clean();
    }

    /**
     * Check if view exists.
     *
     * @var    string $pathToView
     * @return bool
     */
    public static function exists($pathToView)
    {
        return file_exists(APP_ROOT."views/".$pathToView.".view.php");
    }
}