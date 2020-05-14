<?php

namespace AppBundle;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Database {

    public $connection;

    public function __construct(string $database_host, string $database_name, string $database_user, string $database_password) {

        $this->connection = new \mysqli(
            $database_host,
            $database_user,
            $database_password,
            $database_name
        );

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
