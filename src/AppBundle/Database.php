<?php

namespace AppBundle;

class Database {

    public $connection;

    public function __construct() {
        $servername = 'login-67.hoststar.ch';
        $dbname = 'inf17d';
        $user = 'inf17d';
        $password = 'j5TQh!zmMtqsjY3';
        $this->connection = new \mysqli($servername, $user, $password, $dbname);

        if($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }
    }

    public function query($query) {
        // $result = $this->connection->query($query);
        // // $result->execute();
        $items = [];

        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_object()) {
        //         array_push($items, $row);
        //     }
        // }

        foreach ($this->connection->query($query) as $row) {
            array_push($items, $row);
        }

        return $items;
    }
}
