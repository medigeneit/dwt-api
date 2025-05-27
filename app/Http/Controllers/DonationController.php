<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
     public function index()
    {
        return response()->json(Donor::with('user')->paginate(20));
    }

    public function store(StoreDonationRequest $request)
    {

        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Default fallback
            $user = null;

            // ✅ Case 1: Authenticated user
            if (auth('sanctum')->check()) {
                $user = auth('sanctum')->user();
            }
            // ✅ Case 2: Unauthenticated, check existing user by phone
            elseif (!empty($request->phone)) {
                $existingUser = User::where('phone', $request->phone)->first();

                if ($existingUser) {
                    $user = $existingUser;
                } else {
                    $password = Str::random(8);
                    $user = User::create([
                        'name' => $request->name ?? 'Donor',
                        'email' => $request->phone . '@auto.com', // optional
                        'phone' => $request->phone,
                        'password' => Hash::make($password),
                        'role' => 'donor',
                    ]);

                    // Optional SMS
                    // $this->sendSMS($user->phone, \"Your login password: $password\");
                }
            }

            // ✅ Set user_id if user was resolved
            if ($user) {
                $data['user_id'] = $user->id;
            }

            $donation = Donor::create($data);

            DB::commit();

            return response()->json([
                'message' => 'Donation created successfully',
                'donation' => new DonationResource($donation),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create donation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        return response()->json(Donor::with('user')->findOrFail($id));
    }

    public function update(UpdateDonationRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $donation = Donor::findOrFail($id);
            $donation->update($request->validated());

            DB::commit();

            return response()->json([
                'message' => 'Donation updated successfully',
                'donation' => new DonationResource($donation),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update donation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        Donor::findOrFail($id)->delete();
        return response()->json(['message' => 'Donation deleted successfully']);
    }
}
