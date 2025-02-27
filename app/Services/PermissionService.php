<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PermissionService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.gateway.url');
        $this->token = config('services.gateway.token');
    }

    public function getPermissions()
    {
        $response = Http::withToken($this->token)->get("$this->baseUrl/permissions");
        return $response->json();
    }

    public function createPermission($permissionData)
    {
        $response = Http::withToken($this->token)->post("$this->baseUrl/permissions", $permissionData);
        return $response->json();
    }

    public function updatePermission($permissionId, $permissionData)
    {
        $response = Http::withToken($this->token)->put("$this->baseUrl/permissions/{$permissionId}", $permissionData);
        return $response->json();
    }

    public function deletePermission($permissionId)
    {
        $response = Http::withToken($this->token)->delete("$this->baseUrl/permissions/{$permissionId}");
        return $response->json();
    }
}
