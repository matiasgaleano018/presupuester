<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Db\DbDriver;
use Illuminate\Support\Facades\Session;
use App\Helpers\ObjectStatus;

class Controller extends BaseController
{
    function returnView(string $viewName, ?array $data = []){
        $data['userInfo'] = $this->getAuthUserLoginInfo() ?? [];
        return view($viewName, ['data'=>$data]);
    }

    function redirectToRoute(string $routeName, ?array $data = []){
        return redirect()->route($routeName, ['data'=>$data]);
    }

    function getDbDriver(): DbDriver{
        $dbDriver = new DbDriver();
        return $dbDriver;
    }

    function setErrorMessage(string $message){
        Session::flash('error', $message);
    }

    function setSuccessMessage(string $message){
        Session::flash('success', $message);
    }

    function setWarningMessage(string $message){
        Session::flash('warning', $message);
    }

    public function getAuthUserLoginInfo(): ?array{    
        $thisUser = Session::get('thisUser');
        return $thisUser['userInfo'] ?? null; 
    }

}
