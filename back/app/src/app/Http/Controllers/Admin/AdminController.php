<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }



    public function updateAvatar(AvatarRequest $request, string $id): JsonResponse
    {
        $request->validated();
        $user =$this->adminService->getById($id);

        if ($user->avatar_url) {
            $oldAvatarPath = str_replace('http://0.0.0.0/storage/avatars/', '', $user->avatar_url);
            Log::debug($oldAvatarPath);
            Storage::disk('minio_avatars')->delete($oldAvatarPath);
        }


        $path = $request->file('avatar')->store('avatars', 'minio_avatars');

        $fullUrl = 'http://0.0.0.0/storage/avatars/' . $path;
        $user->update([
            'avatar_url' => $fullUrl
        ]);


        return response()->json([
        'message' => 'Avatar uploaded successfully',
        'avatar_url' => $fullUrl,
    ]);
    }


    public function getAdmin(string $id): JsonResponse
    {
        $admin = $this->adminService->getById($id);
        if(!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        return response()->json(['admin' => $admin]);
    }
}
