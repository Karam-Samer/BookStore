<?php

require_once __DIR__ . "/../../core/Database.php";

class Model
{
    protected $DB;

    public function __construct()
    {
        $this->DB = Database::getConnection();
    }

    public static function prepareWhereQuery(array $wheres = []): string
    {
        $subQuery = '';
        if (!empty($wheres)) {
            $subQuery = "WHERE ";
            $counter = 1;
            foreach ($wheres as $where) {
                if ($counter > 1) {
                    if (isset($where[3])) {
                        $subQuery .= "{$where[3]} ";
                    } else {
                        $subQuery .= "AND ";
                    }
                }
                $subQuery .= "{$where[0]} {$where[1]} '{$where[2]}' ";
                $counter++;
            }
        }
        return $subQuery;
    }
}
