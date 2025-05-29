<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\DidRegistration;
use App\Models\Donor;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
         $userId = auth()->user()->id;

        $did_register = DidRegistration::where('user_id', $userId)->first();

        $donations = Donor::where('user_id', $userId)->get();

        return response()->json([
            'did_registration' => $did_register,
            'donations' => $donations,
        ]);
    }

    public function store(StoreProfileRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

             if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->store('profiles', 's3');
                Storage::disk('s3')->setVisibility($path, 'public');
                $data['image'] = Storage::disk('s3')->url($path);
            }

            $profile = Profile::create($data);

            DB::commit();

            return response()->json([
                'message' => 'Profile created successfully',
                'profile' => new ProfileResource($profile),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Profile creation failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $profile = Profile::with(['user', 'college'])->findOrFail($id);
        return response()->json($profile);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $profile = Profile::findOrFail($id);
            
            $data = $request->validated();

            if ($request->hasFile('image')) {
                // delete previous from s3
                if ($profile->image) {
                    $parsedUrl = parse_url($profile->image, PHP_URL_PATH); // e.g. /profiles/abc.jpg
                    $fileKey = ltrim($parsedUrl, '/'); // remove leading slash
                    if (Storage::disk('s3')->exists($fileKey)) {
                        Storage::disk('s3')->delete($fileKey);
                    }
                }

                $path = $request->file('image')->store('profiles', 's3');
                $data['image'] = Storage::disk('s3')->url($path);
            }

            $profile->update($data);

            DB::commit();

            return response()->json([
                'message' => 'Profile updated successfully',
                'profile' => new ProfileResource($profile),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        Profile::findOrFail($id)->delete();
        return response()->json(['message' => 'Profile deleted successfully']);
    }
}
