<?php

namespace App\Helpers;

class ObjectStatus{
    public const objStatusActive = 1;
    public const objStatusInactive = 0;

    private $statusMap = [
        self::objStatusActive => 'Activo',
        self::objStatusInactive => 'Inactivo',
    ];

    public static function getStatusById(int $statusId){
        return self::$statusMap[$statusId];
    }
}