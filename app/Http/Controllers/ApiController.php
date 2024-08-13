<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Phone;
use App\Models\Emails;
use App\Models\Links;
use App\Models\Dates;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        $items = User::with(['phone', 'emails', 'links', 'dates', 'companies'])->get();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = User::with(['phone', 'emails', 'links', 'dates', 'companies'])->find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
         

        DB::beginTransaction();
        try {
            $user = User::create($request->only(['first_name', 'last_name', 'notes']));


            foreach ($request->phone as $phoneData) {
                Phone::create([
                    'user_id' => $user->id,
                    'number' => $phoneData['number'],
                    'type' => $phoneData['type'],
                ]);
            }

            foreach ($request->emails as $emailData) {
                Emails::create([
                    'user_id' => $user->id,
                    'email' => $emailData['email'],
                    'type' => $emailData['type'],
                ]);
            }


            foreach ($request->links as $linkData) {
                Links::create([
                    'user_id' => $user->id,
                    'link' => $linkData['link'],
                    'type' => $linkData['type'],
                ]);
            }

            foreach ($request->dates as $dateData) {
                Dates::create([
                    'user_id' => $user->id,
                    'date' => $dateData['date'],
                    'type' => $dateData['type'],
                ]);
            }

            foreach ($request->companies as $companyData) {
                Company::create([
                    'user_id' => $user->id,
                    'name' => $companyData['name'],
                    'address' => $companyData['address'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'User and related data stored successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {

            $user = User::findOrFail($id);

            $user->update($request->only(['first_name', 'last_name', 'notes']));

           
            Phone::where('user_id', $user->id)->delete();
            foreach ($request->phone as $phoneData) {
                Phone::create([
                    'user_id' => $user->id,
                    'number' => $phoneData['number'],
                    'type' => $phoneData['type'],
                ]);
            }

            Emails::where('user_id', $user->id)->delete();
            foreach ($request->emails as $emailData) {
                Emails::create([
                    'user_id' => $user->id,
                    'email' => $emailData['email'],
                    'type' => $emailData['type'],
                ]);
            }

            Links::where('user_id', $user->id)->delete();
            foreach ($request->links as $linkData) {
                Links::create([
                    'user_id' => $user->id,
                    'link' => $linkData['link'],
                    'type' => $linkData['type'],
                ]);
            }

            Dates::where('user_id', $user->id)->delete();
            foreach ($request->dates as $dateData) {
                Dates::create([
                    'user_id' => $user->id,
                    'date' => $dateData['date'],
                    'type' => $dateData['type'],
                ]);
            }

            Company::where('user_id', $user->id)->delete();
            foreach ($request->companies as $companyData) {
                Company::create([
                    'user_id' => $user->id,
                    'name' => $companyData['name'],
                    'address' => $companyData['address'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'User and related data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(null, 204);
    }
}
