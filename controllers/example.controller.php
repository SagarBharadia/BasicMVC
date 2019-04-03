<?php
/**
 * example.controller.php
 * 
 * This is a template for what a controller could look like.
 */
class ExampleController extends Controller {

    /**
     * Constructor. Called when the instance is created.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get Function. If the request type is GET then this function will be called.
     * @return string The output to the user.
     */
    public function get() {
        return "example get";
    }
    
    /**
     * Post Function. If the request type is POST then this function will be called.
     * @return string The output to the user.
     */
    public function post() {
        return "exampel post";
    }

    /**
     * Put Function. If the request type is PUT then this function will be called.
     * @return string The output to the user.
     */
    public function put() {
        return "example put";
    }

    /**
     * Update Function. If the request type is UPDATE then this function will be called.
     * @return string The output to the user.
     */
    public function update() {
        return "example update";
    }

    /**
     * Delete Function. If the request type is DELETE then this function will be called.
     * @return string The output to the user.
     */
    public function delete() {
        return "example delete";
    }
}

return new ExampleController();