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
            $user = null;
            $input = $request->phone_email;
            $isAnonymous = $request->isAnonymous;

            if($isAnonymous){
                $donation = Donor::create($data);
                DB::commit();
                return response()->json([
                    'message'  => 'Donation created successfully',
                    'donation' => new DonationResource($donation),
                ], 201);
            }

            // ✅ Case 1: Authenticated user
            if (auth('sanctum')->check()) {
                $user = auth('sanctum')->user();
            }

            // ✅ Case 2: Resolve user by phone/email
            elseif (!empty($input)) {
                if (is_numeric($input)) {
                    $user = User::where('phone', $input)->first();
                } elseif (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $user = User::where('email', $input)->first();
                } else {
                    return response()->json([
                        'message' => 'Invalid phone or email format'
                    ], 422);
                }

                // ✅ If user doesn't exist, create
                if (!$user) {
                    $password = Str::random(8);

                    $user = User::create([
                        'name'     => $request->name ?? 'Donor',
                        'email'    => filter_var($input, FILTER_VALIDATE_EMAIL)
                                        ? $input
                                        : 'user_' . Str::uuid() . '@auto.com',
                        'phone'    => is_numeric($input) ? $input : null,
                        'password' => Hash::make($password),
                        'role'     => 'donor',
                    ]);

                    // Optional: send credentials to user via SMS/Email
                    // $this->sendSMS($user->phone, "Your login password: $password");
                }
            }

            // ✅ Attach user_id to donation data
            if ($user) {
                $data['user_id'] = $user->id;
            }

            $donation = Donor::create($data);

            DB::commit();

            return response()->json([
                'message'  => 'Donation created successfully',
                'donation' => new DonationResource($donation),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create donation',
                'error'   => config('app.debug') ? $e->getMessage() : 'Please try again later.'
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

    protected function resolveUserFromPhoneOrEmail(string $input, ?string $name = 'Donor'): User
    {
        if (is_numeric($input)) {
            return User::firstOrCreate(
                ['phone' => $input],
                [
                    'name'     => $name,
                    'email'    => 'user_' . Str::uuid() . '@auto.com',
                    'password' => Hash::make(Str::random(8)),
                    'role'     => 'donor',
                ]
            );
        } elseif (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return User::firstOrCreate(
                ['email' => $input],
                [
                    'name'     => $name,
                    'password' => Hash::make(Str::random(8)),
                    'role'     => 'donor',
                ]
            );
        }

        throw new \Exception('Invalid phone/email format');
    }


    
}
