<?php

namespace App\Http\Controllers\Api;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response as HttpResponse;

class ApiController extends BaseController
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $items = $this->apiService->getAllUsers();
        return response()->json(['data' => $items]);
    }

    public function show($id)
    {
        $item = $this->apiService->getUserById($id);
        return response()->json(['data' => $item]);
    }

    public function store(Request $request)
    {
        $result = $this->apiService->createUser($request->all());

        if ($result['status'] === 'success') {
            return response()->json(['message' => $result['message'], 'user' => $result['user']], HttpResponse::HTTP_CREATED);
        }

        return response()->json(['error' => $result['message']], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(Request $request, $id)
    {
        $result = $this->apiService->updateUser($id, $request->all());

        if ($result['status'] === 'success') {
            return response()->json(['message' => $result['message'], 'user' => $result['user']]);
        }

        return response()->json(['error' => $result['message']], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function destroy($id)
    {
        $result = $this->apiService->deleteUser($id);

        if ($result['status'] === 'success') {
            return response()->json(['message' => $result['message']], HttpResponse::HTTP_NO_CONTENT);
        }

        return response()->json(['error' => $result['message']], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
