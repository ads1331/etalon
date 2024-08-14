<?php

namespace App\Services;

use App\Models\User;
use App\Models\Phone;
use App\Models\Emails;
use App\Models\Links;
use App\Models\Dates;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AuthUser;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Response as HttpResponse;

class ApiService
{
    public function getAllUsers()
    {
        try {
            return User::all();
        } catch (\Exception $e) {
            Log::error('Error fetching users:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to fetch users');
        }
    }

    public function getUserById($id)
    {
        try {
            return User::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching user:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to fetch user');
        }
    }

    public function createUser(array $data)
    {
        try {
            DB::beginTransaction();
            
            $authId = Auth::id();
            

            if (!$authId || !AuthUser::find($authId)) {
                throw new \Exception('Invalid auth_id');
            }
    
            
            $userData = $data['user'] ?? [];
            $userData['auth_id'] = $authId;
    

            if (empty($userData['first_name']) || empty($userData['last_name'])) {
                throw new \Exception('First name and last name are required.');
            }
    
            $user = User::create($userData);
    
           $this->storeRelatedData($user->id, $data);
    
            DB::commit();
            return [
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'http_status' => HttpResponse::HTTP_CREATED
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user:', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'http_status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }
    public function getContactsByAuthId()
{
    try {
        $authId = Auth::id();
        $users = User::where('auth_id', $authId)
            ->with(['phone', 'emails', 'links', 'dates', 'companies'])
            ->get();
        
        if ($users->isEmpty()) {
            throw new \Exception('No users found for the given auth_id');
        }

        return [
            'status' => 'success',
            'users' => $users,
            'http_status' => HttpResponse::HTTP_OK
        ];
    } catch (\Exception $e) {
        Log::error('Error fetching contacts by auth_id:', ['error' => $e->getMessage()]);
        return [
            'status' => 'error',
            'message' => 'An error occurred: ' . $e->getMessage(),
            'http_status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR
        ];
    }
}

        

    public function updateUser($id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $userData = $data['user'] ?? [];
            $user->update($userData);

            $this->updateRelatedData($user->id, $data);

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'User and related data updated successfully',
                'user' => $user,
                'http_status' => HttpResponse::HTTP_OK
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'http_status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
                    'http_status' => HttpResponse::HTTP_NOT_FOUND
                ];
            }


            $user->delete();

            return [
                'status' => 'success',
                'message' => 'User deleted successfully',
                'http_status' => HttpResponse::HTTP_OK
            ];
        } catch (\Exception $e) {
            Log::error('Error deleting user:', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'http_status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
    }

    private function storeRelatedData($userId, array $data)
    {
        foreach ($data['phone'] ?? [] as $phoneData) {
            Phone::create([
                'user_id' => $userId,
                'number' => $phoneData['number'],
                'type' => $phoneData['type'],
            ]);
        }

        foreach ($data['emails'] ?? [] as $emailData) {
            Emails::create([
                'user_id' => $userId,
                'email' => $emailData['email'],
                'type' => $emailData['type'],
            ]);
        }

        foreach ($data['links'] ?? [] as $linkData) {
            Links::create([
                'user_id' => $userId,
                'link' => $linkData['link'],
                'type' => $linkData['type'],
            ]);
        }

        foreach ($data['dates'] ?? [] as $dateData) {
            Dates::create([
                'user_id' => $userId,
                'date' => $dateData['date'],
                'type' => $dateData['type'],
            ]);
        }

        foreach ($data['companies'] ?? [] as $companyData) {
            Company::create([
                'user_id' => $userId,
                'name' => $companyData['name'],
                'address' => $companyData['address'],
            ]);
        }
    }

    private function updateRelatedData($userId, array $data)
    {
        Phone::where('user_id', $userId)->delete();
        Emails::where('user_id', $userId)->delete();
        Links::where('user_id', $userId)->delete();
        Dates::where('user_id', $userId)->delete();
        Company::where('user_id', $userId)->delete();

        $this->storeRelatedData($userId, $data);
    }
}
