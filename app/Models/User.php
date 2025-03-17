<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Db\DbDriver;
use App\Helpers\ObjectStatus;
use App\Helpers\BaseObject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends BaseModel
{
    private $firstName, $lastName, $email, $password;
    private const dbColumns = 'first_name, last_name, email, password, created_at, updated_at';

    public static function checkEmailExists(DbDriver $dbDriver, string $email): bool{
        $envCx = $dbDriver->getEnvConnection();

        return $envCx->table('users')->where('email', $email)->exists();
    }

    public static function allocNew(string $firstName, string $lastName, string $email, string $password): self{
        $user = new self();
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->email = $email;
        $user->password = self::formattedPassword($password);
        $user->setStatusId(ObjectStatus::objStatusActive);

        return $user;
    }


    public function writeToDb(DbDriver $dbDriver){
        $envCx = $dbDriver->getEnvConnection();
        $pyTimeNow = BaseObject::pyTimeNow();

        $model = $this->object2Row();
        $model['updated_at'] = $dbDriver->dateToDb($pyTimeNow);

        if($this->getDbId() != 0){
            $envCx->table('users')->where('id', $this->getDbId())->update($model);
        }else{
            $model['created_at'] = $dbDriver->dateToDb($pyTimeNow);
            $envCx->table('users')->insert($model);
        }
    }

    public static function getById(DbDriver $dbDriver, int $id): ?self{
        $envCx = $dbDriver->getEnvConnection();

        $userRow = $envCx->table('users')
                        ->where('id', $id);

        if($userRow->count() == 0){
            return null;
        }
        
        foreach($userRow->get() as $row){
            $user = new self($row->id);
            $user->row2Object($row);
        }

        return $user;
    }

    public static function getByEmail(DbDriver $dbDriver, string $email): ?self{
        $envCx = $dbDriver->getEnvConnection();

        $userRow = $envCx->table('users')
                        ->where('email', $email);

        if($userRow->count() == 0){
            return null;
        }

        foreach($userRow->get() as $row){
            $user = new self($row->id);
            $user->row2Object($row);
        }

        return $user;
    }

    public function checkPassword(string $password): bool{
        return $this->password == self::formattedPassword($password);
    }

    private function object2Row(): array{
        $model = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->getStatusId(),
        ];

        return $model;
    }

    private function row2Object($row){
        $this->firstName = $row->first_name;
        $this->lastName = $row->last_name;
        $this->email = $row->email;
        $this->password = $row->password;
        $this->setStatusId($row->status);

    }

    public function getFields(): array{
        return [
            'id' => $this->getDbId(),
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'status' => $this->getStatusId(),
        ];
    }

    private static function formattedPassword(string $password): string{
        $key = 'presupuesterKey@2024';

        $passFormated = \hash('sha256', $password.$key);
        return $passFormated;
    }


    //getters and setters

    function getFirstName(): string{
        return $this->firstName;
    }

    function setFirstName(string $firstName){
        $this->firstName = $firstName;
    }

    function getLastName(): string{
        return $this->lastName;
    }

    function setLastName(string $lastName){
        $this->lastName = $lastName;
    }

    function getEmail(): string{
        return $this->email;
    }

    function setEmail(string $email){
        $this->email = $email;
    }

    function setPassword(string $password){
        $this->password = self::formattedPassword($password);
    }
}
