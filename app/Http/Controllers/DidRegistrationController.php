<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DidRegistration;
use App\Http\Requests\StoreDidRegistrationRequest;
use App\Models\College;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class DidRegistrationController extends Controller
{
    public function store(StoreDidRegistrationRequest $request)
    {
            $data = $request->validated();

            // Extract possible email or phone
            $identifier = $data['phone_email'];
            
            // Try to find existing user
            $user = User::where('email', $identifier)
                        ->orWhere('phone', $identifier)
                        ->first();

            // If user doesn't exist, create one
            if (!$user) {
                $user = User::create([
                    'name'     => $data['name'],
                    'email'    => filter_var($identifier, FILTER_VALIDATE_EMAIL) ? $identifier : null,
                    'phone'    => preg_match('/^[0-9\+]+$/', $identifier) ? $identifier : null,
                    'password' => Hash::make('123456'), // Default password
                ]);
            }

            // Create registration
            $registration = DidRegistration::create([
                ...$data,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Registration successful.',
                'data'    => $registration,
            ], 201);
    }

    public function index()
    {
        $registrations = DidRegistration::with('user')->latest()->paginate(20);
        return response()->json($registrations);
    }

    public function show(DidRegistration $didRegistration)
    {
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

        $serial = DidRegistration::where('college_id', $profile->college_id)
                        ->where('session', $profile->session)
                        ->where('batch', $profile->batch)
                        ->count() + 1;

        $serialFormatted = str_pad($serial, 3, '0', STR_PAD_LEFT); // 001, 002...

        return "{$prefix}_{$collegeCode}_{$sessionCode}_{$serialFormatted}";
    }

}
