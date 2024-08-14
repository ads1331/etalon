<?php

namespace App\Http\Controllers\Api;

use App\Services\ApiService;
use Illuminate\Http\Request;
use App\Http\Requests\SomeRequest;
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

    public function store(SomeRequest $request)
    {
        $result = $this->apiService->createUser($request->all());
    
        return response()->json(
            ['message' => $result['message'], 'user' => $result['user'] ?? null], $result['http_status']
        );
    }
    

    public function update(SomeRequest $request, $id)
    {
        $result = $this->apiService->updateUser($id, $request->all());

        return response()->json(
            ['message' => $result['message'], 'user' => $result['user'] ?? null], $result['http_status']
        );
    }

    public function destroy($id)
    {
        $result = $this->apiService->deleteUser($id);

        return response()->json(
            ['message' => $result['message']], $result['http_status']
        );
    }
    public function contacts()
{
    $result = $this->apiService->getContactsByAuthId();

    return response()->json(
        ['message' => $result['message'] ?? 'Contacts fetched successfully', 'users' => $result['users'] ?? []], $result['http_status']
    );
}

}
