<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;

abstract class CoreRepository
{
    private $table;

    public
    function __construct()
    {
        $this->table = DB::table($this->getTableName());
    }

    protected function changeTable($tableName) {
        $this->table =  DB::table($tableName);
    }

    abstract protected function getTableName();

    protected function startConditions() {
        return clone $this->table;
    }
}
