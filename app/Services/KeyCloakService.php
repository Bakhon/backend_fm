<?php

namespace App\Services;

use App\Exceptions\ApiException;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;
use Throwable;

/**
 * Class KeyCloakService
 * @package App\Services
 */
class KeyCloakService extends Service
{

    protected $token = null;

    /**
     * Get client token
     *
     * @throws Exception|GuzzleException
     */
    public function getClientToken()
    {
        $base_url = rtrim(config('keycloak.base_url', "/ "));

        $client = new GuzzleClient([
            'base_uri' => $base_url . "/",
            'timeout' => 5,
            'headers' => ['Content-Type' => 'application/json']
        ]);

        try {
            $response = $client->request('POST', 'realms/' . config('keycloak.realm_name') . '/protocol/openid-connect/token', [
                'form_params' => [
                    'grant_type' => config('keycloak.grant_type'),
                    'client_id' => config('keycloak.client_name'),
                    'client_secret' => config('keycloak.client_secret')
                ]
            ]);
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $resp = json_decode($response->getBody()->getContents());

        $this->token = $resp->access_token;
    }

    /**
     * Get user by user hash from KeyCloak
     *
     * @param string|null $user_hash
     * @return mixed|stdClass
     * @throws Throwable
     */
    public function getKeyCloakUser(string $user_hash = null): stdClass
    {
        $fakeUser = new stdClass();
        $fakeUser->firstName = null;
        $fakeUser->lastName = null;
        $fakeUser->email = null;
        $fakeUser->attributes = null;
        $fakeUser->company = null;

        if ($user_hash) {

            $base_url = rtrim(config('keycloak.base_url', "/ "));
            $url = $base_url . "/admin/realms/" . config('keycloak.realm_name') . "/users/{$user_hash}";

            try {
                if (!$this->token) {
                    $this->getClientToken();
                }

                $response = Http::withToken($this->token)->get($url);
                $resp = json_decode($response->body());

                if (!isset($resp->error)) {
                    return $resp;
                }

            } catch (Throwable $e) {
                return $fakeUser;
            }
        }

        return $fakeUser;
    }

    /**
     * Get users list from KeyCloak
     *
     * @return mixed|stdClass
     * @throws Throwable
     */
    public function getKeyCloakUsers()
    {
        $base_url = rtrim(config('keycloak.base_url', "/ "));
        $url = $base_url . "/admin/realms/" . config('keycloak.realm_name') . "/users";

        try {
            if (!$this->token) {
                $this->getClientToken();
            }

            $response = Http::withToken($this->token)->get($url);
            $resp = json_decode($response->body());

            if (!isset($resp->error)) {
                return $resp;
            }

        } catch (Throwable $e) {
            throw new ApiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $resp;
    }

    /**
     * Get users list from KeyCloak by role-name
     *
     * @param string $role
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws Throwable
     */
    public function getKeyCloakUsersByRole(string $role, int $limit = 10, int $offset = 0)
    {
        $base_url = rtrim(config('keycloak.base_url', "/ "));
        $url = $base_url . "/admin/realms/" . config('keycloak.realm_name') . "/clients/" . config('keycloak.client_id') . "/roles/{$role}/users?first={$offset}&max={$limit}";

        try {
            if (!$this->token) {
                $this->getClientToken();
            }

            $response = Http::withToken($this->token)->get($url);
            $resp = json_decode($response->body());

        } catch (Throwable $e) {
            return [];
        }

        if (!isset($resp->error)) {
            return $resp;
        }

        return [];
    }
}
