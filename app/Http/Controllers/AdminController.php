<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(): JsonResponse
    {
        $data = $this->adminService->getAdminData();
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function clearCache(): JsonResponse
    {
        $this->adminService->clearCache();
        return response()->json(['message' => 'Cache cleared successfully.'], 200);
    }
}

