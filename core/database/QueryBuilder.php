<?php

namespace Core\database;

use PDO;

// A class responsible for building database queries.
class QueryBuilder
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function first(string $table, string $fetchClass = null, $id = 0)
    {
        $query = $this->db->prepare("select * from {$table} where id = {$id};");
        $query->execute();

        if ($fetchClass) {
            return $query->fetchAll(PDO::FETCH_CLASS, $fetchClass);
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectAll(string $table, string $fetchClass = null, string $order = null, array $join = [], $select = '*')
    {
        $query = "select {$select} from {$table} ";
        if (!empty($join)) {
            $query .= "inner join `{$join['table']}` on {$join['refKey']} = {$join['foreignKey']} ";
        }
        $end = ';';
        $query = $this->db->prepare($query . $order . $end);
        $query->execute();

        if ($fetchClass) {
            return $query->fetchAll(PDO::FETCH_CLASS, $fetchClass);
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert(string $table, array $parameters)
    {
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }

    public function update(string $table, array $parameters, $id = 0)
    {
        $str = '';
        foreach (array_keys($parameters) as $key => $value) {
            $str .= $value . '=:' . $value;
            if ($key != count(array_keys($parameters)) - 1) {
                $str .= ', ';
            }
        }

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id={$id}",
            $table,
            $str
        );
        $query = $this->db->prepare($sql);
        $query->execute($parameters);
    }

    public function delete(string $table, $id = 0)
    {
        $stmt = $this->db->prepare("DELETE FROM {$table} WHERE id =:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function done(string $table, $id = 0)
    {
        $check_isDone = $this->first($table, null, $id);
        $json = json_encode($check_isDone[0]);
        $dataArray = json_decode($json, true);
        $isDoneValue = ($dataArray['isDone'] == 0) ? 1 : 0;
        $stmt = $this->db->prepare("UPDATE {$table} SET isDone = :isDone WHERE id = :id");
        $stmt->bindParam(':isDone', $isDoneValue, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function latest(string $table)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function exists(string $table , string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function findUser(string $table , string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
}
