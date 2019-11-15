<?php
/**
 * Controller.php
 * --------------
 * Simple controller class.
 * 
 * @package BasicMVC
 * @author  Sagar Bharadia
 * @version 1.0
 */
abstract class Controller
{
    public $method;
    private $db;
    
    /**
     * Constructor. Set's up the environment.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Every controller will be required to have the get function.
     * It is the default function that will be run.
     */
    abstract public function get();
}