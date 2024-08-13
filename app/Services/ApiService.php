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

class ApiService
{
    public function getAllUsers()
    {
        return User::with(['phone', 'emails', 'links', 'dates', 'companies'])->get();
    }

    public function getUserById($id)
    {
        return User::with(['phone', 'emails', 'links', 'dates', 'companies'])->findOrFail($id);
    }

    public function createUser(array $data)
    {
        DB::beginTransaction();
        try {
            $userData = $data['user'] ?? [];
            if (empty($userData)) {
                throw new \Exception('User data is missing');
            }

            $user = User::create($userData);

            $this->storeRelatedData($user->id, $data);

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'User and related data stored successfully',
                'user' => $user,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user:', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
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
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ];
        }
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return [
            'status' => 'success',
            'message' => 'User deleted successfully',
        ];
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
