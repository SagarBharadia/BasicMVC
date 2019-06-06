<?php
/**
 * Database.php
 * ------------
 * Simple wrapper around PDO.
 * 
 * @package BasicMVC
 * @author Sagar Bharadia
 * @version 1.0
 */
class Database {
    /* Protected variables to be filled in with each instance. */
    protected $host = DBHOST;
    protected $database = DBDATABASE;
    protected $user = DBUSER;
    protected $pass = DBPASS;
    // Connection handle will be the PDO object.
    public $connectionHandle;
    // queryResult will contain the PDO result whether it may be a PDOException or a PDO
    public $queryResult;

    /**
     * Constructor, will be run when a new instance of Database is created.
     * @return void
     */
    public function __construct() {
        if(DBACTIVE) {
            $this->connect();
        }
    }

    /**
     * Destruct, will be run when as soon as references stop.
     */
    public function __destruct() {
        $this->disconnect();
    }

    /**
     * Create a connection handle to the database.
     * Will set $this->connectionHandle to PDOException or PDO.
     * @return void
     */
    private function connect() {
        try{
            // create a PDO connection with the configuration data
            $this->connectionHandle = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->user, $this->pass);
        } catch (PDOException $e){
            $this->connectionHandle = $e;
            error_log($e, 0);
        }
    }

    /**
     * Run queries on the connection handle.
     * @var string $sql, the query to run on the database.
     * @var array $values, the values to enter into the sql prepared statement.
     * @return \PDOStatement or \PDOException Returns the result of the query of type PDOStatement.
     */
    public function query(string $sql, array $values = []) {
        if ($this->connectionHandle instanceof \PDO) {
            $this->connectionHandle->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            try {
                $this->queryResult = $this->connectionHandle->execute($sql, $values);
            } catch (PDOException $e) {
                $this->queryResult = $e;
                error_log($e, 0);
            }
        } else {
            $this->queryResult = $this->connectionHandle;
        }
        return $this->queryResult;
    }

    /**
     * Return the pure PDO object.
     * @return \PDO or \PDOException or null Return the pure pdo or exception object depending if the db is active and can be connected
     */
    public function pdo() {
        return $this->connectionHandle;
    }

    /**
     * Close the connection handle to the database.
     * Will set $this->connectionHandle to null;
     * @return void
     */
    private function disconnect() {
        $this->connectionHandle = null;
    }
}