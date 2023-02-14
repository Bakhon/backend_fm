<?php

namespace App\Services;

use App\Http\Requests\UserSearchRequest;
use App\Http\Resources\UserResource;
use Throwable;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends Service
{
    /**
     * Get list users with search
     *
     * @param UserSearchRequest $request
     * @return array
     * @throws Throwable
     */
    public function _list(UserSearchRequest $request): array
    {

        $users = $this->keyCloakService->getKeyCloakUsersByRole(config('app.order_executor_user'), $request->limit, $request->offset);

        return [
            'list' => UserResource::collection($users),
            'listCount' => null
        ];
    }
}
