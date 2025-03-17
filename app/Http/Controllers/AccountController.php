<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BaseObject;
use App\Models\Account;
use App\Models\User;
use App\Helpers\ObjectStatus;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    function getAccounts(Request $request){
        $dbDriver = $this->getDbDriver();
        $user = $this->getAuthUserLoginInfo();
        $userId = $user['id'];

        $accTypes = Account::getAccountTypeList();
        $accounts = Account::getAllAccountsForUser($dbDriver, $userId);

        $accModel = [];
        foreach($accounts as $acc){
            $accModel[] = [
                'id' => $acc->id,
                'label' => $acc->label,
                'number' => $acc->number,
                'bank' => $acc->bank,
                'type_id' => $acc->type_id,
                'amount' => BaseObject::setPyCurrencyFormat(floatval($acc->amount ?? 0)),
                'description' => $acc->description,
                'status' => $acc->status
            ];
        }
        
        $param['accounts'] = $accModel;
        $param['accTypes'] = $accTypes;

        return $this->returnView('accounts.index', $param);
    }

    function setAccount(Request $request){
        $dbDriver = $this->getDbDriver();
        $user = $this->getAuthUserLoginInfo();
        $userId = $user['id'];

        $accTypeId = BaseObject::isStringOrFail($request->get('acc_type'), 'Tipo de cuenta es requerido');
        $accNumber = BaseObject::isStringOrFail($request->get('acc_number'), 'Número de cuenta es requerido');
        $accBalance = BaseObject::isNumericOrFail($request->get('acc_amount'), 'Saldo de cuenta es requerido');
        $accBankName = BaseObject::isStringOrFail($request->get('acc_bank'), 'Nombre del banco es requerido');
        $accDescription = $request->get('acc_description') ?? null;

        if(!$accTypeId || !$accNumber || !$accBalance || !$accBankName){
            return redirect()->back();  
        }
        
        $accTypeLabel = Account::getTypeById($accTypeId);
        if(!$accTypeLabel){
            $this->setErrorMessage('Tipo de cuenta no válido');
            return redirect()->back();
        }

        $accLabel = $accBankName.' ('.$accTypeLabel.'-'.$accNumber.')';
    
        $account = Account::allocNew($accLabel, $accBankName, $accNumber, $accTypeId, $userId, $accBalance, $accDescription);
        $account->writeToDb($dbDriver);

        $this->setSuccessMessage('Cuenta creada correctamente');
        return redirect()->back();
    }

    function setStatus(Request $request, int $accountId){
        $dbDriver = $this->getDbDriver();
        $user = $this->getAuthUserLoginInfo();
        $userId = $user['id'];

        $account = Account::getById($dbDriver, $accountId);
        if(!$account){
            return $this->errorJsonResponse([
                'status' => 'error',
                'message' => 'Cuenta no encontrada'
            ]);
        }

        if($account->getStatusId() === ObjectStatus::objStatusActive){
            $account->setStatusId(ObjectStatus::objStatusInactive);
        }else{
            $account->setStatusId(ObjectStatus::objStatusActive);
        }
        $account->writeToDb($dbDriver);

        return $this->successJsonResponse([
            'status' => 'ok'
        ]);
    }
}