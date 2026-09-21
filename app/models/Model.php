<?php

require_once __DIR__ . "/../../core/Database.php";

class Model
{
    protected $DB;

    public function __construct()
    {
        $this->DB = Database::getConnection();
    }
}
