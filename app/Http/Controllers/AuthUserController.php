<?php

namespace App\Http\Controllers;

use App\Db\DbDriver;
use App\Helpers\BaseObject;
use App\Helpers\ObjectStatus;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthUserController extends Controller
{
    function getLoginPage(){
        return $this->returnView('adm.login');
    }

    function getSignUpPage(){
        return $this->returnView('adm.sign-up');
    }

    function getWelcomePage(){
        return $this->returnView('home');
    }

    function login(Request $request){
        $email = BaseObject::isValidEmailOrFail($request->get('email'));
        $password = BaseObject::isStringOrFail($request->get('pass'), 'Contraseña es requerido');
        
        if(!$email || !$password){
            return redirect()->back();  
        }

        $user = User::getByEmail($this->getDbDriver(), $email);

        if(!$user->checkPassword($password)){
            $this->setErrorMessage('Credenciales incorrectas');
            return redirect()->back();
        }

        $csrfToken = csrf_token();

        $auth = self::getAuthByToken($this->getDbDriver(), $csrfToken);

        if(!empty($auth)){
            if($auth->expires_at <= BaseObject::pyTimeNow()->format('Y-m-d H:i:s') || $auth->status == ObjectStatus::objStatusInactive){
                self::reloginUser($this->getDbDriver(), $user, $csrfToken);
            }
            Session::put('thisUser', ['userInfo'=>$user->getFields(), 'token'=>$csrfToken]);
            return $this->redirectToRoute('welcome');
        }else{
            self::addUserLogin($this->getDbDriver(), $user, $csrfToken);
            Session::put('thisUser', ['userInfo'=>$user->getFields(), 'token'=>$csrfToken]);
            return $this->redirectToRoute('welcome');
        }

        return redirect()->back();  
    }

    private static function getAuthByToken(DbDriver $dbDriver, string $token){
        $envCx = $dbDriver->getEnvConnection();
        $pyTime = BaseObject::pyTimeNow();

        $userAuth = $envCx->table('user_login')
                        ->where('token', $token);

        return $userAuth->first();
    }

    private static function addUserLogin(DbDriver $dbDriver, User $user, string $token): void{
        $envCx = $dbDriver->getEnvConnection();
        $pyTime = BaseObject::pyTimeNow();
        $expiredAt = $pyTime->modify('+ 3 hours');

        $envCx->table('user_login')
            ->insert([
                'user_id' => $user->getDbId(),
                'token' => $token,
                'expires_at' => $dbDriver->dateToDb($expiredAt),
                'created_at' => $dbDriver->dateToDb($pyTime),
                'updated_at' => $dbDriver->dateToDb($pyTime),
                'status' => ObjectStatus::objStatusActive
            ]);
        self::cleanPassUserLogin($dbDriver, $user, $token);
    }

    private static function cleanPassUserLogin(DbDriver $dbDriver, User $user, string $token): void{
        $envCx = $dbDriver->getEnvConnection();

        $envCx->table('user_login')
            ->where('token', '<>', $token)
            ->where('user_id', $user->getDbId())
            ->update([
                'status' => ObjectStatus::objStatusInactive
            ]);
    }

    private static function reloginUser(DbDriver $dbDriver, User $user, string $token): void{
        $envCx = $dbDriver->getEnvConnection();
        $pyTime = BaseObject::pyTimeNow();
        $expiredAt = $pyTime->modify('+ 3 hours');

        $envCx->table('user_login')
            ->where('token', $token)
            ->where('user_id', $user->getDbId())
            ->update([
                'expires_at' => $dbDriver->dateToDb($expiredAt),
                'status' => ObjectStatus::objStatusActive
            ]);
    }

    function logout(){
        $dbDriver = $this->getDbDriver();
        $user = Session::get('thisUser');
        $token = $user['token'];

        $envCx = $dbDriver->getEnvConnection();
        $envCx->table('user_login')
            ->where('token', $token)
            ->where('user_id', $user['userInfo']['id'])
            ->update([
                'status' => ObjectStatus::objStatusInactive
            ]);
        
        return $this->redirectToRoute('login');
    }

}
