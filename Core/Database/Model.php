<?php

namespace App\Core\Database;

abstract class Model
{
    protected $connection = 'mysql';
    protected $table;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $incremeting = true;
    protected $fillable = [];

    protected $id;

    public function save()
    {
        $this->id = $this->getNextId();
        $fields = DB::getFields($this->table);
        $query = $this->buildInsertQuery($fields);
        $fieldValues = $this->getFieldValues($fields);
        DB::insert($query, $fieldValues);
    }

    public function find($id)
    {
        $query = "select * from $this->table where id=$id";
        return DB::select($query);
    }

    public function findAll()
    {
        $query = "select * from $this->table";
        return DB::select($query);
    }

    public function delete()
    {
        $query = "DELETE FROM $this->table WHERE id=$this->id";
    }

    public function update()

    {
        $fields = DB::getFields($this->table);
        $query = $this->buildUpdateQuery($fields);
        $fieldValues = $this->getFieldValues($fields);
        DB::update($query, $fieldValues);
    }

    private function buildInsertQuery($fields): string
    {
        $query = "insert into $this->table (";
        foreach ($fields as $field) {
            $query .= $field . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($fields as $field) {
            $query .= '?, ';
        }
        $query = substr($query, 0, -2);
        $query .= ')';
        return $query;
    }

    public function buildUpdateQuery($fields): string
    {
        $query = "UPDATE $this->table SET ";
        foreach ($fields as $field) {
            $query .= $field . ' = ?, ';
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE id=$this->id";
        $query = substr($query, 0, -2);
        $query .= ')';
        return $query;
    }

    public function getFieldValues($fields): array
    {
        $fieldValues = [];
        foreach ($fields as $field) {
            $fieldValues[] = $this->$field;
        }
        return $fieldValues;
    }

    private function getNextId(): ?int
    {
        return count(DB::select("select * from $this->table")) + 1;
    }
}
