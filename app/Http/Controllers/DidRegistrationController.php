<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DidRegistration;
use App\Http\Requests\StoreDidRegistrationRequest;
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

    public function update(Request $request, DidRegistration $didRegistration)
    {
        return
        $data = $request;

        $didRegistration->update($data);
        
        return response()->json([
            'message' => 'Registration updated successfully.',
            'data'    => $didRegistration,
        ]);
    }
}
