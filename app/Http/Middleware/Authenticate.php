<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Responses\Json as ResponsesJson;
use Velmie\Wallet\Permissions\PermissionCheckerClient;
use Velmie\Wallet\Users\UserHandlerClient;
use Illuminate\Http\Request;

class Authenticate
{
    protected $permission = '';
    protected $permissionsClient = '';
    protected $usersClient = '';
    static $loginUserID;

    public function __construct()
    {
        $rpcPermission = env('SERVICE_PERMISSIONS');
        $rpcUser = env('SERVICE_USERS');

        $this->permissionsClient = new PermissionCheckerClient($rpcPermission);
        $this->usersClient = new UserHandlerClient($rpcUser);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $token = $request->header('Authorization');
            if($token){
                $requestRpc = new \Velmie\Wallet\Users\Request();
                $requestRpc->setAccessToken(str_replace('Bearer ', '', $token));

                $response = $this->usersClient->ValidateAccessToken([], $requestRpc);

                if($response->getUser()){
                    $userId = $response->getUser()->getUID();

                    self::$loginUserID = $userId;

                    if(empty($this->permission))
                        return $next($request);

                    $requestRpc = new \Velmie\Wallet\Permissions\PermissionReq();
                    $requestRpc->setUserId($userId);
                    $requestRpc->setActionKey($this->permission);
                    $response = $this->permissionsClient->Check([], $requestRpc);

                    if($response->getIsAllowed()){
                        return $next($request);
                    } else {
                        return ResponsesJson::err(new \App\Http\Responses\Errors\Forbidden("No permission"));
                    }
                }
            }
            return ResponsesJson::err(new \App\Http\Responses\Errors\Unauthorized("No authorized"));

        } catch (\App\Http\Responses\Errors\Error $e) {
            return ResponsesJson::err($e);
        }
    }

    public static function getLoginUserId()
    {
        return static::$loginUserID;
    }
}
