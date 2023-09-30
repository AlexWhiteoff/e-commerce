<?php

namespace core;

use PDO;

class Database
{
    protected $pdo;
    public function __construct($server, $login, $password, $database)
    {
        $this->pdo = new \PDO("mysql:host={$server};dbname={$database};charset=UTF8", $login, $password);
    }

    // CRUD
    /**
     * CRUD:
     * Create
     * Reed
     * Update
     * Delete
     */
    public function select($table, $fields = "*", $where = null, $orderBy = null, $limit = null, $offset = null)
    {
        $fieldsString = '*';

        if (is_string($fields))
            $fieldsString = $fields;

        if (is_array($fields))
            $fieldsString = implode(', ', $fields);

        $sql = "SELECT {$fieldsString} FROM {$table}";

        if (is_array($where) && count($where) > 0) {
            $whereParts = [];
            foreach ($where as $key => $value)
                $whereParts[] = " {$key} = ?";
            $whereString = implode(' AND ', $whereParts);
            $sql .= ' WHERE ' . $whereString;
        }

        if (is_string($where))
            $sql .= " WHERE {$where}";

        if (is_array($orderBy)) {
            $orderByParts = [];
            foreach ($orderBy as $key => $value) {
                $orderByParts[] = " {$key} {$value}";
            }
            $sql .= ' ORDER BY ' . implode(', ', $orderByParts);
        }

        if (!empty($limit))
            if (!empty($offset))
                $sql .= " LIMIT {$offset}, ${limit}";
            else
                $sql .= " LIMIT ${limit}";

        $sth = $this->pdo->prepare($sql);
        if (is_array($where) && count($where) > 0)
            $sth->execute(array_values($where));
        else
            $sth->execute();

        return $sth->fetchAll();
    }

    public function insert($table, $row)
    {
        $fieldsStr = implode(', ', array_keys($row));
        $valuesParts = [];
        foreach ($row as $key => $value) {
            $valuesParts[] = "?";
        }
        $valuesStr = implode(', ', $valuesParts);
        $sql = "INSERT INTO `{$table}` ({$fieldsStr}) VALUES ($valuesStr)";

        $sth = $this->pdo->prepare($sql);
        $sth->execute(array_values($row));

        return $this->pdo->lastInsertId();
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM `{$table}`";
        if (is_array($where) && count($where) > 0) {
            $whereParts = [];
            foreach ($where as $key => $value)
                $whereParts[] = " {$key} = ?";
            $whereString = implode(' AND ', $whereParts);
            $sql .= ' WHERE ' . $whereString;
        }

        if (is_string($where))
            $sql .= " WHERE {$where}";

        $sth = $this->pdo->prepare($sql);

        if (is_array($where) && count($where) > 0)
            $sth->execute(array_values($where));
        else
            $sth->execute();
    }

    public function update($table, $newRow, $where)
    {
        $sql = "UPDATE `{$table}` SET ";
        $setParts = [];
        $paramsArr = [];
        foreach ($newRow as $key => $value) {
            $setParts[] = " {$key} = ?";
            $paramsArr[] = $value;
        }
        $sql .= implode(', ', $setParts);

        if (is_array($where) && count($where) > 0) {
            $whereParts = [];
            foreach ($where as $key => $value) {
                $whereParts[] = " {$key} = ?";
                $paramsArr[] = $value;
            }
            $whereString = implode(' AND ', $whereParts);
            $sql .= ' WHERE ' . $whereString;
        }

        if (is_string($where))
            $sql .= " Where {$where}";

        $sth = $this->pdo->prepare($sql);
        $sth->execute($paramsArr);
    }
}
