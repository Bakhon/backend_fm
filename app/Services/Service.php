<?php

namespace App\Services;

use App\Helpers\Responses;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class Service
 * @package App\Services
 *
 * @property UserService $userService
 * @property CaseVersionService $caseVersionService
 * @property CaseService $caseService
 * @property FileService $fileService
 * @property KeyCloakService $keyCloakService
 * @property FamilyCompositionService $familyCompositionService
 * @property SectionService $sectionService
 */
abstract class Service
{
    use Responses;

    public function __get($name)
    {
        $child = (new ReflectionClass(self::class))->getNamespaceName() . '\\' . ucfirst($name);
        if (class_exists($child)) {
            return new $child;
        }

        return null;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        /** @var User $user */
        $user = Auth::user();
        return $user;
    }

    /**
     * Merge two array by value
     *
     * @param array $arr1
     * @param array $arr2
     * @return array
     */
    public function arrayMerge(array $arr1, array $arr2): array
    {
        $new = [];

        foreach ($arr1 as $item) {
            $new[$item] = 1;
        }

        foreach ($arr2 as $item) {
            $new[$item] = 1;
        }

        $resp = [];

        foreach ($new as $key => $val) {
            if ($key) {
                $resp[] = $key;
            }
        }

        return $resp;
    }

    /**
     * Merge users with keyCloak users
     *
     * @param array $keyCloakUsers
     * @param object $users
     * @param string $column
     * @return AnonymousResourceCollection
     */
    public function mergeUsers(array $keyCloakUsers, object $users, string $column): AnonymousResourceCollection
    {
        $response = [];

        foreach ($users as $user) {
            foreach ($keyCloakUsers as $keyCloakUser) {
                if ($keyCloakUser->id === $user->$column) {
                    $response[] = $keyCloakUser;
                    continue;
                }
            }
        }

        return UserResource::collection($response);
    }
}
