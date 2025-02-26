<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use PhpParser\Node\Scalar\Float_;

class BaseObject {

    private static $pyTimeZone = null;
    static function isStringOrNull($value): ?string{
        if(is_string($value)){
            return $value;
        }
        return null;
    }

    static function isStringOrFail(?string $value, string $errorMsg): ?string{
        if(is_string($value)){
            return trim($value);
        }

        Session::flash('error', $errorMsg);
        return false;
    }

    static function isValidEmailOrFail(?string $email): ? string{
        if(is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
            return $email;
        }

        Session::flash('error', 'Email invalido');
        return false;
    }

    static function isNumericOrFail(?string $value, string $errorMsg): ?float{
        if(is_numeric($value)){
            return (float)$value;
        }
        Session::flash('error', $errorMsg);
        return false;
    }

    static function pyTimeZone():\DateTimeZone {
        if( !self::$pyTimeZone )self::$pyTimeZone = new \DateTimeZone('America/Asuncion');
        return self::$pyTimeZone;
    }

    static function pyTimeNow(): \DateTimeImmutable{
        return new \DateTimeImmutable('now',self::pyTimeZone());
    }
}