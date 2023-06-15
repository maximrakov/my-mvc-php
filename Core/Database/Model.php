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
    protected $attributes = [];
    protected $id;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function __get($property)
    {
        if (in_array($property, $this->fillable)) {
            return $this->attributes[$property];
        }
        return null;
    }

    public function __set($property, $value)
    {
        if (in_array($property, $this->fillable)) {
            $this->attributes[$property] = $value;
        }
    }

    public function save()
    {
        $query = $this->buildInsertQuery();
        $fieldValues = [];
        foreach ($this->fillable as $field) {
            $fieldValues[] = $this->attributes[$field];
        }
        DB::insert($query, $fieldValues);
    }

    public function find($id)
    {
        $query = "SELECT * FROM $this->table WHERE id=$id";
        $arg = DB::select($query)[0];
        return $this->getModelFromAttributesArray($arg);

    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->table";
        $models = DB::select($query);
        $modelArray = [];
        foreach ($models as $model) {
            $modelArray[] = $this->getModelFromAttributesArray($model);
        }
        return $modelArray;
    }

    public function delete()
    {
//        print_r($this->retrieveId());
        $query = "DELETE FROM $this->table WHERE id={$this->retrieveId()}";
//        dd($query);
        DB::delete($query);
    }

    public function update($attributes)
    {
        $query = $this->buildUpdateQuery(array_keys($attributes));
        $fieldValues = array_values($attributes);
        DB::update($query, $fieldValues);
    }

    private function buildInsertQuery(): string
    {
        $query = "INSERT INTO $this->table (";
        foreach ($this->fillable as $field) {
            $query .= $field . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($this->fillable as $field) {
            $query .= '?, ';
        }
        $query = substr($query, 0, -2);
        $query .= ')';
        return $query;
    }

    public function buildUpdateQuery($attributeNames): string
    {
        $query = "UPDATE $this->table SET ";
        foreach ($attributeNames as $field) {
            $query .= $field . ' = ?, ';
        }
        $query = substr($query, 0, -2);
        $id = $this->retrieveId();
        $query .= " WHERE id={$id}";
        print_r($query);
        return $query;
    }

    public function retrieveId()
    {
        $id = $this->attributes['id'];
        if($id !== null) {
            return $id;
        }
        $whereConstruction = '';
        foreach ($this->fillable as $field) {
            $whereConstruction .= "$field = '{$this->attributes[$field]}' and ";
        }
        $whereConstruction = substr($whereConstruction, 0, -5);
        $query = "SELECT * FROM WHERE $whereConstruction";
        return DB::select($query)['id'];
    }

    public function getModelFromAttributesArray($arg)
    {
        $modelCreation = "return new " . get_class($this) . "(\$arg);";
        return eval($modelCreation);
    }
}
