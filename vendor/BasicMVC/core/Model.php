<?php

/**
 * Model.php
 * ---------
 * Outline for a model where other models will extend from.
 * Will serve as the interaction point to the database.
 */

class Model
{

    /* Protected variables to be initiated with each instance. */
    protected $tableName;
    protected $db;
    protected $fields;
    protected $id = "id";

    /**
     * Constructor, will be run when a new instance of Model is created.
     *
     * @return void
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Function to create a new record of the resource
     *
     * @var array $keyValues  $field => $value array of the data to store.
     */
    public static function create(array $keyValues)
    {
        $db = new Database();

        $fieldsSect = "";
        $valuesSect = "";
        $valuesArr = [];

        foreach($keyValues as $field => $value) {
            if(in_array($field, $fields, true) ) {
                $fieldsSect .= "$field,";
                $valuesSect .= ":$field,";
                $valuesArr[":".$field] = $value;
            }
        }
        
        $fieldsSect = rtrim($fieldsSect, ",");
        $valuesSect = rtrim($valuesSect, ",");

        $stmt = "INSERT INTO $tableName ($fieldsSect) VALUES ($valuesSect);";

        // Perform query here $db->query and assign to var
        $result = $db->query($stmt, $valuesArr);

        // return var of query
        return $result;
    }

    /**
     * Function to get record by id defined in model or 'id'
     * @var $searchID The id to attempt to return a record of
     */
    public static function get($searchID) 
    {
        $db = new Database();

        $stmt = "SELECT * FROM $tableName WHERE $id = :searchId;";
        $values = [
            ':searchId' => $searchID
        ];

        $return = $db->query($stmt, $values);

        return $return;
    }

    /**
     * Function to update record(s) by condition defined
     * @var $keyValues
     * @var $whereCondition
     */
    public static function update($keyValues, $whereCondition)
    {
        $db = new Database();

        $stmt = "UPDATE $tableName SET ".$columnValueUpdates." ";
    }

    /**
     * Destruct, will be run when all references stop.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->db->disconnect();
    }

}