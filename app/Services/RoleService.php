<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RoleService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.gateway.url');
        $this->token = config('services.gateway.token');
    }

    public function getRoles()
    {
        $response = Http::withToken($this->token)->get("$this->baseUrl/roles");
        return $response->json();
    }

    public function createRole($roleData)
    {
        $response = Http::withToken($this->token)->post("$this->baseUrl/roles", $roleData);
        return $response->json();
    }

    public function updateRole($roleId, $roleData)
    {
        $response = Http::withToken($this->token)->put("$this->baseUrl/roles/{$roleId}", $roleData);
        return $response->json();
    }

    public function deleteRole($roleId)
    {
        $response = Http::withToken($this->token)->delete("$this->baseUrl/roles/{$roleId}");
        return $response->json();
    }
}
