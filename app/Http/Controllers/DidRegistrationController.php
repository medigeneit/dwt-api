<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DidRegistration;
use App\Http\Requests\StoreDidRegistrationRequest;
use App\Models\College;
use App\Models\OTP;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class DidRegistrationController extends Controller
{
    public function store(StoreDidRegistrationRequest $request)
    {
        $data = $request->validated();

        $email = $data['email'];
        $phone = $data['phone'];

        $user = User::where('email', $email)
                    ->orWhere('phone', $phone)
                    ->first();

        $code = rand(100000, 999999);

        if (!$user) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $email ?: null,
                'phone'    => $phone ?: null,
                'password' => Hash::make($code),
            ]);
        }

        // ✅ Create or update DidRegistration
        $registration = DidRegistration::updateOrCreate(
            ['user_id' => $user->id],
            [...$data, 'user_id' => $user->id]
        );

        // Send OTP
        if ($user->phone) {
            $otp = $this->generateAndSendOtp($user->phone, $code);
        }

        return response()->json([
            'message' => 'Registration successful. OTP sent if phone provided.',
            'data' => $registration,
        ], 201);
    }

    public function index()
    {
        $registrations = DidRegistration::with('user', 'college')->latest()->paginate(20);
        return response()->json($registrations);
    }

    public function show(DidRegistration $didRegistration)
    {
        $didRegistration->load('user', 'college');
        
        return response()->json($didRegistration);
    }

    public function update(DidRegistration $didRegistration)
    {
        $didRegistration->load('college');

        $didNumber = $this->generateDID($didRegistration);

        $didRegistration->did_number = $didNumber;

        $didRegistration->save();

        return response()->json([
            'message' => 'Registration updated successfully.',
            'data'    => $didRegistration,
        ]);
    }

    public function generateDID($profile)
    {
        $prefix = '1';
        
        $collegeCode = $profile->college->code ?? '000';

        $session = $profile->session;

        $sessionCode = '000';

        if ($session && preg_match('/\d{4}-\d{4}/', $session)) {
            $parts = explode('-', $session);
            $sessionCode = substr($parts[0], -3); // 2013-2014 → 014
        }

        $serial = DidRegistration::whereNotNull('did_number')->count() + 1;

        // $serial = DidRegistration::where('college_id', $profile->college_id)
        //                 ->where('session', $profile->session)
        //                 ->where('batch', $profile->batch)
        //                 ->count() + 1;

        $serialFormatted = str_pad($serial, 3, '0', STR_PAD_LEFT); // 001, 002...

        return "{$prefix}_{$collegeCode}_{$sessionCode}_{$serialFormatted}";
    }

    public function destroy(DidRegistration $didRegistration)
    {
        try {
            $didRegistration->delete();

            return response()->json([
                'message' => 'DID Registration deleted successfully.',
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the DID Registration.',
                'error' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }
    
    protected function generateAndSendOtp(string $phone, $code): string
    {
        

        // Save to database (Optional: expire after 5 mins)
        OTP::updateOrCreate(
            ['phone' => $phone],
            ['code' => $code, 'expires_at' => now()->addMinutes(5)]
        );

        // Send via SMS API (example only — replace with your real API)
        // Http::post('https://your-sms-api.com/send', [
        //     'to'   => $phone,
        //     'text' => "Your OTP is: $code",
        // ]);

        return $code;
    }


}
