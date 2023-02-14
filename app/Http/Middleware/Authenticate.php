<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Helpers\Responses;
use App\Models\User;
use App\Reference\Constants;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\KeyCloakService;

class Authenticate extends Middleware
{
    use Responses;

    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return mixed
     * @throws ApiException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            if ($this->authenticate($request, $guards) === 'authentication_error') {
                throw new ApiException(Constants::USER_UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
            } else {
                $JWTToken = json_decode(Auth::token());
                $user = new User();
                $user->fill((array)$JWTToken);

                $userRoles = [];
                foreach ($JWTToken->resource_access as $access) {
                    $userRoles = array_merge($access->roles, $userRoles);
                }

                $user->roles = $userRoles;
                $user->token = $request->bearerToken();

                Auth::setUser($user);;

                if (!Cache::has('sub')) {
                    Cache::put('sub', Auth::user()->sub, now()->addMinutes(60));
                }
                
                $value = Cache::get('sub');
                $author = (new KeyCloakService())->getKeyCloakUser($value);
                $page = $_SERVER['HTTP_HOST']. '/' .$_SERVER['REQUEST_URI'];

                $title = '';
                if (isset($author->attributes->title)) {
                    $title = $author->attributes->title[0];
                }

                $company = '';
                if (isset($author->attributes->company)) {
                    $company = $author->attributes->company[0];
                }

                $type = 'Внешний';
                if (isset($author->federationLink)) {
                    $type = 'Внутренний';
                } 

                DB::table('login')->insert(['user_hash' => $value, 
                                            'date_login' => Carbon::now('Asia/Almaty'),
                                            'url' => $page,
                                            'fio' => Auth::user()->name,
                                            'email' => Auth::user()->email,
                                            'spec' => $title,
                                            'company' => $company,
                                            'user_type' => $type,
                                        ]);
            }
        } catch (\Exception $e) {
            throw new ApiException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
        return 'authentication_error';
    }
}
