<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.gateway.url');
        $this->token = config('services.gateway.token');
    }

    public function getUsers()
    {
        $response = Http::withToken($this->token)->get("$this->baseUrl/users");
        return $response->json();
    }

    public function createUser($userData)
    {
        $response = Http::withToken($this->token)->post("$this->baseUrl/users", $userData);
        return $response->json();
    }

    public function updateUser($userId, $userData)
    {
        $response = Http::withToken($this->token)->put("$this->baseUrl/users/{$userId}", $userData);
        return $response->json();
    }

    public function deleteUser($userId)
    {
        $response = Http::withToken($this->token)->delete("$this->baseUrl/users/{$userId}");
        return $response->json();
    }
}
