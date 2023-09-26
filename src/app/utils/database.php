<?php

class Database {
    private $host = DB_HOST;
    private $name = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $port = DB_PORT;

    private $handle;

    public function __construct() {
        $this->handle = pg_connect("host=" . $this->host . " dbname=" . $this->name . " user=" . $this->user . " password=" . $this->pass . " port=" . $this->port);
    }

    public function __destruct() {
        pg_close($this->handle);
    }
    
    public function execute($query, $params = []) {
        $result = pg_prepare($this->handle, "", $query);
        $result = pg_execute($this->handle, "", $params);
        
        if ($result) return $result;
        else throw new Exception(pg_last_error($this->handle));
    }

    public function fetch($query, $params = []) {
        $result = $this->execute($query, $params);
        return pg_fetch_assoc($result);
    }

    public function fetchAll($query, $params = []) {
        $result = $this->execute($query, $params);
        return pg_fetch_all($result);
    }

    public function rowCount($query, $params = []) {
        $result = $this->execute($query, $params);
        return pg_num_rows($result);
    }
}
