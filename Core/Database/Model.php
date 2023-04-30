<?php

namespace App\Core\Database;

abstract class Model
{
    protected $connection = 'mysql';
    protected $table;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $incremeting = true;
}
