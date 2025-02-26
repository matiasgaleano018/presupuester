<?php

namespace App\Models;


class BaseModel{

    private $dbId,$statusId,$createTime,$updateTime;

    function __construct( int $dbId = 0 ){
        $this->dbId = $dbId;
    }

    function setStatusId( int $statusId ){
        $this->statusId = $statusId;
    }

    function getStatusId(){
        return $this->statusId;
    }

    function getDbId(){
        return $this->dbId;
    }
}