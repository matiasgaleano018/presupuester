<?php

namespace App\Db;

use DateTimeInterface;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

class DbDriver
{
    public function __construct(){}

    private const envTest = 'mysql';
    static protected $cx = [];

    public function getEnvConnection(): ConnectionInterface{
        return $this->getConnection(self::envTest);
    }

    private function getConnection(string $name): ConnectionInterface{
        if( !isset(self::$cx[$name])){
            self::$cx[$name] = DB::connection($name);
        }
        return self::$cx[$name];
    }

    public function dateToDb(DateTimeInterface $date): string{
        return $date->format('Y-m-d H:i:s');
    }
}