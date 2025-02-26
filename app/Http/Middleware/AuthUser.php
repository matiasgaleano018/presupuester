<?php

namespace App\Http\Middleware;

use App\Db\DbDriver;
use App\Helpers\ObjectStatus;
use App\Helpers\BaseObject;
use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session as SessionFacade;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = csrf_token();
        $dbDriver = new DbDriver();

        if(!self::validateToken($dbDriver, $token)){
            SessionFacade::flash('error', 'No tienes permiso para acceder a esta sección.');
            return redirect()->route('login');
        }

        return $next($request);
    }

    private function validateToken(DbDriver $dbDriver, string $token): bool{
        $envCx = $dbDriver->getEnvConnection();
        $pyTimeNow = BaseObject::pyTimeNow();

        $userAuth = $envCx->table('user_login')
                        ->where('token', $token)
                        ->where('status', ObjectStatus::objStatusActive);
        
        $auth = $userAuth->first();

        if(empty($auth)){
            return false;
        }        

        if($auth->expires_at < $pyTimeNow->format('Y-m-d H:i:s')){
            $envCx->table('user_login')
                ->where('id', $auth->id)
                ->update([
                    'status' => ObjectStatus::objStatusInactive
                ]);
            return false;
        }

        return true;
    }
}
