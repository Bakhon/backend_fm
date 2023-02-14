<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSearchRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User endpoints"
 * )
 */
class UserController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     description="Get users list",
     *     @OA\Parameter(in="query", name="limit", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="offset", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Return users list",
     *      @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(response=403, description="USER_HAS_NO_PERMISSION"),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     *)
     * @param UserService $userService
     * @param UserSearchRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function index(UserService $userService, UserSearchRequest $request): JsonResponse
    {
        $response = $userService->_list($request);
        return $this->successResponseWithData($response);
    }
}
