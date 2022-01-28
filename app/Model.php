<?php
namespace app;

//require 'vendor\autoload.php';

include 'app/Database.php';

use mysql_xdevapi\Table;
use PDO;

class Model {

    protected $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function update($table, $data, $where)
    {
        $statement = $this->pdo->prepare("UPDATE {$table} SET {$data} WHERE {$where}");

        $statement->execute();

        return $statement;
    }

    public function selectWithWhere($table, $fields, $where, $whereValue)
    {
        $statement = $this->pdo->prepare("select {$fields} from {$table} WHERE {$where} = {$whereValue} ");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectWithMultipleWhere($table, $fields, $condition)
    {
        $statement = $this->pdo->prepare("select {$fields} from {$table} {$condition} ");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function insert($table, $parameters)
    {

        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
            return true;
        } catch (\Exception $e) {
            //return $e->getMessage();
            return false;
        }
    }
}
