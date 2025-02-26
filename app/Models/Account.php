<?php

namespace App\Models;

use App\Db\DbDriver;
use App\Helpers\ObjectStatus;
use App\Helpers\BaseObject;

class Account extends BaseModel
{

    private $label, $bank, $number, $typeId, $userId, $amount, $description, $status;

    const accTypeIdCash = 1,
    accTypeIdCC = 2,
    accTypeIdAH = 3,
    accTypeIdCredit = 4,
    accTypeIdCheck = 5,
    accTypeIdOther = 6;

    private const accTypeLabel = [
        self::accTypeIdCash => 'Efectivo',
        self::accTypeIdCC => 'Cuenta corriente',
        self::accTypeIdAH => 'Caja de ahorro',
        self::accTypeIdCredit => 'Tarjeta de credito',
        self::accTypeIdCheck => 'Cheque',
    ];
    
    public static function getTypeById(int $id): ?string{
        if($accTypeLabel = self::accTypeLabel[$id]){
            return $accTypeLabel;
        }
        return null;
    }

    public static function getAccountTypeList(): array{
        return self::accTypeLabel;
    }

    public static function getAllAccountsForUser(DbDriver $dbDriver, int $userId): ?array{
        $envCx = $dbDriver->getEnvConnection();
        $accounts = $envCx->table('accounts')->where('user_id', $userId)->get();
        return $accounts->toArray();
    }

    public static function allocNew(string $label, string $bank, string $number, int $typeId, int $userId, float $amount, ?string $description): self{
        $account = new self();
        $account->label = $label;
        $account->bank = $bank;
        $account->number = $number;
        $account->typeId = $typeId;
        $account->userId = $userId;
        $account->amount = $amount;
        $account->description = $description;
        $account->status = ObjectStatus::objStatusActive;

        return $account;
    }

    public function writeToDb(DbDriver $dbDriver){
        $envCx = $dbDriver->getEnvConnection();
        $pyTimeNow = BaseObject::pyTimeNow();

        $model = $this->object2Row();
        $model['updated_at'] = $dbDriver->dateToDb($pyTimeNow);

        if($this->getDbId() != 0){
            $envCx->table('accounts')->where('id', $this->getDbId())->update($model);
        }else{
            $model['created_at'] = $dbDriver->dateToDb($pyTimeNow);
            $envCx->table('accounts')->insert($model);
        }
    }

    private function object2Row(): array{
        $model = [
            'label' => $this->label,
            'bank' => $this->bank,
            'number' => $this->number,
            'type_id' => $this->typeId,
            'user_id' => $this->userId,
            'amount' => $this->amount,
            'description' => $this->description,
            'status' => $this->status,
        ];

        return $model;
    }

    private function row2Object(array $row): void{
        $this->label = $row['label'];
        $this->bank = $row['bank'];
        $this->number = $row['number'];
        $this->typeId = $row['type_id'];
        $this->userId = $row['user_id'];
        $this->amount = $row['amount'];
        $this->description = $row['description'];
        $this->status = $this->getStatusId();

    }

}