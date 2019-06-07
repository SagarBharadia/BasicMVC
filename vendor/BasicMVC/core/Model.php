<?php

/**
 * Model.php
 * ---------
 * Outline for a model where other models will extend from.
 * Will serve as the interaction point to the database.
 */

 class Model {

  /* Protected variables to be initiated with each instance. */
  protected $tableName;
  protected $db;

  /**
   * Constructor, will be run when a new instance of Model is created.
   * @return void
   */
  public function __construct() {
    $this->db = new Database();
  }

  /**
   * Destruct, will be run when all references stop.
   * @return void
   */
  public function __destruct() {
    $this->db->disconnect();
  }
  

    
 }