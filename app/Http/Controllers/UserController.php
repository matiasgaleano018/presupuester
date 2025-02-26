<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BaseObject;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    function test(Request $request){
        return $this->returnView('test', ['msm'=>'Hola a todos']);
    }

    function getUserPage(int $userId){
        $user = User::getById($this->getDbDriver(), $userId);
        if(!$user){
            $this->setErrorMessage('El usuario ('.$userId.') no encontrado');
            return redirect()->back();
        }
        return $this->returnView('user.user-info', ['user'=>$user->getFields()]);
    }

    function getChangePassPage(int $userId){
        $user = User::getById($this->getDbDriver(), $userId);
        if(!$user){
            $this->setErrorMessage('El usuario ('.$userId.') no encontrado');
            return redirect()->back();
        }

        return $this->returnView('user.change-pass', ['user'=>$user->getFields()]);
    }

    function setUser(Request $request, int $userId){
        $dbDriver = $this->getDbDriver();

        $firstName = BaseObject::isStringOrFail($request->get('first_name')??null, 'Nombre es requerido');
        $lastName = BaseObject::isStringOrFail($request->get('last_name')??null, 'Apellido es requerido');
        $email = BaseObject::isValidEmailOrFail($request->get('email')??null);

        if(!$firstName || !$lastName || !$email){
            return redirect()->back();  
        }

        $user = User::getById($dbDriver, $userId);
        if(!$user){
            $this->setErrorMessage('El usuario ('.$userId.') no encontrado');
            return redirect()->back();
        }

        if(User::checkEmailExists($dbDriver, $email) && $email != $user->getEmail()){
            $this->setErrorMessage('El email ya está registrado');
            return redirect()->back();
        }

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->writeToDb($dbDriver);

        $this->setSuccessMessage('Tu usuario fue actualizado');
        return redirect()->back();
    }

    function setNewUser(Request $request){
        $dbDriver = $this->getDbDriver();
        $firstName = BaseObject::isStringOrFail($request->get('first_name'), 'Nombre es requerido');
        $lastName = BaseObject::isStringOrFail($request->get('last_name'), 'Apellido es requerido');
        $email = BaseObject::isValidEmailOrFail($request->get('email'));
        $password = BaseObject::isStringOrFail($request->get('pass'), 'Contraseña es requerido');
        $confirmPassword = BaseObject::isStringOrFail($request->get('confirm_pass'), 'Contraseña de confirmación es requerido');

        if(!$firstName || !$lastName || !$email || !$password || !$confirmPassword){
            return redirect()->back();  
        }

        if($password != $confirmPassword){
            $this->setErrorMessage('Las contraseñas no coinciden');
            return redirect()->back();
        }

        if(User::checkEmailExists($dbDriver, $email)){
            $this->setErrorMessage('El email ya está registrado');
            return redirect()->back();
        }

        $user = User::allocNew($firstName, $lastName, $email, $password);
        $user->writeToDb($dbDriver);
        
        $this->setSuccessMessage('Te has registrado correctamente. Inicia sesión para acceder al sistema.');
        return $this->redirectToRoute('login');
    }

    function changePass(Request $request, int $userId){
        $dbDriver = $this->getDbDriver();

        $password = BaseObject::isStringOrFail($request->get('old_pass'), 'Contraseña es requerido');
        $newPassword = BaseObject::isStringOrFail($request->get('new_pass'), 'Contraseña de confirmación es requerido');

        if(!$password || !$newPassword){
            return redirect()->back();  
        }

        $user = User::getById($dbDriver, $userId);
        if(!$user){
            $this->setErrorMessage('El usuario ('.$userId.') no encontrado');
            return redirect()->back();
        }

        if(!$user->checkPassword($password)){
            $this->setErrorMessage('Contraseña incorrecta');
            return redirect()->back();
        }

        if($password == $newPassword){
            $this->setErrorMessage('La contraseña nueva no debe ser la misma que la anterior');
            return redirect()->back();
        }

        $user->setPassword($newPassword);
        $user->writeToDb($dbDriver);

        $this->setSuccessMessage('Tu contraseña fue actualizada');
        return redirect()->back();
    }
}
