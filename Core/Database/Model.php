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

    public function save()
    {
        $fields = DB::getFields($this->table);
        $query = "insert into $this->table (";
        foreach ($fields as $field) {
            $query .= $field . ', ';
        }
        $this->id = $this->getNextId();
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        $fieldValues = [];
        foreach ($fields as $field) {
            $fieldValues[] = $this->$field;
            $query .= '?, ';
        }
        $query = substr($query, 0, -2);
        $query .= ')';
        print_r($query);

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

    public function delete() {
        $query = "DELETE FROM $this->table WHERE id=$this->id";
    }

    public function update() {
        $fields = DB::getFields($this->table);
        $query = "UPDATE $this->table SET ";
        foreach ($fields as $field) {
            $query .= $field . ' = ?, ';
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE id=$this->id";
        $fieldValues = [];
        foreach ($fields as $field) {
            $fieldValues[] = $this->$field;
        }
        $query = substr($query, 0, -2);
        $query .= ')';
        DB::update($query, $fieldValues);
    }
    private function getNextId()
    {
        return count(DB::select("select * from $this->table")) + 1;
    }
}
